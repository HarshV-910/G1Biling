<?php 
include "../db_con.php";
session_start();
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

$result = $conn->query("SELECT * FROM `bill` WHERE owner_id = $active_owner_id");
$bill = [];

while($row = $result->fetch_assoc()) {
    $bill[] = $row; 
}

echo json_encode(['bill' => $bill]);
$conn->close();
?>