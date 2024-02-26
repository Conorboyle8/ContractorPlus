<?php
session_start();

    include 'connection.php';
    include 'functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $comp_name = $_POST['comp_name'];
        $address = $_POST['address'];
        $img = '';
        if(isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $img = uploadImage($_FILES['img']);
        }
        if(!empty($user_name) && !empty($password) && !empty($address) && !empty($email) && !empty($phone_number) && !empty($comp_name)){
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, user_name, password, full_name, email, phone_number, comp_name, address, img) VALUES ('$user_id', '$user_name', '$password', '$full_name', '$email', '$phone_number', '$comp_name', '$address', '$img')";
            mysqli_query($conn, $query);
            header("Location: login.php");
            die;
        } else {
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
    function uploadImage($file) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if image file is a valid image
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            echo "File is not a valid image.";
            $uploadOk = 0;
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
    
        // Check file size
        if ($file["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // Echo the path for debugging purposes
                echo "Image path: " . $target_file;
    
                // Return the relative path instead of the absolute path
                return $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
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
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <input type="text" name="comp_name" placeholder="Company Name" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="file" name="img" required>

            <input type="submit" value="Sign Up">
            <a href="login.php">Log In</a>
        </form>
</body>
</html>
