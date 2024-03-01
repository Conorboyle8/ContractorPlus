<?php 
session_start();
include('NavBar.php'); 
require_once('../assets/includes/classes/Database.php');
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Client</title>
</head>
<body>
<?php
// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address= $_POST['address'];
    $user_id = $user_data['user_id'];

    $success = $database->addNewclient($firstName, $lastName, $email, $phoneNumber, $address, $user_id);

    if ($success) {
        echo "Client added successfully!";
    } else {
        echo "Error adding client.";
    }
}
?>

<div class="container-fluid py-4">
        <h4>Add New Client</h4>
        <form method="post" action="">
            <div>
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName">
            </div>

            <div>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName">


            <div>
                <label for="email">Email:</label>
                <input type="text" name="email">
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber">
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address">
            </div>

            <div>
                <button type="submit">Add Client</button>
            </div>
        </form>
    </div>

    </body>

    </html>