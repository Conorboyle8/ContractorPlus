<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['user_name'];
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    $jobID = isset($_GET['jobID']) ? $_GET['jobID'] : '';
    echo $jobID;
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
        'ClientName' => $_POST['clientName'],
        'JobName' => $_POST['jobName'],
        'Address' => $_POST['address'],
        'PhoneNumber' => $_POST['phoneNumber'],
        'Distance' => $_POST['distance'],
        'SQFT' => $_POST['sqft'],
        'Expenses' => $_POST['expenses'],
        'DaysWorked' => $_POST['daysWorked'],
        'PaymentMethod' => $_POST['paymentMethod'],
        'Revenue' => $_POST['revenue'],
        'Status' => $_POST['status'],
    );
    $database->updateJob($jobID, $updatedData);
}
?>

<div class="container-fluid py-4">
        <h4>Edit Job</h4>
        <form method="post" action="">
            <div>
                <label for="clientName">Client Name:</label>
                <input type="text" name="clientName" value="<?php echo isset($jobData['ClientName']) ? $jobData['ClientName'] : ''; ?>" required>
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
                <label for="distance">Distance To:</label>
                <input type="text" name="distance" value="<?php echo isset($jobData['Distance']) ? $jobData['Distance'] : ''; ?>" required>
            </div>

            <div>
                <label for="sqft">SQFT:</label>
                <input type="text" name="sqft" value="<?php echo isset($jobData['SQFT']) ? $jobData['SQFT'] : ''; ?>" required>
            </div>

            <div>
                <label for="expenses">Expenses:</label>
                <input type="text" name="expenses" value="<?php echo isset($jobData['Expenses']) ? $jobData['Expenses'] : ''; ?>" required>
            </div>

            <div>
                <label for="daysWorked">Days Worked:</label>
                <input type="text" name="daysWorked" value="<?php echo isset($jobData['DaysWorked']) ? $jobData['DaysWorked'] : ''; ?>" required>
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
                <input type="text" name="revenue" value="<?php echo isset($jobData['Revenue']) ? $jobData['Revenue'] : ''; ?>" required>
            <div>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Active">Active</option>
                    <option value="Pending Payment">Pending Payment</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <div>
                <button type="submit">Submit Changes</button>
            </div>
        </form>
    </div>
    </body>

    </html>