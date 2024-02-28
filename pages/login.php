<?php
session_start();

include 'connection.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #box {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
        }

        #header {
            text-align: center;
            margin-bottom: 20px;
        }

        #header h4 {
            margin: 0;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            color: #333;
            text-decoration: none;
            margin-top: 10px;
        }

        /* Center and style error message */
        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div id="box">
        <form method="post">
            <div id="header">
                <h4>Sign In</h4>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];
                if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
                    $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $user_data = mysqli_fetch_assoc($result);
                        if ($user_data['password'] === $password) {
                            $_SESSION['user_id'] = $user_data['user_id'];
                            header("Location: dashboard.php");
                            die;
                        }
                    }
                    echo '<div class="error-message">Wrong username or password!</div>';
                } else {
                    echo '<div class="error-message">Please enter some valid information!</div>';
                }
            }
            ?>
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Sign In">
            <a href="signUp.php">Sign Up</a>
        </form>
    </div>
</body>

</html>
