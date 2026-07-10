<?php include "../db_con.php";
session_start();

$p_name = $_POST['p_name'];
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

$sql =  "SELECT * FROM orders WHERE p_name = '$p_name' AND owner_id = $active_owner_id";
$result = mysqli_query($conn,$sql);

echo '<option id="non" value="">-- Select Design No -- </option>';



while($row=mysqli_fetch_assoc($result))
{
?>

<option value="<?php echo $row['design_no']?>">
    <?php echo $row['design_no']?>
</option>

<?php 
}

?>