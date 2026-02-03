<?php
$host = '127.0.0.1';
$port = '5432';
$db = 'postgres';
$user = 'postgres';
$pass = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Check if database exists
    $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = 'personal_finance_laravel'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $pdo->exec("CREATE DATABASE \"personal_finance_laravel\"");
        echo "Database 'personal_finance_laravel' created successfully.\n";
    } else {
        echo "Database 'personal_finance_laravel' already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
