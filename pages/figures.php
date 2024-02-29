<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Figures YTD</title>
    <style>
        .slider-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .slider-label {
            font-size: 14px;
            margin-right: 10px;
        }

        .toggle-ytd {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        .toggle-all {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            background-color: lightblue;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
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

    <div class="container-fluid py-4">
        <div class="slider-container">
            <button class="toggle-ytd" onclick="redirectToYTD()">Year to Date</button>
            <button class="toggle-all" onclick="redirectToAllTime()">All Time</button>

        </div>

        <div class="col-xl-6">
            <div class="row">
                <!-- Existing card 1 -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Profit</h6>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0">Cash: $<?php echo $database->getCashYTD($user_id); ?></h4>
                            <h4 class="mb-0">Check: $<?php echo $database->getCheckYTD($user_id); ?></h4>
                            <h4 class="mb-0">Total: $<?php echo  $database->getCashYTD($user_id) + $database->getCheckYTD($user_id); ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 2 -->
                <div class="col-md-6 col-6">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Expenses</h6>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0">Labor: $<?php echo $database->getLaborCostYTD($user_id)?></h4>
                            <h4 class="mb-0">Material: $<?php echo $database->getMaterialCostYTD($user_id)?></h4>
                            <h4 class="mb-0">Total: $<?php echo $database->getLaborCostYTD($user_id) + $database->getMaterialCost($user_id)?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 3 -->
                <div class="col-md-6 col-6">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Jobs</h6>
                            <span class="text-xs">Jobs Completed</span>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0"><?php $jobsComp = $database->getNumJobsCompletedYTD($user_id); echo $jobsComp; ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 4 -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Revenue</h6>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0">Cash: $<?php echo $database->getRevCashYTD($user_id); ?></h4>
                            <h4 class="mb-0">Check: $<?php echo $database->getRevCheckYTD($user_id); ?></h4>
                            <h4 class="mb-0">Total: $<?php echo $database->getRevCashYTD($user_id) + $database->getRevCheckYTD($user_id); ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 5 -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Labor</h6>
                            <span class="text-xs">Days Worked</span>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0"><?php $days = ($database->getDaysWorkedYTD($user_id)); echo $days; ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 6 -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Miles</h6>
                            <span class="text-xs">Miles Driven</span>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0"><?php $miles = intval(($database->getMilesDrivenYTD($user_id))); echo $miles; ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Existing card 7 -->
                <div class="col-md-6 col-100 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="material-icons opacity-10">account_balance</i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Place holder</h6>
                            <span class="text-xs">Place Holder</span>
                            <hr class="horizontal dark my-3">
                            <h4 class="mb-0">Place Holder</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function redirectToYTD() {
                window.location.href = "figures.php";
            }
            function redirectToAllTime() {
                window.location.href = "figuresAllTime.php";
            }
        </script>
    </div>
</body>

</html>
