<?php
// Connection Data ----------
$host = getenv('REDIS_HOST') ? getenv('REDIS_HOST') : '127.0.0.1';
$port = getenv('REDIS_PORT') ? getenv('REDIS_PORT') : 6379;
$password = getenv('REDIS_PASSWORD') ? getenv('REDIS_PASSWORD') : '';
// --------------------------

// Connection Data from Login screen ---
if (getenv('REDIS_LOGIN'))
{
	session_start();
	if (empty($_SESSION['logged']))
	{
		header('Location: login.php');
		exit;
	}
	$host = $_SESSION['host'];
	$port = $_SESSION['port'];
	$password = $_SESSION['password'];
}
// -------------------------------------
