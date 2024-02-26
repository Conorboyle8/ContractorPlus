<?php 
session_start();
include('NavBar.php'); 
require_once('../assets/includes/classes/Database.php');
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
echo "Welcome " . $user_data['full_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Web App</title>
</head>
<body>
    <form id="invoiceForm">
        <div>
            <label for="sqr">For under 8 FT - Enter Sqr footage:</label>
            <input type="number" id="sqr" required>
        </div>

        <div>
            <label for="sheets8ft">Enter num of over 8 ft sheets:</label>
            <input type="number" id="sheets8ft" required>
        </div>

        <div>
            <label for="sqfAcust">Enter square foot of Acoustic ceiling:</label>
            <input type="number" id="sqfAcust" required>
        </div>

        <div>
            <label for="paintFoot">Enter square foot for painting:</label>
            <input type="number" id="paintFoot" required>
        </div>

        <div>
            <label for="matCost">Enter cost of Materials:</label>
            <input type="number" id="matCost" required>
        </div>

        <button type="button" onclick="calculateInvoice()">Calculate Invoice</button>
    </form>

    <div id="result"></div>

    <script>
        function calculateInvoice() {
            const sqr = parseFloat(document.getElementById('sqr').value);
            const sheets8ft = parseFloat(document.getElementById('sheets8ft').value);
            const sqfAcust = parseFloat(document.getElementById('sqfAcust').value);
            const paintFoot = parseFloat(document.getElementById('paintFoot').value);
            const matCost = parseFloat(document.getElementById('matCost').value);

            const numOfSheets = sqr / 48;
            const labor = numOfSheets >= 30 ? numOfSheets * 200 : numOfSheets * 150;
            const tempLabor = sheets8ft * ((1.0 / 3) * 200);
            const sqfAcustLab = sqfAcust * 3.5;
            const paintLab = paintFoot * 5;

            const invoice = labor + tempLabor + sqfAcustLab + paintLab + matCost;
            const invoiceLab = labor + tempLabor + sqfAcustLab + paintLab;
            

            const result = document.getElementById('result');
            result.innerHTML = `<p>Labor = ${invoiceLab}</p><p>With mat cost = ${invoice}</p>`;
        }
    </script>
</body>
</html>