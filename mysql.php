<?php
    $host = "localhost";
    $dbname = "warko_db";
    $dbuser = "root";
    $dbpass = "";

    $allowedTableNames = [
        "orders",
        "products",
    ];

    try {
        $mysql = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        die("Database connection failed: " . $$mysql->connect_error);
    }
