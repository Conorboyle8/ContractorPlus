<?php 
session_start();
include('NavBar.php'); 
require_once('../assets/includes/classes/Database.php');
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['full_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Invoice</title>
</head>
<body>
<?php
// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $client_fname = $_POST['client_fname'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $Amount = $_POST['Amount'];
    $user_id = $user_data['user_id'];

    $success = $database->addNewInvoice($client_fname, $address, $description, $Amount, $user_id);

    if ($success) {
        echo "Invoice added successfully!";
    } else {
        echo "Error adding Invoice.";
    }
}
?>

<div class="container-fluid py-4">
        <h4>Add New Client</h4>
        <!-- Add your form here -->
        <form method="post" action="">
            <!-- Add your form fields here -->
            <div>
                <label for="client_fname">Client First Name:</label>
                <input type="text" name="client_fname" required>
            </div>

            <div>
                <label for="address">Job Address:</label>
                <input type="text" name="address" required>
            </div>

            <div>
                <label for="description">Description:</label>
                <input type="text" name="description" required>
            </div>

            <div>
                <label for="Amount">Total labor + Materials:</label>
                <input type="text" name="Amount" required>
            </div>

            <div>
                <button type="submit">Add Client</button>
            </div>
        </form>
    </div>

    </body>

    </html>