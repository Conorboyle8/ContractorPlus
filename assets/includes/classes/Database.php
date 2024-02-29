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

    public function getJobByID($jobID) {
        $query = "SELECT * FROM Jobs WHERE JobID = $jobID";
        $result = $this->conn->query($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getInvByID($invoiceID) {
        $query = "SELECT * FROM Invoices WHERE InvoiceID = $invoiceID";
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

    public function getUserByID($userID) {
        $query = "SELECT * FROM Users WHERE usr_id = $userID";
        $result = $this->conn->query($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getPercentFromLastMonth($user_id) {
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE user_id = $user_id AND MONTH(completeDate) = MONTH(CURDATE()) - 1";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $revenue = $row['Revenue'];
            return $revenue;
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
                Revenue = '{$updatedData['Revenue']}',
                LaborCost = '{$updatedData['LaborCost']}',
                MaterialCost = '{$updatedData['MaterialCost']}',
                Profit = '{$updatedData['Profit']}',
                DaysWorked = '{$updatedData['DaysWorked']}',
                PaymentMethod = '{$updatedData['PaymentMethod']}',
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

    public function updateUser($userID, $updatedData) {
        $sql = "UPDATE users SET 
                full_name = '{$updatedData['full_name']}',
                comp_name = '{$updatedData['comp_name']}',
                user_name = '{$updatedData['user_name']}',
                password = '{$updatedData['password']}',
                email = '{$updatedData['email']}',
                phone_number = '{$updatedData['phone_number']}',
                address = '{$updatedData['address']}'
                WHERE user_id = '{$userID}'";

        if ($this->conn->query($sql) === TRUE) {
            // Update successful
            return true;
        } else {
            // Update failed
            echo "Error updating user: " . $this->conn->error;
            return false;
        }
    }

    public function query($sql) {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        return $result;
    }

    public function getNumberOfJobs($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE status = 'Active' OR status = 'Pending Payment' AND user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumberOfJobsYTD($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE status = 'Active' OR status = 'Pending Payment' AND user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getMilesDriven($user_id) {
        $query = "SELECT SUM(Distance * 2 * DaysWorked) AS miles FROM Jobs WHERE user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['miles'];
        } else {
            return false;
        }
    }

    public function getMilesDrivenYTD($user_id) {
        $query = "SELECT SUM(Distance * 2 * DaysWorked) AS miles FROM Jobs WHERE user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['miles'];
        } else {
            return false;
        }
    }

    public function getDaysWorked($user_id) {
        $query = "SELECT SUM(DaysWorked) AS days FROM Jobs WHERE user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['days'];
        } else {
            return false;
        }
    }

    public function getAvgDaysWorked($user_id) {
        $query = "SELECT AVG(DaysWorked) AS days FROM Jobs WHERE user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['days'];
        } else {
            return false;
        }
    }
    
    

    public function getDaysWorkedYTD($user_id) {
        $query = "SELECT SUM(DaysWorked) AS days FROM Jobs WHERE user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['days'];
        } else {
            return false;
        }
    }

    public function getLaborCost($user_id) {
        $query = "SELECT SUM(LaborCost) AS laborCost FROM Jobs WHERE user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['laborCost'];
        } else {
            return false;
        }
    }

    public function getLaborCostYTD($user_id) {
        $query = "SELECT SUM(LaborCost) AS laborCost FROM Jobs WHERE user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['laborCost'];
        } else {
            return false;
        }
    }

    public function getMaterialCost($user_id) {
        $query = "SELECT SUM(MaterialCost) AS materialCost FROM Jobs WHERE user_id = $user_id";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['materialCost'];
        } else {
            return false;
        }
    }

    public function getMaterialCostYTD($user_id) {
        $query = "SELECT SUM(MaterialCost) AS materialCost FROM Jobs WHERE user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['materialCost'];
        } else {
            return false;
        }
    }

    public function getNumberJobsCompleted($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE user_id = $user_id AND status = 'Paid'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumJobsCompletedYTD($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE user_id = $user_id AND status = 'Paid' AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumberJobsOpen($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE user_id = $user_id AND status = 'Active' OR status = 'Pending Payment'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumberJobsActive($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE user_id = $user_id AND status = 'Active'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getNumberJobsPendingPayment($user_id) {
        $query = "SELECT COUNT(*) AS jobCount FROM Jobs WHERE user_id = $user_id AND status = 'Pending Payment'";
        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['jobCount'];
        } else {
            return false;
        }
    }

    public function getAllJobsByID($user_id) {
        $query = "SELECT * FROM Jobs WHERE user_id = $user_id ORDER BY CASE WHEN status = 'Active' THEN 1 WHEN status = 'Pending Payment' THEN 2 WHEN status = 'Paid' THEN 3 ELSE 4 END";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllJobsByIDYTD($user_id) {
        $query = "SELECT * FROM Jobs WHERE user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE()) ORDER BY CASE WHEN status = 'Active' THEN 1 WHEN status = 'Pending Payment' THEN 2 WHEN status = 'Paid' THEN 3 ELSE 4 END";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllJobsOpenByID($user_id) {
        $query = "SELECT * FROM Jobs WHERE user_id = $user_id AND (status = 'Active' OR status = 'Pending Payment') ORDER BY CASE WHEN status = 'Active' THEN 1 WHEN status = 'Pending Payment' THEN 2 ELSE 3 END";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    

    public function getAllClients($user_id) {
        $query = "SELECT * FROM Clients WHERE user_id = $user_id ORDER BY ClientName";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllClientsYTD($user_id) {
        $query = "SELECT * FROM Clients WHERE user_id = $user_id AND YEAR(dateAdded) = YEAR(CURDATE()) ORDER BY ClientName";
        $result = $this->conn->query($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function addNewJob($clientName, $jobName, $address, $phoneNumber, $distance, $sqft, $revenue, $laborCost, $materialCost, $profit, $daysWorked, $paymentMethod, $status, $startDate, $completeDate, $user_id) {
        $query = "INSERT INTO Jobs (ClientName, JobName, Address, PhoneNumber, Distance, SQFT, Revenue, LaborCost, MaterialCost, Profit, DaysWorked, PaymentMethod, Status, startDate, completeDate, user_id)
          VALUES ('$clientName', '$jobName', '$address', '$phoneNumber', '$distance', '$sqft', '$revenue', '$laborCost', '$materialCost', '$profit', '$daysWorked', '$paymentMethod', '$status', '$startDate', '$completeDate', $user_id)";

        $result = $this->conn->query($query);

        return $result;
    }

    public function addNewClient($clientName, $contactPerson, $email, $phoneNumber, $address, $user_id) {
        $query = "INSERT INTO Clients (ClientName, ContactPerson, Email, PhoneNumber, Address, user_id)
                  VALUES ('$clientName', '$contactPerson', '$email', '$phoneNumber', '$address', '$user_id')";

        $result = $this->conn->query($query);

        return $result;
    }

    public function addNewInvoice($clientName, $address, $Expenses, $formType, $description, $user_id) {
        $query = "INSERT INTO Invoices (Client_fname, address, Amount, formType, description, user_id)
                  VALUES ('$clientName', '$address', '$Expenses', '$formType', '$description', '$user_id')";

        $result = $this->conn->query($query);

        return $result;
    }
    
    public function getCash($user_id) {
        $query = "SELECT SUM(Revenue) AS TotalRevenue, 
                         SUM(LaborCost) AS TotalLaborCost, 
                         SUM(MaterialCost) AS TotalMaterialCost 
                  FROM Jobs 
                  WHERE user_id = $user_id 
                    AND Status = 'Paid' 
                    AND PaymentMethod = 'Cash'";
        
        $result = $this->conn->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $totalRevenue = $row['TotalRevenue'];
            $totalLaborCost = $row['TotalLaborCost'];
            $totalMaterialCost = $row['TotalMaterialCost'];
    
            // Calculate profit: Revenue - LaborCost - MaterialCost
            $profit = $totalRevenue - $totalLaborCost - $totalMaterialCost;
            
            return $profit;
        } else {
            return false;
        }
    }

    public function getCashYTD($user_id) {
        $query = "SELECT SUM(Revenue) AS TotalRevenue, 
                         SUM(LaborCost) AS TotalLaborCost, 
                         SUM(MaterialCost) AS TotalMaterialCost 
                  FROM Jobs 
                  WHERE user_id = $user_id 
                    AND Status = 'Paid' 
                    AND PaymentMethod = 'Cash'
                    AND YEAR(completeDate) = YEAR(CURDATE())";
        
        $result = $this->conn->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $totalRevenue = $row['TotalRevenue'];
            $totalLaborCost = $row['TotalLaborCost'];
            $totalMaterialCost = $row['TotalMaterialCost'];
    
            // Calculate profit: Revenue - LaborCost - MaterialCost
            $profit = $totalRevenue - $totalLaborCost - $totalMaterialCost;
            
            return $profit;
        } else {
            return false;
        }
    }

    public function getCheck($user_id) {
        $query = "SELECT SUM(Revenue) AS TotalRevenue, 
                         SUM(LaborCost) AS TotalLaborCost, 
                         SUM(MaterialCost) AS TotalMaterialCost 
                  FROM Jobs 
                  WHERE user_id = $user_id 
                    AND Status = 'Paid' 
                    AND PaymentMethod = 'Check'";
        
        $result = $this->conn->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $totalRevenue = $row['TotalRevenue'];
            $totalLaborCost = $row['TotalLaborCost'];
            $totalMaterialCost = $row['TotalMaterialCost'];
    
            // Calculate profit: Revenue - LaborCost - MaterialCost
            $profit = $totalRevenue - $totalLaborCost - $totalMaterialCost;
            
            return $profit;
        } else {
            return false;
        }
    }

    public function getCheckYTD($user_id) {
        $query = "SELECT SUM(Revenue) AS TotalRevenue, 
                         SUM(LaborCost) AS TotalLaborCost, 
                         SUM(MaterialCost) AS TotalMaterialCost 
                  FROM Jobs 
                  WHERE user_id = $user_id 
                    AND Status = 'Paid' 
                    AND PaymentMethod = 'Check'
                    AND YEAR(completeDate) = YEAR(CURDATE())";
        
        $result = $this->conn->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $totalRevenue = $row['TotalRevenue'];
            $totalLaborCost = $row['TotalLaborCost'];
            $totalMaterialCost = $row['TotalMaterialCost'];
    
            // Calculate profit: Revenue - LaborCost - MaterialCost
            $profit = $totalRevenue - $totalLaborCost - $totalMaterialCost;
            
            return $profit;
        } else {
            return false;
        }
    }
    

    public function getRevenue($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevenueYTD($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevByMonth($user_id, $month){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND MONTH(completeDate) = $month";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getProfitbyMonth($user_id, $month){
        $query = "SELECT SUM(Revenue) AS Revenue, SUM(LaborCost) AS LaborCost, SUM(MaterialCost) AS MaterialCost FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND MONTH(completeDate) = $month";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $totalRevenue = $row['Revenue'];
            $totalLaborCost = $row['LaborCost'];
            $totalMaterialCost = $row['MaterialCost'];
            $profit = $totalRevenue - $totalLaborCost - $totalMaterialCost;
            return $profit;
        } else {
            return false;
        }
    }

    public function getExpByMonth($user_id, $month){
        $query = "SELECT SUM(LaborCost) AS LaborCost, SUM(MaterialCost) AS MaterialCost FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND MONTH(completeDate) = $month";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $totalLaborCost = $row['LaborCost'];
            $totalMaterialCost = $row['MaterialCost'];
            $totalExp = $totalLaborCost + $totalMaterialCost;
            return $totalExp;
        } else {
            return false;
        }
    }

    public function getRevCash($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND PaymentMethod = 'Cash'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevCashYTD($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND PaymentMethod = 'Cash' AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevCheck($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND PaymentMethod = 'Check'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
        } else {
            return false;
        }
    }

    public function getRevCheckYTD($user_id){
        $query = "SELECT SUM(Revenue) AS Revenue FROM Jobs WHERE status = 'Paid' AND user_id = $user_id AND PaymentMethod = 'Check' AND YEAR(completeDate) = YEAR(CURDATE())";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Revenue'];
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

    // Close the database connection
    public function close() {
        $this->conn->close();
    }

}
?>