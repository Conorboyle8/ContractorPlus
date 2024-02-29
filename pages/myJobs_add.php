<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
require_once('../assets/includes/classes/Database.php');
$database = new Database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Job</title>
</head>
<body>

<?php
// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $clientName = $_POST['clientName']; // Update with your actual form field names
    $jobName = $_POST['jobName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $distance = $_POST['distance'];
    $sqft = $_POST['sqft'];
    $laborCost = $_POST['laborCost'];
    $materialCost = $_POST['materialCost'];
    $daysWorked = $_POST['daysWorked'];
    $paymentMethod = $_POST['paymentMethod'];
    $revenue = $_POST['revenue'];
    $status = $_POST['status'];
    $startDate = $_POST['startDate'];
    $completeDate = $_POST['completeDate'];
    $user_id = $user_data['user_id'];
    $profit = $revenue - $laborCost - $materialCost;

    $success = $database->addNewJob($clientName, $jobName, $address, $phoneNumber, $distance, $sqft, $revenue, $laborCost, $materialCost, $profit, $daysWorked, $paymentMethod, $status, $startDate, $completeDate, $user_id);
    if ($success) {
        echo "Job added successfully! Add another?";
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
                <label for="distance">Miles To Site:</label>
                <input type="text" name="distance" required>
            </div>

            <div>
                <label for="sqft">SQFT:</label>
                <input type="text" name="sqft" required>
            </div>

            <div>
                <label for="revenue">Revenue:</label>
                <input type="text" name="revenue" required>
            </div>

            <div>
                <label for="laborCost">Labor Cost:</label>
                <input type="text" name="laborCost" required>
            </div>

            <div>
                <label for="materialCost">Material Cost:</label>
                <input type="text" name="materialCost" required>
            </div>

            <div>
                <label for="daysWorked">Days Worked:</label>
                <input type="text" name="daysWorked" required>
            </div>

            <div>
                <label for="paymentMethod">Payment Method:</label>
                <select name="paymentMethod" required>
                    <option value=""></option>
                    <option value="Cash">Cash</option>
                    <option value="Check">Check</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            
            <div>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value=""></option>
                    <option value="Active">Active</option>
                    <option value="Pending Payment">Pending Payment</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <div>
                <label for="startDate">Start Date:</label>
                <input type="date" name="startDate" required>
            </div>

            <div>
                <label for="completeDate">Complete Date:</label>
                <input type="date" name="completeDate" required>
            </div>

            <div>
                <button type="submit">Add Job</button>
            </div>
        </form>
    </div>

    </body>

    </html>