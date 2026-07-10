<?php
$id = $_GET['i_id'] ?? null;

$today = date('Y-m-d');

?>



<?php include "header.php" ?>



<!-- ==================================================== -->
<!-- Start right Content here -->
<!-- ==================================================== -->
<div class="page-content">

    <!-- Start Container Fluid -->
    <div class="container-fluid">

        <!-- ========== Page Title Start ========== -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="mb-0"><?php if ($id) {
                                            echo 'Update Orders';
                                        } else {
                                            echo 'Add Orders';
                                        } ?></h4>

                </div>
            </div>
        </div>
        <div>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="order.php">Orders</a></li>

                <li class="breadcrumb-item active">
                    <?php if ($id) {
                        echo 'Update Orders';
                    } else {
                        echo 'Add Orders';
                    } ?>
                </li>
            </ol>
        </div>
        <hr>

        <!-- ========== Page Title End ========== -->

        <div class="row row-cols">
            <div class="col">
                <div class="card">


                    <div class="card-body">
                        <div>

                            <?php if ($id) {

                                $query = "SELECT * FROM `orders` WHERE i_id='$id'";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row1 = mysqli_fetch_array($query_run)) {
                            ?>

                                        <form method="POST" action="code.php">
                                            <div>

                                                <div class="row">
                                                    <input type="text" class="form-control" id='i_id' name="i_id"
                                                        value=<?php echo $id ?> hidden />

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Date</label>
                                                        <input type="text" id="basic-datepicker" name="date" class="form-control"
                                                            value="<?php echo $row1['date'] ?>">
                                                    </div>

                                                    <div class="col-md-3 col-6 mb-3">
                                                        <label class="form-label">Order No.</label>
                                                        <input type="text" id="order_no" name="order_no" class="form-control"
                                                            value="<?php echo $row1['order_no'] ?>">
                                                    </div>

                                                    <div class="col-md-3 col-6 mb-3">
                                                        <label class="form-label">Card No.</label>
                                                        <input type="text" id="card_no" name="card_no" class="form-control"
                                                            value="<?php echo $row1['card_no'] ?>">
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Party Id</label>
                                                        <input type="text" id="party_id" name="party_id" class="form-control"
                                                        value="<?php echo $row1['party_id'] ?>" readonly>
                                                    </div>


                                                </div>

                                                <div class="row">

                                                    <div class="col-md-3 mb-3">
                                                        <label for="simpleinput" class="form-label">Party Name</label>
                                                        <select class="form-select" id="p_name" name="p_name">
                                                            <option selected disabled>-- Select Party Name --</option>
                                                            <?php
                                                            $fetch_query = "SELECT * FROM party";
                                                            $fetch_query_run = mysqli_query($conn, $fetch_query);
                                                            if (mysqli_num_rows($fetch_query_run) > 0) {
                                                                while ($row = mysqli_fetch_array($fetch_query_run)) {

                                                            ?>
                                                                    <option value="<?php echo $row['p_name']; ?>"
                                                                        <?php if ($row['p_name'] == $row1['p_name']) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                        <?php echo $row['p_name']; ?>
                                                                    </option>;
                                                            <?php }
                                                            }

                                                            ?>

                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Design No</label>
                                                        <input type="text" id="design_no" name="design_no"
                                                            class="form-control design_no" placeholder="Please enter design no"
                                                            value="<?php echo $row1['design_no'] ?>">
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Description</label>
                                                        <input type="text" id="details" name="details"
                                                            class="form-control details" placeholder="Please enter order description (ex.400_big panno)"
                                                            value="<?php echo $row1['details'] ?>">
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Fabric</label>
                                                        <input type="text" id="fabric" name="fabric"
                                                            class="form-control fabric" placeholder="Please enter fabric"
                                                            value="<?php echo $row1['fabric'] ?>">
                                                    </div>



                                                </div>


                                            </div>

                                            <hr>


                                            <div id="invoiceForm">
                                                <?php
                                                $matching_no = explode(', ', $row1['matching_no']); // Laptop,Mobile,Tablet
                                                $cut = explode(', ', $row1['cut']); // Laptop,Mobile,Tablet

                                                for ($i = 0; $i < count($matching_no); $i++) {
                                                ?>

                                                    <div class="row">



                                                        <div class="col-md-5 col-4 mb-3 col-remove">
                                                            <label class="form-label">Maching No.</label>
                                                            <input type="text" name="matching_no[]" class="form-control" placeholder="Maching no"
                                                                value="<?php echo htmlspecialchars($matching_no[$i]); ?>">
                                                        </div>


                                                        <div class="col-md-5 col-4 mb-3">
                                                            <label class="form-label">Cut</label>
                                                            <input type="text" name="cut[]" class="form-control cut" placeholder="Cut"
                                                                value="<?php echo htmlspecialchars($cut[$i]); ?>">
                                                        </div>

                                                        <div class="col-md-2 col-4 mb-3 align-self-center removeBtn">  Remove
                                                            <span class="nav-icon">
                                                                <iconify-icon icon="mingcute:close-line"></iconify-icon>
                                                            </span>
                                                        </div>

                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="mb-3">

                                                <div type="button" id="addRow">
                                                    <span class="nav-text pr-2">+ Add Item </span>
                                                </div>

                                            </div>

                                            <hr>


                                            <div class="row">
                                                <div class="col-md-3 col-6 mb-3">
                                                    <label class="form-label"><b>Total Maching</b></label>
                                                    <input type="text" id="totalRow" name="total_matching"
                                                        class="form-control" readonly value="<?php echo $row1['total_matching'] ?>">
                                                </div>

                                                <div class="col-md-3 col-6 mb-3">
                                                    <label class="form-label"><b>Total Metre</b></label>
                                                    <input type="text" id="total_metre" name="total_metre"
                                                        class="form-control" readonly value="<?php echo $row1['total_metre'] ?>">
                                                </div>

                                                <div class="col-md-3 col-6 mb-3">
                                                    <label class="form-label">Rate</label>
                                                    <input type="text" id="rate" name="rate"
                                                        class="form-control rate" placeholder="Rate per metre" value="<?php echo $row1['rate'] ?>">
                                                </div>

                                                <div class="col-md-3 col-6 mb-3">
                                                    <label class="form-label"><b>Total Amount</b></label>
                                                    <input type="text" id="amount" name="amount"
                                                        class="form-control" readonly value="<?php echo $row1['amount'] ?>">
                                                </div>
                                            </div>


                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Order Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="Pending" <?= ($row1['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                                        <option value="Complete" <?= ($row1['status'] == 'Complete') ? 'selected' : '' ?>>Complete</option>
                                                        <option value="Cancel" <?= ($row1['status'] == 'Cancel') ? 'selected' : '' ?>>Cancel</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <button class="btn btn-primary cs-mr10" name="i_update" type="submit">Update</button>
                                            </div>

                                        </form>

                                <?PHP }
                                }
                            } else { ?>

                                <?php
                                // card_no & order_no Auto increase start;

                                $query = "SELECT * FROM `orders` ORDER BY i_id DESC LIMIT 1";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row1 = mysqli_fetch_array($query_run)) {
                                        $card_no = $row1['card_no'] + 1;
                                        $order_no = $row1['order_no'] + 1;
                                    }
                                }

                                // card_no & order_no Auto increase end;


                                ?>

                                <form method="POST" action="code.php">
                                    <div>

                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="text" id="basic-datepicker" name="date" class="form-control"
                                                    value="<?php echo $today; ?>">
                                            </div>
                                            <div class="col-md-3 col-6 mb-3">
                                                <label class="form-label">Order No.</label>
                                                <input type="text" id="order_no" name="order_no" class="form-control"
                                                    value="<?php echo $order_no; ?>">
                                            </div>

                                            <div class="col-md-3 col-6 mb-3">
                                                <label class="form-label">Card No.</label>
                                                <input type="text" id="card_no" name="card_no" class="form-control"
                                                    value="<?php echo $card_no; ?>">
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Party Id</label>
                                                <input type="text" id="party_id" name="party_id" class="form-control" readonly>
                                            </div>
                                        </div>


                                        <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label for="simpleinput" class="form-label">Party Name</label>
                                                <select class="form-select" id="p_name" name="p_name">
                                                    <option  selected disabled>-- Select Party Name --</option>

                                                    <?php
                                                    $res = mysqli_query($conn, "SELECT * FROM party");
                                                    while ($row = mysqli_fetch_array($res)) {
                                                        echo '<option value="' . $row['p_name'] . '">' . htmlspecialchars($row['p_name']) . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Design No</label>
                                                <input type="text" id="design_no" name="design_no"
                                                    class="form-control design_no" placeholder="Please enter order details">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Description</label>
                                                <input type="text" id="details" name="details"
                                                    class="form-control details" placeholder="Please enter order description (ex.400 - big panno)">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Fabric</label>
                                                <input type="text" id="fabric" name="fabric"
                                                    class="form-control fabric" placeholder="Please enter fabric">
                                            </div>



                                        </div>


                                    </div>


                                    <hr>

                                    <div id="invoiceForm">

                                        <div class="row">

                                            <div class="col-6 mb-3 col-remove">
                                                <label class="form-label">Maching No.</label>

                                                <input type="text" name="matching_no[]" class="form-control" placeholder="Maching no">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Cut</label>
                                                <input type="text" name="cut[]" class="form-control cut" placeholder="Cut">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3">

                                        <div type="button" id="addRow">
                                            <span class="nav-text pr-2">+ Add Item </span>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label"><b>Total Maching</b></label>
                                            <input type="text" id="totalRow" value="1" name="total_matching"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label"><b>Total Metre</b></label>
                                            <input type="text" id="total_metre" name="total_metre"
                                                class="form-control" value="0" readonly>
                                        </div>

                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label">Rate</label>
                                            <input type="text" id="rate" name="rate"
                                                class="form-control rate" placeholder="Rate per metre">
                                        </div>

                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label"><b>Total Amount</b></label>
                                            <input type="text" id="amount" name="amount"
                                                class="form-control" value="0" readonly>
                                        </div>
                                    </div>


                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="simpleinput" class="form-label">Order Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="Pending" selected>Pending</option>
                                                <option value="Complite">Complite</option>
                                                <option value="Cancel">Cancel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cs-mb-10">
                                        <button class="btn btn-primary cs-mr10 " name="i_submit" type="submit">Submit</button>
                                    </div>

                                </form>

                            <?PHP } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Container Fluid -->




        <?php include "footer.php" ?>