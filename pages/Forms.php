<?php 
session_start();
include('NavBar.php');
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['user_name'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forms</title>
</head>
<body>

