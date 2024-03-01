<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyJobs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>
</head>

<body>

<!-- Your existing PHP code -->
<?php
session_start();
include('NavBar.php');
require_once('../assets/includes/classes/Database.php');
$database = new Database();
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
$user_id = $user_data['user_id'];
?>

<!-- Modal for Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <!-- Your existing modal code -->
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                        <h6 class="text-white text-capitalize ps-3 me-2" style="font-size: 18px;">Projects</h6>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addJobModal" style="font-size: 14px;" onclick="redirectToMyJobs()">Add</button>
                    </div>
                    <div class="table-responsive">
                        <table id="jobsTable" class="table" style="font-size: 12px; max-width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Client</th>
                                    <th scope="col">Job Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Miles To Site</th>
                                    <th scope="col">Days Worked</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                        <tbody>
                        <?php
                                // Use PHP to fetch and display job data from the database
                                $result = $database->getAllJobsByID($user_id); // Replace with your actual method to fetch jobs
                                while ($row = $result->fetch_assoc()) {
                                    $backgroundColor = '';
                                    switch ($row['Status']) {
                                        case 'Paid':
                                            $backgroundColor = 'lightblue';
                                            break;
                                        case 'Pending Payment':
                                            $backgroundColor = '#FFB600';
                                            break;
                                        case 'Active':
                                            $backgroundColor = 'lightgreen';
                                            break;
                                        default:
                                            $backgroundColor = ''; // Default color if none of the above
                                    }
                                    $jobID = $row['JobID'];
                                    echo "<tr style='background-color: $backgroundColor;' data-job-id='$jobID'>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['FirstName']) ? $row['FirstName'] : 'N/A') . " " . (isset($row['LastName']) ? $row['LastName'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['JobName']) ? $row['JobName'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Address']) ? $row['Address'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['PhoneNumber']) ? $row['PhoneNumber'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Distance']) ? $row['Distance'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['DaysWorked']) ? $row['DaysWorked'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['PaymentMethod']) ? $row['PaymentMethod'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Status']) ? $row['Status'] : 'N/A') . "</td>";
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to handle button click and redirect
    function redirectToMyJobs() {
        window.location.href = "../pages/myjobs_add.php";
    }

    // JavaScript function to handle row click and redirect
    document.getElementById('jobsTable').addEventListener('click', function (event) {
    // Check if the clicked element is a table row
    if (event.target.tagName === 'TD') {
        // Retrieve the job ID from the data attribute
        var jobID = event.target.parentNode.getAttribute('data-job-id');

        // Redirect to jobInfo.php with the selected job ID
        window.location.href = 'jobInfo.php?jobID=' + jobID;
    }
});

</script>

</body>
</html>
