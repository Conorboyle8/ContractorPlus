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
    $distance = $_POST['distance'];
    $sqft= $_POST['sqft'];
    $expenses = $_POST['expenses'];
    $daysWorked = $_POST['daysWorked'];
    $paymentMethod = $_POST['paymentMethod'];
    $revenue = $_POST['revenue'];
    $status = $_POST['status'];
    $userID = $_SESSION['userID'];

    $success = $database->addNewJob($clientName, $jobName, $address, $phoneNumber, $distance, $sqft, $expenses, $daysWorked, $paymentMethod, $revenue, $status, $userID);

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
                <label for="distance">Distance To:</label>
                <input type="text" name="distance" required>
            </div>

            <div>
                <label for="sqft">SQFT:</label>
                <input type="text" name="sqft" required>
            </div>

            <div>
                <label for="expenses">Expenses:</label>
                <input type="text" name="expenses" required>
            </div>

            <div>
                <label for="daysWorked">Days Worked:</label>
                <input type="text" name="daysWorked" required>
            </div>

            <div>
                <label for="paymentMethod">Payment Method:</label>
                <select name="paymentMethod" required>
                    <option value="Cash">Cash</option>
                    <option value="Check">Check</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div>
                <label for="revenue">Revenue:</label>
                <input type="text" name="revenue" required>
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Active">Active</option>
                    <option value="Pending Payment">Pending Payment</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <div>
                <button type="submit">Add Job</button>
            </div>
        </form>
    </div>

    </body>

    </html>