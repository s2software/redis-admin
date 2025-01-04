<?php
// Connection Data
$host = getenv('REDIS_HOST') ?: '127.0.0.1';
$port = getenv('REDIS_PORT') ?: 6379;
$password = getenv('REDIS_PASSWORD') ?: '';

// Connection Data from login
$login = getenv('REDIS_LOGIN') ?: FALSE;
