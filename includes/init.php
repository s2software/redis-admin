<?php
require_once 'includes/config.php';

// Connection Data from Login screen
if ($login)
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
