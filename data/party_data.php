<?php 
include "../db_con.php";
session_start();
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

recalculate_all_parties($conn);

$result = $conn->query("SELECT * FROM `party` WHERE owner_id = $active_owner_id");
$party = [];

while($row = $result->fetch_assoc()) {
    $party[] = $row; 
}

echo json_encode(['party' => $party]);
$conn->close();
?>