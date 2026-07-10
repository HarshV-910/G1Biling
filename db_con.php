<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'g1_fashion';


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function recalculate_party_amounts($conn, $party_id) {
    if (empty($party_id)) return;
    
    $query = "SELECT SUM(total_amount) AS total, SUM(pending_amount) AS pending FROM bill WHERE party_id = '$party_id'";
    $res = mysqli_query($conn, $query);
    $total = 0;
    $pending = 0;
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $total = floatval($row['total'] ?? 0);
        $pending = floatval($row['pending'] ?? 0);
    }
    
    mysqli_query($conn, "UPDATE party SET total_amount = '$total', pending_amount = '$pending' WHERE party_id = '$party_id'");
}

function recalculate_all_parties($conn) {
    $res = mysqli_query($conn, "SELECT party_id FROM party");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            recalculate_party_amounts($conn, $row['party_id']);
        }
    }
}
?>