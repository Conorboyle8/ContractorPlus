<!-- addJob.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Job</title>
</head>
<body>

<?php include('NavBar.php'); 
require_once('../assets/includes/classes/Database.php');

// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $clientName = $_POST['clientName']; // Update with your actual form field names
    $jobName = $_POST['jobName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $jobSize = $_POST['jobSize'];
    $status = $_POST['status'];

    $success = $database->addNewJob($clientName, $jobName, $address, $phoneNumber, $jobSize, $status);

    if ($success) {
        echo "Job added successfully!";
    } else {
        echo "Error adding job.";
    }
}
?>

<div class="container-fluid py-4">
        <h4>Add New Job</h4>
        <!-- Add your form here -->
        <form method="post" action="">
            <!-- Add your form fields here -->
            <div>
                <label for="clientName">Client Name:</label>
                <input type="text" name="clientName" required>
            </div>

            <div>
                <label for="jobName">Job Name:</label>
                <input type="text" name="jobName" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" required>
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" required>
            </div>

            <div>
                <label for="jobSize">Size:</label>
                <input type="text" name="jobSize" required>
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="pending">Pending Payment</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <div>
                <button type="submit">Add Job</button>
            </div>
        </form>
    </div>

    </body>

    </html>