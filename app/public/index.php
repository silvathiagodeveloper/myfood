<?php

$pdo = new PDO("mysql:dbname=".getenv("MYSQL_DATABASE").";host=mysql", getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$query = $pdo->query('SHOW VARIABLES like "version"');

$row = $query->fetch();

echo 'MySQL version:' . $row['Value'];