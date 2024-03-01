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
    <script>
        function fillJobForm(firstName, lastName, address, phoneNumber, clientID) {
            
            document.querySelector('input[name="firstName"]').value = firstName;
            document.querySelector('input[name="lastName"]').value = lastName;
            document.querySelector('input[name="address"]').value = address;
            document.querySelector('input[name="phoneNumber"]').value = phoneNumber;
            document.querySelector('input[name="clientID"]').value = clientID;
        }
    </script>
    <style>
        body {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        tbody tr.selected {
            background-color: lightblue;
        }

        .table-container {
            width: 100%; /* Adjust the width as needed */
            margin-right: 100px;
        }

        table {
            border-collapse: collapse;
            font-size: 14px;
            width: 100%;
        }

        tbody tr {
            cursor: pointer;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }

        .card {
            max-width: 100%; /* Adjust the max-width as needed */
        }
</style>
</head>
<div class="container">
        <div class="table-container">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                        <h6 class="text-white text-capitalize ps-3 me-2" style="font-size: 18px;">Select Client or</h6>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addclientModal" style="font-size: 14px;" onclick="redirectToMyclients()">Add</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Client Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_id = $user_data['user_id'];
                            $result = $database->getRecentClients($user_id);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr onclick='fillJobForm(\"" . $row['FirstName'] . "\", \"" . $row['LastName'] . "\", \"" . $row['Address'] . "\", \"" . $row['PhoneNumber'] . "\", \"" . $row['ClientID'] . "\")'>";
                                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                                echo "<td>" . $row['PhoneNumber'] . "</td>";
                                echo "<td>" . $row['Address'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<body>

<?php
// Assuming you have a method to add a new job in your Database class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
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
    $clientID = $_POST['clientID'];

    $success = $database->addNewJob($firstName, $lastName, $jobName, $address, $phoneNumber, $distance, $sqft, $revenue, $laborCost, $materialCost, $profit, $daysWorked, $paymentMethod, $status, $startDate, $completeDate, $user_id, $clientID);
    if ($success) {
        echo "Job added successfully! Add another?";
    } else {
        echo "Error adding job.";
    }
}
?>
<div class="table-container">
        <h4>Add New Job</h4>
        <!-- Add your form here -->
        <form method="post" action="">
            <!-- Add your form fields here -->
            <div>
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" >
            </div>

            <div>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" >
            </div>

            <div>
                <label for="jobName">Job Name:</label>
                <input type="text" name="jobName" >
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" >
            </div>

            <div>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" >
            </div>

            <div>
                <label for="distance">Miles To Site:</label>
                <input type="text" name="distance" >
            </div>

            <div>
                <label for="sqft">SQFT:</label>
                <input type="text" name="sqft" >
            </div>

            <div>
                <label for="revenue">Revenue:</label>
                <input type="text" name="revenue" >
            </div>

            <div>
                <label for="laborCost">Labor Cost:</label>
                <input type="text" name="laborCost" >
            </div>

            <div>
                <label for="materialCost">Material Cost:</label>
                <input type="text" name="materialCost" >
            </div>

            <div>
                <label for="daysWorked">Days Worked:</label>
                <input type="text" name="daysWorked" >
            </div>

            <div>
                <label for="paymentMethod">Payment Method:</label>
                <select name="paymentMethod" >
                    <option value=""></option>
                    <option value="Cash">Cash</option>
                    <option value="Check">Check</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            
            <div>
                <label for="status">Status:</label>
                <select name="status" >
                    <option value=""></option>
                    <option value="Active">Active</option>
                    <option value="Pending Payment">Pending Payment</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <div>
                <label for="startDate">Start Date:</label>
                <input type="date" name="startDate" >
            </div>

            <div>
                <label for="completeDate">Complete Date:</label>
                <input type="date" name="completeDate">
            </div>

            <input type="hidden" name="clientID" value="clientID">

            <div>
                <button type="submit">Add Job</button>
            </div>
        </form>
    </div>
    <script>
  // JavaScript function to handle button click and redirect
  function redirectToMyclients() {
    window.location.href = "../pages/clients_add.php";
  }

</script>
    </body>

    </html>