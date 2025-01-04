<?php
require_once 'includes/init.php';

$redis = new Redis();
$redis->connect($host, $port);
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
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php require 'includes/header.php'; ?>

<form method="get" autocomplete="off">
	<input type="text" name="db" value="<?php echo $db; ?>" placeholder="db" style="width: 2rem;">
	<input type="text" name="q" value="<?php echo $q; ?>" placeholder="eg.: user:*">
	<input type="submit" value="Search">
</form>
<p>
	or <a href="edit.php">Insert/Edit Key</a>
</p>

<?php if ($q): ?>
	<h3>Search results <small>(key value TTL)</small>:</h3>
	<p>
		<em><?php echo count($keys); ?> results</em>
	</p>
<?php endif; ?>
<code>
	<?php foreach ($keys as $key): ?>
		<span style="color: blue;"><?php echo $key; ?></span>
		<?php if ($redis->type($key) == Redis::REDIS_LIST): ?>
			<span style="color: blue;">(list) TTL: <?php echo $redis->ttl($key); ?></span>
			<?php if ($items = $redis->lrange($key, 0, -1)): ?>
				<?php foreach($items as $item): ?>
					<br><span style="color: blue;">-</span> <?php echo $item; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php else: ?>
			<?php echo $redis->get($key); ?>
			<span style="color: blue;">TTL: <?php echo $redis->ttl($key); ?></span>
		<?php endif; ?>
		<br>
	<?php endforeach; ?>
</code>

<script>
$(function() {
	$('[name="db"]').on('focus', function () {
		$(this).select();
	});
});
</script>
</body>
</html>