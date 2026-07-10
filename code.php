<?php include "db_con.php"; ?>

<?php

if (isset($_POST['o_submit'])) {

  $name = $_POST['name'];
  $mobile_1 = $_POST['mobile_1'];
  $mobile_2 = $_POST['mobile_2'];
  $address = $_POST['address'];  
  $user_name = $_POST['user_name'];
  $pass = $_POST['pass'];


    // Image Upload
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = 'assets/img/'.$filename;

    move_uploaded_file($tempname, $folder);



    $query = "INSERT INTO `users`(`name`, `mobile_1`, `mobile_2`, `address`, `img`, `user_name`, `pass`) 
              VALUES ('$name','$mobile_1','$mobile_2','$address','$filename','$user_name','$pass')";
    $result = mysqli_query($conn, $query);



    if ($result) {
      echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
      header('location: owner.php');
    } else {
      echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Send </div>';
    }
  }



if (isset($_POST['o_update'])) {

  $owner_id = $_POST['owner_id'];
  $name = $_POST['name'];
  $mobile_1 = $_POST['mobile_1'];
  $mobile_2 = $_POST['mobile_2'];
  $address = $_POST['address'];
  $user_name = $_POST['user_name'];
  $pass = $_POST['pass'];
  $old=$_POST['old_image'];

if($_FILES['image']['name']!="")
{
  unlink("assets/img/".$old);

    $image=$_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'],
    "assets/img/".$image);
}
else
{
    $image=$old;
}

  $update_query = "UPDATE `users` SET `name`='$name', `mobile_1`='$mobile_1', `mobile_2`='$mobile_2', `address`='$address', `img`='$image',
   `user_name`='$user_name', `pass`='$pass'
         WHERE owner_id = '$owner_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: owner.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}

if (isset($_POST['o_delete'])) {

  $owner_id = $_POST['owner_id'];

$data=$conn->query("SELECT img FROM users WHERE owner_id=$owner_id");

$row=$data->fetch_assoc();

unlink("assets/img/".$row['img']);

$conn->query("DELETE FROM users WHERE owner_id=$owner_id");


  if ($conn) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: owner.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}

?>


<?php

if (isset($_POST['p_submit'])) {

  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $gst = $_POST['gst'];
  $email_id = $_POST['email_id'];
  $mobile_no = $_POST['mobile_no'];
  $p_address = $_POST['p_address'];

  $query = "INSERT INTO `party`(`party_id`, `p_name`, `gst`, `email_id`, `mobile_no`, `p_address`) VALUES ('$party_id','$p_name','$gst','$email_id','$mobile_no','$p_address')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
    header('location: party.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Send </div>';
  }
}


