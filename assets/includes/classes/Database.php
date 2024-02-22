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
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE status = 'Active' OR status = 'Pending Payment'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumberJobsCompleted() {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE status = 'Paid'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getAllJobs() {
        $query = "SELECT * FROM Jobs ORDER BY CASE WHEN status = 'Active' THEN 1 WHEN status = 'Pending Payment' THEN 2 WHEN status = 'Paid' THEN 3 ELSE 4 END";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllJobsOpen() {
        $query = "SELECT * FROM Jobs WHERE status IN ('Active', 'Pending Payment') ORDER BY CASE WHEN status = 'Active' THEN 0 ELSE 1 END, ClientName";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllClients() {
        $query = "SELECT * FROM Clients ORDER BY ClientName";
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

    public function addNewJob($clientName, $jobName, $address, $phoneNumber, $distance, $sqft, $expenses, $daysWorked, $paymentMethod, $revenue, $status) {
        $query = "INSERT INTO Jobs (ClientName, JobName, Address, PhoneNumber, Distance, SQFT, Expenses, DaysWorked, PaymentMethod, Revenue, Status)
                  VALUES ('$clientName', '$jobName', '$address', '$phoneNumber', '$distance', '$sqft', '$expenses', '$daysWorked', '$paymentMethod', '$revenue', '$status')";

        $result = $this->conn->query($query);

        return $result;
    }

    public function addNewClient($clientName, $contactPerson, $email, $phoneNumber, $address) {
        $query = "INSERT INTO Clients (ClientName, ContactPerson, Email, Phone, Address)
                  VALUES ('$clientName', '$contactPerson', '$email', '$phoneNumber', '$address')";

        $result = $this->conn->query($query);

        return $result;
    }
    
    function getCash(){
        $query = "SELECT SUM(revenue) AS cash FROM Jobs WHERE status = 'Paid'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['cash'];
        } else {
            return false;
        }
    }

    function getRevenue(){
        $query = "SELECT SUM(revenue) AS revenue FROM Jobs WHERE status = 'Paid'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['revenue'];
        } else {
            return false;
        }
    }

    // Close the database connection
    public function close() {
        $this->conn->close();
    }

}
?>