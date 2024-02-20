<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "cm";
    public $conn;

    // Constructor to establish the database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Execute a query and return the result
    public function query($sql) {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        return $result;
    }

    public function getNumberOfJobs() {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getAllJobs() {
        $query = "SELECT * FROM Jobs ORDER BY CASE WHEN status = 'Active' THEN 1 WHEN status = 'Pending' THEN 2 WHEN status = 'Closed' THEN 3 ELSE 4 END";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function pdoNumQuery($table, $condition = '', $params = []) {

        $sql = "SELECT COUNT(*) FROM $table" . ($condition ? " WHERE $condition" : "");
        return $this->executeQuery($sql, $params)->fetchColumn();

    }

    public function addNewJob($clientName, $jobName, $address, $phoneNumber, $jobSize, $status) {
        $query = "INSERT INTO Jobs (ClientName, JobName, Address, PhoneNumber, JobSize, Status) 
                  VALUES ('$clientName', '$jobName', '$address', '$phoneNumber', '$jobSize', '$status')";

        $result = $this->conn->query($query);

        return $result;
    }
    

    // Close the database connection
    public function close() {
        $this->conn->close();
    }
}
?>