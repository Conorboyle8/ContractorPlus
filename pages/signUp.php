<?php
session_start();

    include 'connection.php';
    include 'functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        if(!empty($user_name) && !empty($password) && !is_numeric($user_name)){
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$password')";
            mysqli_query($conn, $query);
            header("Location: login.php");
            die;
        }else{
            echo "Please enter some valid information!";
        }
    }
    function random_num($length){
        $text = "";
        if($length < 5){
            $length = 5;
        }
        $len = rand(4, $length);
        for ($i=0; $i < $len; $i++) { 
            $text .= rand(0,9);
        }
        return $text;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
    <div id="box">
        <form method = "post">
            <div id="header">
                <h4>Sign Up</h4>
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Sign Up">
            <a href="login.php">Log In</a>
        </form>
</body>
</html>
