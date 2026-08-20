<?php
// Database configuration - automatically detects environment

// Check if running in Docker or local environment
$host = getenv('MYSQL_HOST') ?: 'localhost';
$port = getenv('MYSQL_PORT') ?: '3306';
$database = getenv('MYSQL_DATABASE') ?: 'request_system';
$username = getenv('MYSQL_USER') ?: 'root';
$password = getenv('MYSQL_PASSWORD') ?: '';

return [
    'host' => $host,
    'port' => $port,
    'database' => $database,
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8mb4'
];