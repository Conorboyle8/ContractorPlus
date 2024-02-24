<!-- addJob.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
</head>
<body>

<?php
require_once('../assets/includes/classes/Database.php');
if (isset($_POST['userName']) && isset($_POST['password'])) {
    
  function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    $uname = validate($_POST['userName']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        echo "User Name is required";
    } else if (empty($pass)) {
        echo "Password is required";
    } else {
        $database = new Database();
        $success = $database->signIn($uname, $pass);
        if ($success) {
            echo "Sign In successful!";
        } else {
            echo "Error signing in.";
        }
    }
}
?>

<div class="container-fluid py-4">
        <h4>Sign In</h4>
        <form method="post" action="">
            <div>
                <label for="userName">User Name:</label>
                <input type="text" name="userName" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="text" name="password" required>
            </div>

            <div>
                <button type="submit">Sign In</button>
            </div>
        </form>
    </div>

    </body>

    </html>