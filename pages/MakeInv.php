<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['full_name'];

require_once('../assets/includes/classes/Database.php');
$database = new Database();
$jobID = isset($_GET['jobID']) ? $_GET['jobID'] : '';
echo $jobID;

$jobData = $database->getJobByID($jobID)->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    
    $clientName = $jobData['ClientName'];
    $address = $jobData['Address'];
    $expenses = $jobData['Expenses'];
    $formType = $_POST['formType']; // Update with your actual form field names
    $description = $_POST['description'];
    $user_id = $user_data['user_id'];

    $success = $database->addNewInvoice($clientName, $address, $expenses, $formType, $description, $user_id);

    if ($success) {
        // Get the last inserted invoice_id
        $invoiceID = $database->conn->insert_id;

        // Use JavaScript to redirect to Forms.php with jobID
        echo "<script>window.location.href = 'Forms.php?jobID={$jobID}&invoiceID={$invoiceID}';</script>";
        exit();
    } else {
        echo "Error adding invoice.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Form</title>
</head>
<body>

<div class="container-fluid py-4">
    <h4>Create Form</h4>
    <form method="post" action="">
        <div>
            <div><?php echo $jobData['ClientName'];?></div>
        </div>

        <div>
            <div><?php echo $address = $jobData['Address'];?></div>
        </div>

        <div>
            <div><?php echo $expenses = $jobData['Expenses'];?></div>
        </div>

        <div>
            <label for="formType">FormType:</label>
            <select name="formType" required>
                <option value="Invoice">Invoice</option>
                <option value="Proposal">Proposal</option>
            </select>
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50" required></textarea>
        </div>

        <div>
            <button type="submit">Create</button>
        </div>
    </form>
</div>

</body>
</html>