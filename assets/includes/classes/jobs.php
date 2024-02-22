<?php
include("classes/Database.php");
$db = new Database();

class Jobs{

    function getCash(){
        $query = "SELECT SUM(amount) AS cash FROM Jobs WHERE status = 'Paid'";
        $result = $db->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['cash'];
        } else {
            return false;
        }
    }
}
?>