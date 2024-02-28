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
    <title>Forms</title>
</head>
<body>
<div class="container-fluid py-4">
    <div class="col-xl-6">
      
        <div class="row">
          
            <!-- Existing card 1 -->
            <div class="col-md-6 col-6 mb-4">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Profit</h6>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0">Cash: $<?php echo $database->getCash($user_id); ?></h4>
                        <h4 class="mb-0">Check: $<?php echo $database->getCheck($user_id); ?></h4>
                        <h4 class="mb-0">Total: $<?php echo  $database->getCash($user_id) + $database->getCheck($user_id); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-6">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Expenses</h6>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0">Labor: $<?php echo $database->getLaborCost($user_id)?></h4>
                        <h4 class="mb-0">Material: $<?php echo $database->getMaterialCost($user_id)?></h4>
                        <h4 class="mb-0">Total: $<?php echo $database->getLaborCost($user_id) + $database->getMaterialCost($user_id)?></h4>
                    </div>
                </div>
            </div>
          
            
            <!-- Existing card 2 -->
            <div class="col-md-6 col-6">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Jobs</h6>
                        <span class="text-xs">Jobs Completed</span>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0"><?php $jobsComp = $database->getNumberJobsCompleted($user_id); echo $jobsComp; ?></h4>
                    </div>
                </div>
            </div>

            <!-- New card 3 -->
            <div class="col-md-6 col-6 mb-4">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Revenue</h6>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0">Cash: $<?php echo $database->getRevCash($user_id); ?></h4>
                        <h4 class="mb-0">Check: $<?php echo $database->getRevCheck($user_id); ?></h4>
                        <h4 class="mb-0">Total: $<?php echo $database->getRevCash($user_id) + $database->getRevCheck($user_id); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-6 mb-4">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Labor</h6>
                        <span class="text-xs">Days Worked</span>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0"><?php $days = ($database->getDaysWorked($user_id)); echo $days; ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-6 mb-4">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Miles</h6>
                        <span class="text-xs">Miles Driven</span>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0"><?php $miles = ($database->getMilesDriven($user_id)); echo $miles; ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-100 mb-4">
                <div class="card">
                    <!-- Card header and icon -->
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Miles</h6>
                        <span class="text-xs">Miles Driven</span>
                        <hr class="horizontal dark my-3">
                        <h4 class="mb-0"><?php $miles = ($database->getMilesDriven($user_id)); echo $miles; ?></h4>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
</body>

</html>