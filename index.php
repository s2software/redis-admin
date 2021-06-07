<?php
require 'config.php';

$redis = new Redis();
$redis->connect($host, 6379);
if ($password)
	$redis->auth($password);

$db = 0;
if (!empty($_GET['db'])) {
	$db = $_GET['db'];
}
$redis->select($db);

$q = '';
$keys = [];
if (!empty($_GET['q'])) {
	$q = $_GET['q'];
	$keys = $redis->keys($q);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>s2s redis-admin</title>
	<meta charset="utf-8">
</head>
<body>

<form method="get" autocomplete="off">
	<input type="text" id="fname" name="db" value="<?php echo $db; ?>" placeholder="db" style="width: 2rem;">
	<input type="text" id="fname" name="q" value="<?php echo $q; ?>" placeholder="eg.: user:*">
	<input type="submit" value="Search">
</form>

<?php if ($q): ?>
	<h3>Search results <small>(key value TTL)</small>:</h3>
	<p>
		<em><?php echo count($keys); ?> results</em>
	</p>
<?php endif; ?>
<code>
	<?php foreach ($keys as $key): ?>
		<span style="color: blue;"><?php echo $key; ?></span>
		<?php echo $redis->get($key); ?>
		<span style="color: blue;">TTL: <?php echo $redis->ttl($key); ?></span>
		<br>
	<?php endforeach; ?>
</code>

</body>
</html>