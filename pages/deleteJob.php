<?php
require_once('../assets/includes/classes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get jobID from the request
    $jobID = $_POST['jobID'];

    // Validate jobID (you may need additional validation based on your requirements)
    if (!is_numeric($jobID)) {
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Invalid jobID"));
        exit;
    }

    // Create a Database instance
    $database = new Database();

    // Use prepared statement to delete the job
    $query = "DELETE FROM Jobs WHERE JobID = ?";
    $stmt = $database->conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("i", $jobID);

    // Execute the statement
    if ($stmt->execute()) {
        // Successful deletion
        http_response_code(200); // OK
        echo json_encode(array("message" => "Job deleted successfully"));
    } else {
        // Failed to delete
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Error deleting job"));
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $database->close();
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Invalid request method"));
}
?>
