<?php include "db_con.php"; ?>

<?php

function owner_image_path($imageName)
{
  return __DIR__ . '/assets/img/' . $imageName;
}

function owner_upload_image(array $imageFile, &$errorMessage = null)
{
  if (!isset($imageFile['name'])) {
    return null;
  }

  $imageNames = is_array($imageFile['name']) ? array_values(array_filter($imageFile['name'], 'strlen')) : [$imageFile['name']];
  if (count($imageNames) === 0) {
    return null;
  }

  if (count($imageNames) !== 1) {
    $errorMessage = 'Please keep only one owner photo before submitting.';
    return false;
  }

  $imageErrors = is_array($imageFile['error']) ? $imageFile['error'] : [$imageFile['error']];
  $imageTemps = is_array($imageFile['tmp_name']) ? $imageFile['tmp_name'] : [$imageFile['tmp_name']];

  if (($imageErrors[0] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    $errorMessage = 'Image upload failed. Please choose an image again.';
    return false;
  }

  $uploadDir = __DIR__ . '/assets/img/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $sanitizedName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($imageNames[0]));
  $storedName = uniqid('owner_', true) . '_' . $sanitizedName;
  $targetPath = $uploadDir . $storedName;

  if (!move_uploaded_file($imageTemps[0], $targetPath)) {
    $errorMessage = 'Image could not be saved on server. Check the upload folder permissions.';
    return false;
  }

  return $storedName;
}

if (isset($_POST['o_submit'])) {

  $name = $_POST['name'];
  $mobile_1 = $_POST['mobile_1'];
  $mobile_2 = $_POST['mobile_2'];
  $address = $_POST['address'];  
  $user_name = $_POST['user_name'];
  $pass = $_POST['pass'];


    // Image Upload
    $uploadError = null;
    $filename = owner_upload_image($_FILES['image'], $uploadError);

    if ($filename === false) {
      echo '<div class="alert alert-danger text-center fs-4" role="alert">' . htmlspecialchars($uploadError) . '</div>';
      exit;
    }



    $query = "INSERT INTO `users`(`name`, `mobile_1`, `mobile_2`, `address`, `img`, `user_name`, `pass`) 
              VALUES ('$name','$mobile_1','$mobile_2','$address','$filename','$user_name','$pass')";
    $result = mysqli_query($conn, $query);



    if ($result) {
      echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
      header('location: settings.php');
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
  $old = $_POST['old_image'] ?? '';

  $image = $old;
  $uploadError = null;

  if (isset($_FILES['image']) && (
    (!is_array($_FILES['image']['name']) && $_FILES['image']['name'] !== '') ||
    (is_array($_FILES['image']['name']) && count(array_filter($_FILES['image']['name'], 'strlen')) > 0)
  )) {
    $newImage = owner_upload_image($_FILES['image'], $uploadError);

    if ($newImage === false) {
      echo '<div class="alert alert-danger text-center fs-4" role="alert">' . htmlspecialchars($uploadError) . '</div>';
      exit;
    }

    if ($newImage !== null) {
      $image = $newImage;
    }
  }

  $update_query = "UPDATE `users` SET `name`='$name', `mobile_1`='$mobile_1', `mobile_2`='$mobile_2', `address`='$address', `img`='$image',
   `user_name`='$user_name', `pass`='$pass'
         WHERE owner_id = '$owner_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    if ($image !== $old && $old !== '') {
      $oldPath = owner_image_path($old);
      if (is_file($oldPath)) {
        unlink($oldPath);
      }
    }

    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: settings.php');
  } else {
    if ($image !== $old && $image !== '' && is_file(owner_image_path($image))) {
      unlink(owner_image_path($image));
    }

    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}

if (isset($_POST['o_delete'])) {

  $owner_id = $_POST['owner_id'];

  $data = $conn->query("SELECT img FROM users WHERE owner_id=$owner_id");
  $row = $data ? $data->fetch_assoc() : null;

  if (!empty($row['img'])) {
    $imagePath = owner_image_path($row['img']);
    if (is_file($imagePath)) {
      unlink($imagePath);
    }
  }

  $deleteResult = $conn->query("DELETE FROM users WHERE owner_id=$owner_id");


  if ($deleteResult) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: settings.php');
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
  $rate = 0;
  $amount = 0;
  $status = $_POST['status'];

  $query = "INSERT INTO `orders`(`date`, `order_no`, `party_id`, `p_name`, `card_no`, `design_no`, `details`, `fabric`, `cut`, `total_metre`, 
          `matching_no`, `total_matching`, `rate`, `amount`, `status`) 
          VALUES ('$date','$order_no','$party_id','$p_name','$card_no','$design_no','$details','$fabric','$cut','$total_metre','$matching_no',
          '$total_matching','$rate','$amount','$status')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Successfully Send </div>';
    header('location: order.php');
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
  $rate = 0;
  $amount = 0;
  $status = $_POST['status'];

  $update_query = "UPDATE `orders` SET `date`='$date', `order_no`='$order_no', `party_id`='$party_id', `p_name`='$p_name',
        `card_no`='$card_no', `design_no`='$design_no', `details`='$details', `fabric`='$fabric', `cut`='$cut', `total_metre`='$total_metre',
         `matching_no`='$matching_no', `total_matching`='$total_matching', `rate`='$rate', `amount`='$amount', `status`='$status' 
         WHERE i_id = '$i_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: order.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}


if (isset($_POST['i_delete'])) {

  $i_id = $_POST['i_id'];

  $delete_query = "DELETE FROM `orders` WHERE i_id = '$i_id'";


  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: order.php');
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
  $order_no_post = trim($_POST['order_no'] ?? '');
  $order_no = ($order_no_post !== '') ? "'" . mysqli_real_escape_string($conn, $order_no_post) . "'" : "NULL";

  $card_no_arr = array_map('trim', $_POST['card_no'] ?? []);
  $design_no_arr = array_map('trim', $_POST['design_no'] ?? []);
  $matching_no_arr = array_map('trim', $_POST['matching_no'] ?? []);
  $cut_arr = array_map('trim', $_POST['cut'] ?? []);
  $total_metre_arr = array_map('trim', $_POST['total_metre'] ?? []);
  $rate_arr = array_map('trim', $_POST['rate'] ?? []);
  $amount_arr = array_map('trim', $_POST['amount'] ?? []);

  $card_nos_filtered = [];
  $design_nos_filtered = [];
  $matching_nos_filtered = [];
  $cuts_filtered = [];
  $total_metres_filtered = [];
  $rates_filtered = [];
  $amounts_filtered = [];

  for ($i = 0; $i < count($design_no_arr); $i++) {
    if (!empty($design_no_arr[$i]) || !empty($card_no_arr[$i])) {
      $card_nos_filtered[] = $card_no_arr[$i] ?? '';
      $design_nos_filtered[] = $design_no_arr[$i] ?? '';
      $matching_nos_filtered[] = $matching_no_arr[$i] ?? '';
      $cuts_filtered[] = $cut_arr[$i] ?? '';
      $total_metres_filtered[] = $total_metre_arr[$i] ?? '';
      $rates_filtered[] = $rate_arr[$i] ?? '';
      $amounts_filtered[] = $amount_arr[$i] ?? '';
    }
  }

  $card_no = implode(" / ", $card_nos_filtered);
  $design_no = implode(" / ", $design_nos_filtered);
  $matching_no = implode(" / ", $matching_nos_filtered);
  $cut = implode(" / ", $cuts_filtered);
  $total_metre = implode(" / ", $total_metres_filtered);
  $rate = implode(" / ", $rates_filtered);
  $amount = implode(" / ", $amounts_filtered);
 
  $total_amount = $_POST['total_amount'];

  $query = "INSERT INTO `chalan`(`chalan_no`, `c_date`, `party_id`, `p_name`, `p_address`, `order_no`, `card_no`, `design_no`, `matching_no`, `cut`, `total_metre`, `rate`, `amount`, `total_amount`) 
          VALUES ('$chalan_no','$c_date','$party_id','$p_name','$p_address',$order_no,'$card_no','$design_no','$matching_no','$cut','$total_metre','$rate','$amount','$total_amount')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    recalculate_party_amounts($conn, $party_id);
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
  $order_no_post = trim($_POST['order_no'] ?? '');
  $order_no = ($order_no_post !== '') ? "'" . mysqli_real_escape_string($conn, $order_no_post) . "'" : "NULL";

  $card_no_arr = array_map('trim', $_POST['card_no'] ?? []);
  $design_no_arr = array_map('trim', $_POST['design_no'] ?? []);
  $matching_no_arr = array_map('trim', $_POST['matching_no'] ?? []);
  $cut_arr = array_map('trim', $_POST['cut'] ?? []);
  $total_metre_arr = array_map('trim', $_POST['total_metre'] ?? []);
  $rate_arr = array_map('trim', $_POST['rate'] ?? []);
  $amount_arr = array_map('trim', $_POST['amount'] ?? []);

  $card_nos_filtered = [];
  $design_nos_filtered = [];
  $matching_nos_filtered = [];
  $cuts_filtered = [];
  $total_metres_filtered = [];
  $rates_filtered = [];
  $amounts_filtered = [];

  for ($i = 0; $i < count($design_no_arr); $i++) {
    if (!empty($design_no_arr[$i]) || !empty($card_no_arr[$i])) {
      $card_nos_filtered[] = $card_no_arr[$i] ?? '';
      $design_nos_filtered[] = $design_no_arr[$i] ?? '';
      $matching_nos_filtered[] = $matching_no_arr[$i] ?? '';
      $cuts_filtered[] = $cut_arr[$i] ?? '';
      $total_metres_filtered[] = $total_metre_arr[$i] ?? '';
      $rates_filtered[] = $rate_arr[$i] ?? '';
      $amounts_filtered[] = $amount_arr[$i] ?? '';
    }
  }

  $card_no = implode(" / ", $card_nos_filtered);
  $design_no = implode(" / ", $design_nos_filtered);
  $matching_no = implode(" / ", $matching_nos_filtered);
  $cut = implode(" / ", $cuts_filtered);
  $total_metre = implode(" / ", $total_metres_filtered);
  $rate = implode(" / ", $rates_filtered);
  $amount = implode(" / ", $amounts_filtered);
 
  $total_amount = $_POST['total_amount'];

  $update_query = "UPDATE `chalan` SET `c_date`='$c_date', `chalan_no`='$chalan_no', `party_id`='$party_id', `p_name`='$p_name', `p_address`='$p_address', 
  `order_no`=$order_no, `card_no`='$card_no', `design_no`='$design_no', `matching_no`='$matching_no', `cut`='$cut', `total_metre`='$total_metre', `rate`='$rate', `amount`='$amount', `total_amount`='$total_amount' 
  WHERE c_id = '$c_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    recalculate_party_amounts($conn, $party_id);
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: chalan.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}


if (isset($_POST['c_delete'])) {

  $c_id = $_POST['c_id'];

  $c_q = mysqli_query($conn, "SELECT party_id FROM chalan WHERE c_id = '$c_id'");
  $c_row = mysqli_fetch_assoc($c_q);
  $party_id = $c_row['party_id'] ?? null;

  $delete_query = "DELETE FROM `chalan` WHERE c_id = '$c_id'";

  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    if ($party_id) {
        recalculate_party_amounts($conn, $party_id);
    }
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

  $chalan_no_arr = array_map('trim', $_POST['chalan_no'] ?? []);
  $c_amount_arr = array_map('trim', $_POST['c_amount'] ?? []);
  $design_no_arr = array_map('trim', $_POST['design_no'] ?? []);
  $total_metre_arr = array_map('trim', $_POST['total_metre'] ?? []);
  $rate_arr = array_map('trim', $_POST['rate'] ?? []);

  $chalans_filtered = [];
  $c_amounts_filtered = [];
  $designs_filtered = [];
  $total_metres_filtered = [];
  $rates_filtered = [];
  for ($i = 0; $i < count($chalan_no_arr); $i++) {
    if (!empty($chalan_no_arr[$i])) {
      $chalans_filtered[] = $chalan_no_arr[$i];
      $c_amounts_filtered[] = $c_amount_arr[$i] ?? '0';
      $designs_filtered[] = $design_no_arr[$i] ?? '';
      $total_metres_filtered[] = $total_metre_arr[$i] ?? '';
      $rates_filtered[] = $rate_arr[$i] ?? '';
    }
  }
  $chalan_no = implode(", ", $chalans_filtered);
  $c_amount = implode(", ", $c_amounts_filtered);
  $design_no = implode(", ", $designs_filtered);
  $total_metre = implode(", ", $total_metres_filtered);
  $rate = implode(", ", $rates_filtered);

  $c_total_amount = $_POST['total_c_amount'];
  $d_rate = $_POST['dis_rate'];
  $d_amount = $_POST['dis_amount'];

  $cgst_rate = $_POST['cgst_rate'] ?? '2.50';
  $sgst_rate = $_POST['sgst_rate'] ?? '2.50';

  $cgst = $_POST['cgst'];
  $sgst = $_POST['sgst'];
  $total_gst = $_POST['totalgst'];
  $total_amount = $_POST['final_amount'];
  $paid_amount = $_POST['paid_amount'];
  $pending_amount = $_POST['pending_amount'];

  $query = "INSERT INTO `bill`(`bill_no`, `b_date`, `party_id`, `p_name`, `p_address`, `gst`, `chalan_no`, `design_no`, `total_metre`, `rate`, `c_amount`, `c_total_amount`, `d_rate`, `d_amount`, `cgst`, 
                                  `sgst`, `total_gst`, `total_amount`, `paid_amount`, `pending_amount`, `cgst_rate`, `sgst_rate`) 
          VALUES ('$bill_no','$b_date','$party_id','$p_name','$p_address','$gst','$chalan_no','$design_no','$total_metre','$rate','$c_amount','$c_total_amount','$d_rate','$d_amount',
          '$cgst','$sgst','$total_gst','$total_amount','$paid_amount','$pending_amount', '$cgst_rate', '$sgst_rate')";

  $result = mysqli_query($conn, $query);


  if ($result) {
    recalculate_party_amounts($conn, $party_id);
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

  $chalan_no_arr = array_map('trim', $_POST['chalan_no'] ?? []);
  $c_amount_arr = array_map('trim', $_POST['c_amount'] ?? []);
  $design_no_arr = array_map('trim', $_POST['design_no'] ?? []);
  $total_metre_arr = array_map('trim', $_POST['total_metre'] ?? []);
  $rate_arr = array_map('trim', $_POST['rate'] ?? []);

  $chalans_filtered = [];
  $c_amounts_filtered = [];
  $designs_filtered = [];
  $total_metres_filtered = [];
  $rates_filtered = [];
  for ($i = 0; $i < count($chalan_no_arr); $i++) {
    if (!empty($chalan_no_arr[$i])) {
      $chalans_filtered[] = $chalan_no_arr[$i];
      $c_amounts_filtered[] = $c_amount_arr[$i] ?? '0';
      $designs_filtered[] = $design_no_arr[$i] ?? '';
      $total_metres_filtered[] = $total_metre_arr[$i] ?? '';
      $rates_filtered[] = $rate_arr[$i] ?? '';
    }
  }
  $chalan_no = implode(", ", $chalans_filtered);
  $c_amount = implode(", ", $c_amounts_filtered);
  $design_no = implode(", ", $designs_filtered);
  $total_metre = implode(", ", $total_metres_filtered);
  $rate = implode(", ", $rates_filtered);

  $c_total_amount = $_POST['total_c_amount'];
  $d_rate = $_POST['dis_rate'];
  $d_amount = $_POST['dis_amount'];

  $cgst_rate = $_POST['cgst_rate'] ?? '2.50';
  $sgst_rate = $_POST['sgst_rate'] ?? '2.50';

  $cgst = $_POST['cgst'];
  $sgst = $_POST['sgst'];
  $total_gst = $_POST['totalgst'];
  $total_amount = $_POST['final_amount'];
  $paid_amount = $_POST['paid_amount'];
  $pending_amount = $_POST['pending_amount'];


  $update_query = "UPDATE `bill` SET `b_date`='$b_date', `bill_no`='$bill_no', `party_id`='$party_id', `p_name`='$p_name', `p_address`='$p_address', `gst`='$gst', 
  `chalan_no`='$chalan_no', `design_no`='$design_no', `total_metre`='$total_metre', `rate`='$rate', `c_amount`='$c_amount', `c_total_amount`='$c_total_amount', `d_rate`='$d_rate', `d_amount`='$d_amount', `cgst`='$cgst',
        `sgst`='$sgst', `total_gst`='$total_gst', `total_amount`='$total_amount', `paid_amount`='$paid_amount',`pending_amount`='$pending_amount',
        `cgst_rate`='$cgst_rate', `sgst_rate`='$sgst_rate' WHERE b_id = '$b_id'";

  $update_query_run = mysqli_query($conn, $update_query);

  if ($update_query_run) {
    recalculate_party_amounts($conn, $party_id);
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Data Update Successfully </div>';
    header('location: bill.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Data Not Update </div>';
  }
}




if (isset($_POST['b_delete'])) {

  $b_id = $_POST['b_id'];

  $b_q = mysqli_query($conn, "SELECT party_id FROM bill WHERE b_id = '$b_id'");
  $b_row = mysqli_fetch_assoc($b_q);
  $party_id = $b_row['party_id'] ?? null;

  $delete_query = "DELETE FROM `bill` WHERE b_id = '$b_id'";

  $delete_query_run = mysqli_query($conn, $delete_query);

  if ($delete_query_run) {
    if ($party_id) {
        recalculate_party_amounts($conn, $party_id);
    }
    echo '<div class="alert alert-success text-center fs-4" role="alert"> Delete Data Successfully </div>';
    header('location: bill.php');
  } else {
    echo '<div class="alert alert-danger text-center fs-4" role="alert"> Not Delete Data</div>';
  }
}
?>