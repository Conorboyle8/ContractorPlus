<?php 
session_start();
include('NavForm.php');
include 'connection.php';
include 'functions.php';
require_once('../assets/includes/classes/Database.php');
$user_data = check_login($conn);
$database = new Database();
$jobID = isset($_GET['jobID']) ? $_GET['jobID'] : '';
$jobData = $database->getjobByID($jobID)->fetch_assoc();
$invoiceID = isset($_GET['invoiceID']) ? $_GET['invoiceID'] : '';
$invData = $database->getInvByID($invoiceID)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .invoice {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .invoice-header h1,
        .invoice-header span {
            color: green; /* Set the color to green */
        }

        .invoice-header span {
            font-size: 25px; /* Adjust the font size as needed */
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
        }

        .invoice-details div {
            flex: 1;
        }

        .invoice-items {
            margin-top: 20px;
        }

        .item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-description {
            flex: 2;
        }

        .item-quantity,
        .item-price {
            flex: 1;
            text-align: right;
        }

        .total {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .form p {
            font-size: 24px; /* Set the desired font size for the form type */
            color: green; /* Set the color to green */
            margin-bottom: 20px; /* Add margin for spacing */
        }

        .invoice-items .text img {
            max-width: 150px;
            max-height: 150px;
            width: auto;
            height: auto;
            margin-right: 10px;
        }

        /* Print Styles */
        @media print {
            body {
                font-size: 12px;
            }

            .invoice {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }

            .total {
                font-weight: normal;
            }

            /* Hide the print button in print view */
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <div class="invoice-details">
                <span><?php echo $user_data['comp_name'];?></span>
                <span><?php echo $user_data['phone_number'];?></span>
            </div>
        </div>

        <div class="invoice-items">
            <div class="text">
                <img src="data:image/png;base64,<?php echo base64_encode($user_data['img']); ?>" alt="User Image">
            </div>
            <div class="form">
                <p><?php echo $invData['formType'];?></p>
            </div>
            <div class="text">
                <p><?php echo $jobData['Address'];?></p>
            </div>

            <div class="text">
                <p>Hi <?php echo $jobData['ClientName'];?></p>
            </div>
            <div class="text">
                <div>Description: </div>
                <p><?php echo $invData['description'];?></p>
            </div>
            <div class="text">
                <p>
                    <span>Total For labor and materails: </span>
                    <span>$<?php echo $jobData['Expenses'];?></span>
                </p>
            </div>
            <div class="text">
                <p>
                    <span>Thank you </span>
                    <span><?php echo $jobData['ClientName'];?></span>
                </p>
            </div>
            <div>
                <div><?php echo $user_data['full_name'];?></div>
                <div><?php echo $user_data['comp_name'];?></div>
                <div><?php echo $user_data['address'];?></div>
                <div><?php echo $user_data['phone_number'];?></div>
            </div>
        </div>
    </div>

    <!-- Print button -->
    <button class="print-button" onclick="printInvoice()">Print Invoice</button>

    <!-- JavaScript to trigger print -->
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</body>

</html>