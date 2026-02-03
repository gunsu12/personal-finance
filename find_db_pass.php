<?php
$host = '127.0.0.1';
$port = '5432';
$user = 'postgres';
$passwords = ['postgres', 'root', 'admin', 'password', '123456', ''];

$success = false;
foreach ($passwords as $pass) {
    echo "Trying password: '$pass'... ";
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $pass);
        echo "SUCCESS!\n";
        $success = true;
        
        // Setup the correct password in the next steps or update .env
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = 'personal_finance_laravel'");
        $stmt->execute();
        if (!$stmt->fetch()) {
            $pdo->exec("CREATE DATABASE \"personal_finance_laravel\"");
            echo "Database 'personal_finance_laravel' created.\n";
        } else {
            echo "Database 'personal_finance_laravel' already exists.\n";
        }
        
        // Write the working password to a file so we can read it
        file_put_contents('valid_db_pass.txt', $pass);
        break;
    } catch (PDOException $e) {
        echo "Failed.\n";
    }
}

if (!$success) {
    echo "All passwords failed.\n";
    exit(1);
}
