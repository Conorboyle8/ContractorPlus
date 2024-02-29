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
      </div>
    </div>
  </div>
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