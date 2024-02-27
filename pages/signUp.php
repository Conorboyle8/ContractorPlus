<?php
session_start();

include 'connection.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $comp_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $img_name = $_FILES['img']['name'];
    $img_temp = $_FILES['img']['tmp_name'];

    // Read the contents of the image file
    $img_data = file_get_contents($img_temp);
    $img_data = mysqli_real_escape_string($conn, $img_data);
}

if (!empty($user_name) && !empty($password) && !empty($address) && !empty($email) && !empty($phone_number) && !empty($comp_name)) {
    $user_id = random_num(20);

    $query = "INSERT INTO users (user_id, user_name, password, full_name, email, phone_number, comp_name, address, img) 
              VALUES ('$user_id', '$user_name', '$password', '$full_name', '$email', '$phone_number', '$comp_name', '$address', '$img_data')";


    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        header("Location: login.php");
        die;
    }
} else {
    echo "Please enter some valid information!";
}

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }
    $len = rand(4, $length);
    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
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
        <form method="post" enctype="multipart/form-data">
            <div id="header">
                <h4>Sign Up</h4>
                <input type="text" name="user_name" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="text" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="text" name="comp_name" placeholder="Company Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="file" name="img" required>

                <input type="submit" value="Sign Up">
                <a href="login.php">Log In</a>
            </div>
        </form>
    </div>
</body>
</html>
