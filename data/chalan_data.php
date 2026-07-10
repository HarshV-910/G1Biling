<?php 
include "../db_con.php";
session_start();
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

$result = $conn->query("SELECT * FROM `chalan` WHERE owner_id = $active_owner_id");
$chalan = [];

while($row = $result->fetch_assoc()) {
    $chalan[] = $row; 
}

echo json_encode(['chalan' => $chalan]);
$conn->close();
?>