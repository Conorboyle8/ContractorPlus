<?php 
    session_start();
    include('NavBar.php');
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    include 'connection.php';
    include 'functions.php';
    $user_data = check_login($conn);
    echo "Welcome " . $user_data['full_name'];
    $user_id = $user_data['user_id'];
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MyJobs</title>
</head>

<body>

<!-- Modal for Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-sm"> <!-- Added modal-dialog-sm class -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusModalLabel">Edit Job Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for editing status here -->
                <label for="editStatus">Edit Status:</label>
                <select id="editStatus" name="editStatus" required>
                    <option value="Active">Active</option>
                    <option value="Pending">Pending Payment</option>
                    <option value="Paid">Paid</option>
                </select>

                <!-- Hidden input field to store the job ID -->
                <input type="hidden" id="editJobID" name="editJobID">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus()">Save changes</button>
            </div>
        </div>
    </div>
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
                        <table class="table" style="font-size: 12px; max-width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Client</th>
                                    <th scope="col">Job Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Miles To Site</th>
                                    <th scope="col">SQFT</th>
                                    <th scope="col">Revenue</th>
                                    <th scope="col">Labor Cost</th>
                                    <th scope="col">Material Cost</th>
                                    <th scope="col">Profit</th>
                                    <th scope="col">Days Worked</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
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
                                    echo "<tr style='background-color: $backgroundColor;'>";
                                    echo "<tr>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['ClientName']) ? $row['ClientName'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['JobName']) ? $row['JobName'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Address']) ? $row['Address'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['PhoneNumber']) ? $row['PhoneNumber'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Distance']) ? $row['Distance'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['SQFT']) ? $row['SQFT'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Revenue']) ? $row['Revenue'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['LaborCost']) ? $row['LaborCost'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['MaterialCost']) ? $row['MaterialCost'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Revenue']) ? $row['Revenue'] - $row['LaborCost'] - $row['MaterialCost'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['DaysWorked']) ? $row['DaysWorked'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['PaymentMethod']) ? $row['PaymentMethod'] : 'N/A') . "</td>";
                                    echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Status']) ? $row['Status'] : 'N/A') . "</td>";
                                    $jobID = $row['JobID'];
                                    echo "<td>";
                                    echo "<a href='editJob.php?jobID=$jobID' class='btn btn-primary btn-sm'>Edit</a>";
                                    echo "<button class='btn btn-danger btn-sm' onclick='deleteRow(\"" . $row['JobID'] . "\")'>Delete</button>";
                                    echo "<a href='MakeInv.php?jobID=$jobID' class='btn btn-primary btn-sm'>Forms</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
  // JavaScript function to handle button click and redirect
  function redirectToMyJobs() {
    window.location.href = "../pages/myjobs_add.php";
  }
  function deleteRow($jobID) {
        if (confirm("Are you sure you want to delete this row?")) {

            var url = "deleteJob.php?jobID=" + $jobID;

            // Perform AJAX request
            fetch(url, { method: 'DELETE' })
                .then(response => {
                    if (response.ok) {
                        // Reload the page or update the table after successful deletion
                        location.reload(); // This will refresh the current page
                    } else {
                        console.error('Error deleting row:', response.statusText);
                    }
                })
                .catch(error => {
                    console.error('Error deleting row:', error);
                });
        }
    }
</script>
</body>

</html>