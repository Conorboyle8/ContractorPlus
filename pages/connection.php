<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cm";

if (!$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Connection failed: " . $conn->connect_error);
}