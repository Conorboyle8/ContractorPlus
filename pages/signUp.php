<!-- addJob.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Client</title>
</head>
<body>

<?php
require_once('../assets/includes/classes/Database.php');

// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $userName = $_POST['userName']; // Update with your actual form field names
    $password = $_POST['password'];

    $success = $database->addNewUser($userName, $password);

    if ($success) {
        echo "Client added successfully!";
    } else {
        echo "Error adding client.";
    }
}
?>

<div class="container-fluid py-4">
        <h4>Create Account</h4>
        <form method="post" action="">
            <div>
                <label for="userName">User Name:</label>
                <input type="text" name="userName" required>
            </div>
            
            <div>
                <label for="password">Password:</label>
                <input type="text" name="password" required>
            </div>

            <div>
                <button type="submit">Add User</button>
            </div>
        </form>
    </div>

    </body>

    </html>