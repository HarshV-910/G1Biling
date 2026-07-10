<?php 
include "../db_con.php";
session_start();
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

$result = $conn->query("SELECT * FROM `orders` WHERE owner_id = $active_owner_id");
$invoice = [];

while($row = $result->fetch_assoc()) {
    $invoice[] = $row; 
}

echo json_encode(['invoice' => $invoice]);
$conn->close();
?>