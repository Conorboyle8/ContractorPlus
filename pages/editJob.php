<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
require_once('../assets/includes/classes/Database.php');
$database = new Database();
$jobID = isset($_GET['jobID']) ? $_GET['jobID'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
</head>
<body>
<?php 

require_once('../assets/includes/classes/Database.php');
$jobData = $database->getJobByID($jobID)->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $updatedData = array(
        'FirstName' => $_POST['firstName'],
        'LastName' => $_POST['lastName'],
        'JobName' => $_POST['jobName'],
        'Address' => $_POST['address'],
        'PhoneNumber' => $_POST['phoneNumber'],
        'Distance' => $_POST['distance'],
        'SQFT' => $_POST['sqft'],
        'Revenue' => $_POST['revenue'],
        'LaborCost' => $_POST['laborCost'],
        'MaterialCost' => $_POST['materialCost'],
        'Profit' => $_POST['revenue'] - $_POST['laborCost'] - $_POST['materialCost'], // Calculate profit
        'DaysWorked' => $_POST['daysWorked'],
        'PaymentMethod' => $_POST['paymentMethod'],
        'Status' => $_POST['status'],
        'StartDate' => $_POST['startDate'],
        'CompleteDate' => $_POST['completeDate']
    );
    $database->updateJob($jobID, $updatedData);
    echo '<script>window.location.href = "myJobs.php";</script>';
}
?>

<div class="container-fluid py-4">
        <h4>Edit Job</h4>
        <form method="post" action="">
            <div>
                <label for="FirstName">First Name:</label>
                <input type="text" name="firstName" value="<?php echo isset($jobData['FirstName']) ? $jobData['FirstName'] : ''; ?>" required>
            </div>

            <div>
                <label for="LastName">Last Name:</label>
                <input type="text" name="lastName" value="<?php echo isset($jobData['LastName']) ? $jobData['LastName'] : ''; ?>" required>
            </div>

            <div>
                <label for="jobName">Job Name:</label>
                <input type="text" name="jobName" value="<?php echo isset($jobData['JobName']) ? $jobData['JobName'] : ''; ?>" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo isset($jobData['Address']) ? $jobData['Address'] : ''; ?>" required>
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" value="<?php echo isset($jobData['PhoneNumber']) ? $jobData['PhoneNumber'] : ''; ?>" required>
            </div>

            <div>
                <label for="distance">Miles to:</label>
                <input type="text" name="distance" value="<?php echo isset($jobData['Distance']) ? $jobData['Distance'] : ''; ?>" required>
            </div>

            <div>
                <label for="sqft">SQFT:</label>
                <input type="text" name="sqft" value="<?php echo isset($jobData['SQFT']) ? $jobData['SQFT'] : ''; ?>" required>
            </div>

            <div>
                <label for="revenue">Revenue:</label>
                <input type="text" name="revenue" value="<?php echo isset($jobData['Revenue']) ? $jobData['Revenue'] : ''; ?>" required>
            </div>

            <div>
                <label for="laborCost">Labor Cost:</label>
                <input type="text" name="laborCost" value="<?php echo isset($jobData['LaborCost']) ? $jobData['LaborCost'] : ''; ?>" required>
            </div>

            <div>
                <label for="materialCost">Material Cost:</label>
                <input type="text" name="materialCost" value="<?php echo isset($jobData['MaterialCost']) ? $jobData['MaterialCost'] : ''; ?>" required>
            </div>

            <div>
                <label for="daysWorked">Days Worked:</label>
                <input type="text" name="daysWorked" value="<?php echo isset($jobData['DaysWorked']) ? $jobData['DaysWorked'] : ''; ?>" required>
            </div>

            <div>
                <label for="paymentMethod">Payment Method:</label>
                <select name="paymentMethod" required>
                    <option value="Cash" <?php echo ($jobData['PaymentMethod'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                    <option value="Check" <?php echo ($jobData['PaymentMethod'] == 'Check') ? 'selected' : ''; ?>>Check</option>
                    <option value="Pending" <?php echo ($jobData['PaymentMethod'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Active" <?php echo ($jobData['Status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Pending Payment" <?php echo ($jobData['Status'] == 'Pending Payment') ? 'selected' : ''; ?>>Pending Payment</option>
                    <option value="Paid" <?php echo ($jobData['Status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                </select>
            </div>

            <div>       
                <label for="startDate">Start Date:</label>
                <input type="date" name="startDate" value="<?php echo isset($jobData['startDate']) ? $jobData['startDate'] : ''; ?>" required>
            </div>

            <div>
                <label for="completeDate">Complete Date:</label>
                <input type="date" name="completeDate" value="<?php echo isset($jobData['completeDate']) ? $jobData['completeDate'] : ''; ?>">
            </div>


            <div>
                <button type="submit">Submit Changes</button>
            </div>
        </form>
    </div>
    </body>

    </html>