if (isset($_POST['p_update'])) {

  $p_id = $_POST['p_id'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $gst = $_POST['gst'];
  $email_id = $_POST['email_id'];
  $mobile_no = $_POST['mobile_no'];
  $p_address = $_POST['p_address'];


  $update_query = "UPDATE `party` SET `party_id`='$party_id', `p_name`='$p_name', `gst`='$gst', `email_id`='$email_id', `mobile_no`='$mobile_no', `p_address`='$p_address'
         WHERE p_id = '$p_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: party.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}


if (isset($_POST['p_delete'])) {

  $p_id = $_POST['p_id'];

  $delete_query = "DELETE FROM `party` WHERE p_id = '$p_id'";


  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: party.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}

?>






<?php

if (isset($_POST['i_submit'])) {

  $date = $_POST['date'];
  $order_no = $_POST['order_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $card_no = $_POST['card_no'];
  $design_no = $_POST['design_no'];
  $details = $_POST['details'];
  $fabric = $_POST['fabric'];
  $cut = implode(", ", $_POST['cut']);
  $total_metre = $_POST['total_metre'];
  $matching_no = implode(", ", $_POST['matching_no']);
  $total_matching = $_POST['total_matching'];
  $rate = $_POST['rate'];
  $total_amount = $_POST['amount'];
  $status = $_POST['status'];

  $query = "INSERT INTO `invoice`(`date`, `order_no`, `party_id`, `p_name`, `card_no`, `design_no`, `details`, `fabric`, `cut`, `total_metre`, 
          `matching_no`, `total_matching`, `rate`, `amount`, `status`) 
          VALUES ('$date','$order_no','$party_id','$p_name','$card_no','$design_no','$details','$fabric','$cut','$total_metre','$matching_no',
          '$total_matching','$rate','$amount','$status')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
    header('location: invoice.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Send </div>';
  }
}


if (isset($_POST['i_update'])) {

  $i_id = $_POST['i_id'];
  $date = $_POST['date'];
  $order_no = $_POST['order_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $card_no = $_POST['card_no'];
  $design_no = $_POST['design_no'];
  $details = $_POST['details'];
  $fabric = $_POST['fabric'];
  $cut = implode(", ", $_POST['cut']);
  $total_metre = $_POST['total_metre'];
  $matching_no = implode(", ", $_POST['matching_no']);
  $total_matching = $_POST['total_matching'];
  $rate = $_POST['rate'];
  $amount = $_POST['amount'];
  $status = $_POST['status'];

  $update_query = "UPDATE `invoice` SET `date`='$date', `order_no`='$order_no', `party_id`='$party_id', `p_name`='$p_name',
        `card_no`='$card_no', `design_no`='$design_no', `details`='$details', `fabric`='$fabric', `cut`='$cut', `total_metre`='$total_metre',
         `matching_no`='$matching_no', `total_matching`='$total_matching', `rate`='$rate', `amount`='$amount', `status`='$status' 
         WHERE i_id = '$i_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: invoice.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}


if (isset($_POST['i_delete'])) {

  $i_id = $_POST['i_id'];

  $delete_query = "DELETE FROM `invoice` WHERE i_id = '$i_id'";


  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: invoice.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}

?>













<?php

if (isset($_POST['c_submit'])) {

  $c_date = $_POST['c_date'];
  $chalan_no = $_POST['chalan_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $p_address = $_POST['p_address'];
  $order_no = $_POST['order_no'];


  $design_no_1 = trim($_POST['design_no_1']);
  $design_no_2  = trim($_POST['design_no_2']);

  if($design_no_2){
    $design_no = $design_no_1 . " / " . $design_no_2;
  }
  else{
    $design_no = $design_no_1;
  }


  $cut_1 = trim($_POST['cut_1']);
  $cut_2  = trim($_POST['cut_2']);

  if($design_no_2){
      $cut = $cut_1 . " / " . $cut_2;
  }
  else{
    $cut = $cut_1;
  }


  $total_metre_1 = trim($_POST['total_metre_1']);
  $total_metre_2  = trim($_POST['total_metre_2']);

  if($design_no_2){
    $total_metre = $total_metre_1 . " / " . $total_metre_2;
  }
  else{
    $total_metre = $total_metre_1;
  }


  $rate_1 = trim($_POST['rate_1']);
  $rate_2  = trim($_POST['rate_2']);

  if($design_no_2){
    $rate = $rate_1 . " / " . $rate_2;
  }
  else{
    $rate = $rate_1;
  }


  $amount_1 = trim($_POST['amount_1']);
  $amount_2  = trim($_POST['amount_2']);
  if($design_no_2){
    $amount = $amount_1 . " / " . $amount_2;
  }
  else{
    $amount = $amount_1;
  }
 
  $total_amount = $_POST['total_amount'];

  $query = "INSERT INTO `chalan`(`chalan_no`, `c_date`, `party_id`, `p_name`, `p_address`, `order_no`, `design_no`, `cut`, `total_metre`, `rate`, `amount`, `total_amount`) 
          VALUES ('$chalan_no','$c_date','$party_id','$p_name','$p_address','$order_no','$design_no','$cut','$total_metre','$rate','$amount','$total_amount')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
    header('location: chalan.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Send </div>';
  }
}


if (isset($_POST['c_update'])) {

  $c_id = $_POST['c_id'];
 $c_date = $_POST['c_date'];
  $chalan_no = $_POST['chalan_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $p_address = $_POST['p_address'];
  $order_no = $_POST['order_no'];


  $design_no_1 = trim($_POST['design_no_1']);
  $design_no_2  = trim($_POST['design_no_2']);

  if($design_no_2){
    $design_no = $design_no_1 . " / " . $design_no_2;
  }
  else{
    $design_no = $design_no_1;
  }


  $cut_1 = trim($_POST['cut_1']);
  $cut_2  = trim($_POST['cut_2']);

  if($design_no_2){
      $cut = $cut_1 . " / " . $cut_2;
  }
  else{
    $cut = $cut_1;
  }


  $total_metre_1 = trim($_POST['total_metre_1']);
  $total_metre_2  = trim($_POST['total_metre_2']);

  if($design_no_2){
    $total_metre = $total_metre_1 . " / " . $total_metre_2;
  }
  else{
    $total_metre = $total_metre_1;
  }


  $rate_1 = trim($_POST['rate_1']);
  $rate_2  = trim($_POST['rate_2']);

  if($design_no_2){
    $rate = $rate_1 . " / " . $rate_2;
  }
  else{
    $rate = $rate_1;
  }


  $amount_1 = trim($_POST['amount_1']);
  $amount_2  = trim($_POST['amount_2']);
  if($design_no_2){
    $amount = $amount_1 . " / " . $amount_2;
  }
  else{
    $amount = $amount_1;
  }
 
  $total_amount = $_POST['total_amount'];

  

  $update_query = "UPDATE `chalan` SET `c_date`='$c_date', `chalan_no`='$chalan_no', `party_id`='$party_id', `p_name`='$p_name', `p_address`='$p_address', 
  `order_no`='$order_no', `design_no`='$design_no', `cut`='$cut', `total_metre`='$total_metre', `rate`='$rate', `amount`='$amount', `total_amount`='$total_amount' 
  WHERE c_id = '$c_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: chalan.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}


if (isset($_POST['c_delete'])) {

  $c_id = $_POST['c_id'];

  $delete_query = "DELETE FROM `chalan` WHERE c_id = '$c_id'";

  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: chalan.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}

?>










<?php

if (isset($_POST['b_submit'])) {

  $b_date = $_POST['b_date'];
  $bill_no = $_POST['bill_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $p_address = $_POST['p_address'];
  $gst = $_POST['gst'];
  $chalan_no = implode(", ", $_POST['chalan_no']);
  $c_amount = implode(", ", $_POST['c_amount']);
  $c_total_amount = $_POST['total_c_amount'];
  $d_rate = $_POST['dis_rate'];
  $d_amount = $_POST['dis_amount'];
  $cgst = $_POST['cgst'];
  $sgst = $_POST['sgst'];
  $total_gst = $_POST['totalgst'];
  $total_amount = $_POST['final_amount'];
  $paid_amount = $_POST['paid_amount'];
  $pending_amount = $_POST['pending_amount'];

  $query = "INSERT INTO `bill`(`bill_no`, `b_date`, `party_id`, `p_name`, `p_address`, `gst`, `chalan_no`, `c_amount`, `c_total_amount`, `d_rate`, `d_amount`, `cgst`, 
                                  `sgst`, `total_gst`, `total_amount`, `paid_amount`, `pending_amount`) 
          VALUES ('$bill_no','$b_date','$party_id','$p_name','$p_address','$gst','$chalan_no','$c_amount','$c_total_amount','$d_rate','$d_amount',
          '$cgst','$sgst','$total_gst','$total_amount','$paid_amount','$pending_amount')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
    header('location: bill.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Send </div>';
  }
}




if (isset($_POST['b_update'])) {

  $b_id = $_POST['b_id'];
  $b_date = $_POST['b_date'];
  $bill_no = $_POST['bill_no'];
  $party_id = $_POST['party_id'];
  $p_name = $_POST['p_name'];
  $p_address = $_POST['p_address'];
  $gst = $_POST['gst'];
  $chalan_no = implode(", ", $_POST['chalan_no']);
  $c_amount = implode(", ", $_POST['c_amount']);
  $c_total_amount = $_POST['total_c_amount'];
  $d_rate = $_POST['dis_rate'];
  $d_amount = $_POST['dis_amount'];
  $cgst = $_POST['cgst'];
  $sgst = $_POST['sgst'];
  $total_gst = $_POST['totalgst'];
  $total_amount = $_POST['final_amount'];
  $paid_amount = $_POST['paid_amount'];
  $pending_amount = $_POST['pending_amount'];


  $update_query = "UPDATE `bill` SET `b_date`='$b_date', `bill_no`='$bill_no', `party_id`='$party_id', `p_name`='$p_name', `p_address`='$p_address', `gst`='$gst', 
  `chalan_no`='$chalan_no', `c_amount`='$c_amount', `c_total_amount`='$c_total_amount', `d_rate`='$d_rate', `d_amount`='$d_amount', `cgst`='$cgst',
        `sgst`='$sgst', `total_gst`='$total_gst', `total_amount`='$total_amount', `paid_amount`='$paid_amount',`pending_amount`='$pending_amount' WHERE b_id = '$b_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: bill.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}




if (isset($_POST['b_delete'])) {

  $b_id = $_POST['b_id'];

  $delete_query = "DELETE FROM `bill` WHERE b_id = '$b_id'";


  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: bill.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}

?>