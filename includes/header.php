<?php
require_once 'init.php';
?>
<style>
	.release {
		float: right;
	}
</style>
<div id="header">
	<div class="release">
		RA v.<?=release()?>
	</div>
	<?php echo $host; ?>:<?php echo $port; ?>
	<?php if (getenv('REDIS_LOGIN')): ?>
		<button onclick="location.href='logout.php'">Logout</button>
	<?php endif; ?>
</div>
<hr style="margin-bottom: 1rem;">
