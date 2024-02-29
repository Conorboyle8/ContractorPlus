<?php 
session_start();
include('NavBar.php');
include 'connection.php';
include 'functions.php';
$userData = check_login($conn);
$userID = $userData['user_id'];
$user_name = $userData['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>

<?php 
require_once('../assets/includes/classes/Database.php');
$database = new Database();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $updatedData = array(
        'full_name' => $_POST['full_name'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password'],
        'comp_name' => $_POST['comp_name'],
        'email' => $_POST['email'],
        'phone_number' => $_POST['phone_number'],
        'address' => $_POST['address'],
        'img' => $_POST['img']
    );
    $database -> updateUser($userID, $updatedData);
}
?>

<div class="container-fluid py-4">
        <h4>Edit Client</h4>
        <form method="post" action="">
            <div>
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" value="<?php echo $userData['full_name']; ?>">
            </div>
            <div>
                <label for="user_name">Username</label>
                <input type="text" name="user_name" value="<?php echo $userData['user_name']; ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="text" name="password" value="<?php echo $userData['password']; ?>">
            </div>
            <div>
                <label for="comp_name">Company</label>
                <input type="text" name="comp_name" value="<?php echo $userData['comp_name']; ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $userData['email']; ?>">
            </div>
            <div>
                <label for="phone_number">Phone</label>
                <input type="text" name="phone_number" value="<?php echo $userData['phone_number']; ?>">
            </div>
            <div>
                <label for="address">Address</label>
                <input type="text" name="address" value="<?php echo $userData['address']; ?>">
            </div>

            <div>
                <label for="img">Profile Picture</label>
                <input type="file" name="img" required>
            </div>

            <div>
                <button type="submit">Submit Changes</button>
            </div>
        </form>
    </div>
    </body>

    </html>