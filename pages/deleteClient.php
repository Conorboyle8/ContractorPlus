<?php
require_once('../assets/includes/classes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Get clientID from the request
    $clientID = $_GET['clientID'];

    // Validate clientID (you may need additional validation based on your requirements)
    if (!is_numeric($clientID)) {
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Invalid clientID"));
        exit;
    }

    // Create a Database instance
    $database = new Database();

    // Use prepared statement to delete the job
    $query = "DELETE FROM Clients WHERE ClientID = ?";
    $stmt = $database->conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("i", $clientID);

    // Execute the statement
    if ($stmt->execute()) {
        // Successful deletion
        http_response_code(200); // OK
        echo json_encode(array("message" => "Client deleted successfully"));
    } else {
        // Failed to delete
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Error deleting Client"));
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
