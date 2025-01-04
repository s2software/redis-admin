<?php
require_once 'includes/config.php';
if (!$login)
{
	exit('Login disabled - set .env REDIS_LOGIN=1 to enable login screen');
}

session_start();
$host = @$_SESSION['host'] ? $_SESSION['host'] : getenv('REDIS_HOST');
$port = @$_SESSION['port'] ? $_SESSION['port'] : getenv('REDIS_PORT');
$password = @$_SESSION['password'] ? $_SESSION['password'] : getenv('REDIS_PASSWORD');

if (!empty($_POST['login']))
{
	$host = $_SESSION['host'] = $_POST['host'];
	$port = $_SESSION['port'] = $_POST['port'];
	$password = $_SESSION['password'] = $_POST['password'];

	try {
		$redis = new Redis();
		$redis->connect($host, $port);
		if ($password)
			$redis->auth($password);
		$_SESSION['logged'] = true;
		header('Location: index.php');
		exit;
	} catch (Exception $e) {
		echo 'Error: ', $e->getMessage();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>s2s redis-admin</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<style>
		form input {
			margin-bottom: 0.25rem;
		}
	</style>
</head>
<body>

<h3>Redis Admin - Login</h3>

<form method="post">
	<input type="text" name="host" value="<?php echo @$host; ?>" placeholder="Host" style="width: 15rem;">
	<input type="text" name="port" value="<?php echo @$port ? $port : '6379'; ?>" placeholder="Port" style="width: 2rem;"><br>
	<input type="password" name="password" value="<?php echo @$password; ?>" placeholder="Password"><br>
	<input type="submit" name="login" value="Login">
</form>

</body>
</html>