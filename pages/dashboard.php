<?php
    session_start();
    include('NavBar.php');
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    include 'connection.php';
    include 'functions.php';
    $user_data = check_login($conn);
    $user_id = $user_data['user_id'];
    echo "Welcome " . $user_data['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Revenue</p>
                <h4 class="mb-0">$<?php $totalRev = $database->getRevenue($user_id); echo $totalRev; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Open Jobs</p>
                <h4 class="mb-0"><?php $openJobs = $database->getNumberJobsOpen($user_id); echo $openJobs; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Jobs Completed</p>
                <h4 class="mb-0"><?php $jobsComp = $database->getNumberJobsCompleted($user_id); echo $jobsComp; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
            </div>
          </div>
        </div>
      <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                            <h6 class="text-white text-capitalize ps-3 me-2" style="font-size: 18px;">Open Jobs</h6>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addJobModal" style="font-size: 14px;" onclick="redirectToMyJobs()">Add</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Client</th>
                                    <th scope="col">Job Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Use PHP to fetch and display job data from the database
                                $result = $database->getAllJobsOpenByID($user_id); // Replace with your actual method to fetch jobs
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . (isset($row['ClientName']) ? $row['ClientName'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['JobName']) ? $row['JobName'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['Address']) ? $row['Address'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['PhoneNumber']) ? $row['PhoneNumber'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['Status']) ? $row['Status'] : 'N/A') . "</td>";
                                    $jobID = $row['JobID'];
                                    echo "<td><a href='editJob.php?jobID=$jobID' class='btn btn-primary btn-sm'>Edit</a>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <canvas id="myStackedBarChart" width="400" height="400"></canvas>
    <style>
        #myStackedBarChart {
            max-width: 400px; /* Set a maximum width for the chart */
            margin: 0 auto; /* Center the chart horizontally */
        }
    </style>
  <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sample data
            var data = {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Active Jobs',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    data: [10, 15, 7, 8, 12]
                }, {
                    label: 'Pending Payments',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    data: [5, 8, 10, 6, 9]
                }]
            };

            // Chart configuration
            var options = {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            };

            // Get the canvas element
            var ctx = document.getElementById('myStackedBarChart').getContext('2d');

            // Create the stacked bar chart
            var myStackedBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    </script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
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
</body>

</html>