<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['user_name'];
    // Move the require_once statement outside of the PHP block
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    $clientID = isset($_GET['clientID']) ? $_GET['clientID'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Client</title>
</head>
<body>

<?php 
require_once('../assets/includes/classes/Database.php');
$clientData = $database->getclientByID($clientID)->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $updatedData = array(
        'ClientName' => $_POST['clientName'],
        'ContactPerson' => $_POST['contactPerson'],
        'Email' => $_POST['email'],
        'PhoneNumber' => $_POST['phoneNumber'],
        'Address' => $_POST['address'],
    );
    $database->updateClient($clientID, $updatedData);
}
?>

<div class="container-fluid py-4">
        <h4>Edit Client</h4>
        <form method="post" action="">
            <div>
                <label for="clientName">Client Name:</label>
                <input type="text" name="clientName" value="<?php echo isset($clientData['ClientName']) ? $clientData['ClientName'] : ''; ?>" required>
            </div>

            <div>
                <label for="contactPerson">Contact Person:</label>
                <input type="text" name="contactPerson" value="<?php echo isset($jobData['ContactPerson']) ? $jobData['ContactPerson'] : ''; ?>" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo isset($jobData['Email']) ? $jobData['Email'] : ''; ?>" required>
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" value="<?php echo isset($clientData['PhoneNumber']) ? $clientData['PhoneNumber'] : ''; ?>" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo isset($clientData['Address']) ? $clientData['Address'] : ''; ?>" required>
            </div>

            <div>
                <button type="submit">Submit Changes</button>
            </div>
        </form>
    </div>
    </body>

    </html>