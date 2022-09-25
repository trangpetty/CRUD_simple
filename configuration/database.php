<?php 
    define('DATABASE_SERVER', 'localhost');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASSWORD', '');
    define('DATABASE_NAME', 'phpapp');
    $connect = null;
    try {
        $connect = new PDO(
            "mysql:host=".DATABASE_SERVER.";dbname=".DATABASE_NAME, 
            DATABASE_USER, DATABASE_PASSWORD);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connected failed: " . $e->getMessage();
        $connect = null;
    }
?>