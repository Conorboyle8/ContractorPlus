<?php
session_start();

include 'connection.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        $query = "SELECT * FROM users WHERE user_name = '$user_name' limit 1";
        $result = mysqli_query($conn, $query);

        if ($result)
        {
            if ($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] === $password)
                {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: dashboard.php");
                    die;
                }
            }
        }
        echo "Wrong username or password!";
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
    <title>Sign In</title>
</head>
<body>
    <div id="box">
        <form method = "post">
            <div id="header">
                <h4>Sign In</h4>
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Sign In">
            <a href="signUp.php">Sign Up</a>
        </form>
</body>
</html>
