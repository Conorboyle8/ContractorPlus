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

    public function check_login($conn){
        if (isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE usr_id = '$id' limit 1";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        header("Location: login.php");
        die;
    }

    public function pdoQuery($table, $condition, $params = []) {

        return $this->executeQuery("SELECT * FROM $table WHERE $condition LIMIT 1", $params)->fetch(PDO::FETCH_ASSOC);

    }

    public function getJobByID($jobID) {
        $query = "SELECT * FROM Jobs WHERE JobID = $jobID";
        $result = $this->conn->query($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getClientByID($clientID) {
        $query = "SELECT * FROM Clients WHERE ClientID = $clientID";
        $result = $this->conn->query($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function updateJob($jobID, $updatedData) {
        $sql = "UPDATE jobs SET 
                ClientName = '{$updatedData['ClientName']}',
                JobName = '{$updatedData['JobName']}',
                Address = '{$updatedData['Address']}',
                PhoneNumber = '{$updatedData['PhoneNumber']}',
                Distance = '{$updatedData['Distance']}',
                SQFT = '{$updatedData['SQFT']}',
                Expenses = '{$updatedData['Expenses']}',
                DaysWorked = '{$updatedData['DaysWorked']}',
                PaymentMethod = '{$updatedData['PaymentMethod']}',
                Revenue = '{$updatedData['Revenue']}',
                Status = '{$updatedData['Status']}'
                WHERE JobID = '{$jobID}'";

        if ($this->conn->query($sql) === TRUE) {
            // Update successful
            return true;
        } else {
            // Update failed
            echo "Error updating job: " . $this->conn->error;
            return false;
        }
    }

    public function updateClient($clientID, $updatedData) {
        $sql = "UPDATE clients SET 
                ClientName = '{$updatedData['ClientName']}',
                ContactPerson = '{$updatedData['ContactPerson']}',
                Email = '{$updatedData['Email']}',
                PhoneNumber = '{$updatedData['PhoneNumber']}',
                Address = '{$updatedData['Address']}'
                WHERE ClientID = '{$clientID}'";

        if ($this->conn->query($sql) === TRUE) {
            // Update successful
            return true;
        } else {
            // Update failed
            echo "Error updating client: " . $this->conn->error;
            return false;
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

    public function getMilesDriven() {
        $query = "SELECT SUM(Distance * 2 * DaysWorked) AS miles FROM Jobs";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['miles'];
        } else {
            return false;
        }
    }

    public function getDaysWorked() {
        $query = "SELECT SUM(DaysWorked) AS days FROM Jobs";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['days'];
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

    public function addNewJob($clientName, $jobName, $address, $phoneNumber, $distance, $sqft, $expenses, $daysWorked, $paymentMethod, $revenue, $status, $userID) {
        $query = "INSERT INTO Jobs (ClientName, JobName, Address, PhoneNumber, Distance, SQFT, Expenses, DaysWorked, PaymentMethod, Revenue, Status)
                  VALUES ('$clientName', '$jobName', '$address', '$phoneNumber', '$distance', '$sqft', '$expenses', '$daysWorked', '$paymentMethod', '$revenue', '$status')";

        $result = $this->conn->query($query);

        return $result;
    }

    public function addNewClient($clientName, $contactPerson, $email, $phoneNumber, $address) {
        $query = "INSERT INTO Clients (ClientName, ContactPerson, Email, PhoneNumber, Address)
                  VALUES ('$clientName', '$contactPerson', '$email', '$phoneNumber', '$address')";

        $result = $this->conn->query($query);

        return $result;
    }
    
    public function getCash() {
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE Status = 'Paid' AND PaymentMethod = 'Cash'";
        $result = $this->conn->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevenue(){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function signIN($user_name, $password) {
        $query = "SELECT * FROM Users WHERE UserName = '$userName' AND Password = '$password'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $_SESSION['userName'] = $userName;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login($username, $password) {

        $userData = $this->db->pdoQuery('USERS', 'usr_username = :username', ['username' => $username]);

        if($userData && password_verify($password, $userData['usr_password'])) {

            $_SESSION['user_id'] = $userData['usr_id'];
            return true;

        }

        return false;

    }

    public function getSessID($userName){
        $query = "SELECT UserID FROM Users WHERE UserName = '$userName'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['UserID'];
        } else {
            return false;
        }
    }

    public function addNewUser($userName, $password) {
        $query = "INSERT INTO Users (UserName, Password)
                  VALUES ('$userName', '$password')";

        $result = $this->conn->query($query);

        return $result;
    }

    // Close the database connection
    public function close() {
        $this->conn->close();
    }

}
?>