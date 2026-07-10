<?php include "../db_con.php"?>

<?php

$p_name = $_POST['p_name'];

session_start();
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;
$result = $conn->query("SELECT * FROM party LEFT JOIN orders ON party.p_name = orders.p_name WHERE party.p_name='$p_name' AND party.owner_id = $active_owner_id");
$data = $result->fetch_assoc();
echo json_encode($data);

?>

