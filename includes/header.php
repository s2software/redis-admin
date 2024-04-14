<?php
require_once 'config.php';
?>
<div id="header">
	<?php echo $host; ?>:<?php echo $port; ?>
	<?php if (getenv('REDIS_LOGIN')): ?>
		<button onclick="location.href='logout.php'">Logout</button>
	<?php endif; ?>
</div>
<hr style="margin-bottom: 1rem;">
