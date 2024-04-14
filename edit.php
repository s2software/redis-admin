<?php
require_once 'includes/config.php';

$redis = new Redis();
$redis->connect($host, $port);
if ($password)
	$redis->auth($password);

$saved = FALSE;
$unlinked = FALSE;
if (!empty($_POST['save']) && !empty($_POST['key']))
{
	$db = 0;
	if (!empty($_POST['db'])) {
		$db = $_POST['db'];
	}
	$redis->select($db);
	
	$key = $_POST['key'];
	$value = $_POST['value'];
	$ttl = $_POST['ttl'] ? (int)$_POST['ttl'] : NULL;
	$unlink = $_POST['unlink'] ?? FALSE;
	$lPush = $_POST['lPush'] ?? FALSE;
	$rPush = $_POST['rPush'] ?? FALSE;
	if ($unlink)
	{
		$unlinked = $redis->unlink($key);
	}
	else
	{
		if ($lPush || $rPush)
		{
			if ($lPush)
				$saved = $redis->lPush($key, $value);
			if ($rPush)
				$saved = $redis->rPush($key, $value);
			if (is_numeric($ttl))
				$redis->expire($key, $ttl);
			else
				$redis->persist($key);
		}
		else
		{
			$saved = $redis->set($key, $value, $ttl);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>s2s redis-admin - Insert/Update</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php require 'includes/header.php'; ?>

<h3>Insert/Update Key</h3>

<p>
	back to <a href="index.php">Search</a>
</p>

<?php if ($saved): ?>
	<p style="font-weight: bold; color: green;">
		Db <?php echo $db ?> -
		Key "<?php echo $key ?>" with Value "<?php echo $value ?>" saved
		<?php if ($ttl): ?>
			with TTL <?php echo $ttl ?> seconds
		<?php else: ?>
			without a TTL
		<?php endif; ?>
	</p>
<?php endif; ?>
<?php if ($unlinked): ?>
	<p style="font-weight: bold; color: green;">
		Db <?php echo $db ?> -
		Key "<?php echo $key ?>" has been REMOVED
	</p>
<?php endif; ?>

<form method="post" autocomplete="off">
	<input type="text" name="db" placeholder="Db" value="<?php echo @$db ?>" style="width: 2rem;">
	<br><br>
	<input type="text" name="key" placeholder="Key" value="<?php echo @$key ?>">
	<br><br>
	<textarea name="value" placeholder="Value" rows="4" cols="50" style="max-width: 100%;"><?php echo @$value ?></textarea>
	<br><br>
	<input type="text" name="ttl" placeholder="TTL" value="<?php echo @$ttl ?>" style="width: 3rem;">
	<br><br>
	<label><input type="checkbox" name="unlink" value="1" <?php echo @$unlink?'checked':''?>> Unlink (select to remove key)</label>
	<br>
	<label><input type="checkbox" name="lPush" value="1" <?php echo @$lPush?'checked':''?>> lPush (select to lPush to key)</label>
	<br>
	<label><input type="checkbox" name="rPush" value="1" <?php echo @$rPush?'checked':''?>> rPush (select to rPush to key)</label>
	<br><br>
	<input type="submit" name="save" value="Save" style="font-size: 1rem; font-weight: bold;">
</form>

<script>
$(function() {
});
</script>
</body>
</html>