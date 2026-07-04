<?php

$host = "sql206.byetcluster.com";
$username = "if0_42337598";
$password = "r7itJtYEf3bMb7";
$database = "if0_42337598_studyflow_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}