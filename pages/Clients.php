<?php 
    session_start();
    include('NavBar.php');
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    include 'connection.php';
    include 'functions.php';
    $user_data = check_login($conn);
    $user_id = $user_data['user_id'];
    echo "Welcome " . $user_data['user_name'];
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client</title>
</head>

<body>

    <!-- Modal for Edit Status -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Edit client Status</h5>
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

        <!-- Hidden input field to store the client ID -->
        <input type="hidden" id="editclientID" name="editclientID">
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
                            <h6 class="text-white text-capitalize ps-3 me-2" style="font-size: 18px;">Clients</h6>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addclientModal" style="font-size: 14px;" onclick="redirectToMyclients()">Add</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Contact Person</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Use PHP to fetch and display client data from the database
                                $result = $database->getAllClients($user_id); // Replace with your actual method to fetch clients
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . (isset($row['ClientName']) ? $row['ClientName'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['ContactPerson']) ? $row['ContactPerson'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['Email']) ? $row['Email'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['PhoneNumber']) ? $row['PhoneNumber'] : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['Address']) ? $row['Address'] : 'N/A') . "</td>";
                                    $clientID = $row['ClientID'];
                                    echo "<td><a href='editclient.php?clientID=$clientID' class='btn btn-primary btn-sm'>Edit</a>";
                                    echo "<button class='btn btn-danger btn-sm' onclick='deleteRow(\"" . $row['ClientID'] . "\")'>Delete</button>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
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

  <script>
    function deleteRow(clientID) {
        if (confirm("Are you sure you want to delete this row?")) {
            // Perform AJAX request to delete the row
            // This is a simplified example; adjust based on your data deletion logic

            // Assuming you have a PHP script to handle the deletion (e.g., deleteclient.php)
            var url = "deleteClient.php?clientID=" + clientID;

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
<script>
  // JavaScript function to handle button click and redirect
  function redirectToMyclients() {
    window.location.href = "../pages/clients_add.php";
  }
</script>
</body>

</html>