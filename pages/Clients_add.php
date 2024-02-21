<!-- addJob.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Client</title>
</head>
<body>

<?php include('NavBar.php'); 
require_once('../assets/includes/classes/Database.php');

// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $clientName = $_POST['clientName']; // Update with your actual form field names
    $contactPerson = $_POST['contactPerson'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address= $_POST['address'];

    $success = $database->addNewclient($clientName, $contactPerson, $email, $phoneNumber, $address);

    if ($success) {
        echo "Client added successfully!";
    } else {
        echo "Error adding client.";
    }
}
?>

<div class="container-fluid py-4">
        <h4>Add New Client</h4>
        <!-- Add your form here -->
        <form method="post" action="">
            <!-- Add your form fields here -->
            <div>
                <label for="clientName">Client Name:</label>
                <input type="text" name="clientName" required>
            </div>

            <div>
                <label for="contactPerson">Contact Person:</label>
                <input type="text" name="contactPerson" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="text" name="email" required>
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" required>
            </div>

            <div>
                <button type="submit">Add Job</button>
            </div>
        </form>
    </div>

    </body>

    </html>