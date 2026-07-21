<?php
$id = $_GET['c_id'] ?? null;

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
                    <h4 class="mb-0">
                        <?php 
                            if ($id) {
                                echo 'Update Chalan';
                            } else {
                                echo 'Add Chalan';
                            } 
                        ?>
                    </h4>

                </div>
            </div>
        </div>
        <div>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="chalan.php">Chalan</a></li>

                <li class="breadcrumb-item active">
                    <?php 
                        if ($id) {
                            echo 'Update Chalan';
                        } else {
                            echo 'Add Chalan';
                        } 
                    ?>
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

                                $query = "SELECT * FROM `chalan` WHERE c_id='$id'";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_array($query_run)) {
                            ?>

                            <form method="POST" action="code.php">

                                <div>

                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <input type="text" name="c_id" class="form-control" value="<?php echo $row['c_id'] ?>" hidden>
                                            <label class="form-label">Date</label>
                                            
                                            <input type="text" id="basic-datepicker" name="c_date" class="form-control"
                                                value="<?php echo $row['c_date'] ?>">
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label">Chalan No.</label>
                                            <input type="text" id="chalan_no" name="chalan_no" class="form-control"
                                                value="<?php echo $row['chalan_no'] ?>">
                                        </div>

                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label">Order No.</label>
                                            <input type="text" id="order_no" name="order_no" class="form-control"
                                                placeholder="Please enter order no"
                                                value="<?php echo $row['order_no'] ?>">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Party Id</label>
                                            <input type="text" id="party_id" name="party_id" class="form-control"
                                                placeholder="Please select party name"
                                                value="<?php echo $row['party_id'] ?>" readonly>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="simpleinput" class="form-label">Party Name</label>
                                            <select class="form-select" id="p_name" name="p_name">
                                                <option selected disabled>-- Select Party Name --</option>

                                                <?php
                                                        $clients  = mysqli_query($conn, "SELECT * FROM party");
                                                        while ($row1 = mysqli_fetch_array($clients )) {
                                                    ?>
                                                <option value="<?php echo $row1['p_name']; ?>" 
                                                    <?php if ($row['p_name'] == $row1['p_name']) 
                                                    {echo "selected";} ?> >
                                                    <?php echo $row1['p_name']; ?>
                                                </option>';
                                                <?php
                                                        }
                                                    ?>

                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" id="p_address" name="p_address" class="form-control"
                                                placeholder="Please select party name"
                                                value="<?php echo $row['p_address'] ?>" readonly>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div id="ChalanForm">
                                    <?php 
                                    $card_nos = explode(" / ", $row['card_no']);
                                    $design_nos = explode(" / ", $row['design_no']);
                                    $matching_nos = explode(" / ", $row['matching_no']);
                                    $cuts = explode(" / ", $row['cut']);
                                    $total_metres = explode(" / ", $row['total_metre']);
                                    $rates = explode(" / ", $row['rate']);
                                    $amounts = explode(" / ", $row['amount']);

                                    $p_name_current = $row['p_name'];
                                    $active_owner_id = $_SESSION['active_owner_id'] ?? 1;
                                    $order_cards_query = mysqli_query($conn, "SELECT DISTINCT card_no FROM orders WHERE p_name = '" . mysqli_real_escape_string($conn, $p_name_current) . "' AND owner_id = $active_owner_id ORDER BY card_no DESC");
                                    $cards_list = [];
                                    while ($order_card = mysqli_fetch_assoc($order_cards_query)) {
                                        $cards_list[] = $order_card['card_no'];
                                    }

                                    for ($i = 0; $i < count($design_nos); $i++) {
                                        $c_card = $card_nos[$i] ?? '';
                                        $d_no = $design_nos[$i] ?? '';
                                        $m_no = $matching_nos[$i] ?? '';
                                        $cut_val = $cuts[$i] ?? '';
                                        $metre_val = $total_metres[$i] ?? '';
                                        $rate_val = $rates[$i] ?? '';
                                        $amount_val = $amounts[$i] ?? '';
                                    ?>
                                    <div class="design-row border p-3 mb-3 bg-light rounded position-relative">
                                        <div class="row">
                                            <div class="col-md-2 col-12 mb-3">
                                                <label class="form-label font-weight-bold">Card No</label>
                                                <select class="form-select card-select" name="card_no[]" required>
                                                    <option value="">-- Select Card No --</option>
                                                    <?php 
                                                    foreach ($cards_list as $card_no_item) {
                                                        $selected_attr = ($c_card == $card_no_item) ? "selected" : "";
                                                        echo '<option value="' . htmlspecialchars($card_no_item) . '" ' . $selected_attr . '>' . htmlspecialchars($card_no_item) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Design No</label>
                                                <input type="text" name="design_no[]" class="form-control design-no-val" value="<?php echo htmlspecialchars($d_no); ?>" readonly>
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Matching No</label>
                                                <input type="text" name="matching_no[]" class="form-control design-matching-val" value="<?php echo htmlspecialchars($m_no); ?>" readonly>
                                            </div>
                                            <div class="col-md-2 col-12 mb-3">
                                                <label class="form-label font-weight-bold">Cuts</label>
                                                <div class="cuts-section border p-2 rounded bg-white" style="min-height: 38px;">
                                                    <div class="cuts-container d-flex flex-wrap gap-1 align-items-center mb-1">
                                                        <?php 
                                                        $individual_cuts = explode(", ", $cut_val);
                                                        foreach ($individual_cuts as $c_item) {
                                                            if (trim($c_item) !== '') {
                                                        ?>
                                                        <div class="cut-input-wrapper d-flex align-items-center bg-light border rounded px-1" style="width: fit-content; margin-bottom: 2px;">
                                                            <input type="number" step="any" class="cut-val-input form-control form-control-sm border-0 p-0 text-center" style="width: 50px; background: transparent; font-size: 12px; height: auto;" value="<?php echo htmlspecialchars(trim($c_item)); ?>">
                                                            <button type="button" class="btn-close remove-cut-btn" style="font-size: 9px; padding: 2px; margin-left: 3px;" aria-label="Close"></button>
                                                        </div>
                                                        <?php 
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary btn-xs add-cut-btn" style="padding: 2px 6px; font-size: 11px;">+ Add Cut</button>
                                                </div>
                                                <input type="hidden" name="cut[]" class="design-cut-hidden" value="<?php echo htmlspecialchars($cut_val); ?>">
                                            </div>
                                            <div class="col-md-1 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Total Metre</label>
                                                <input type="text" name="total_metre[]" class="form-control design-metre" value="<?php echo htmlspecialchars($metre_val); ?>" readonly>
                                            </div>
                                            <div class="col-md-1 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Rate</label>
                                                <input type="text" name="rate[]" class="form-control design-rate" value="<?php echo htmlspecialchars($rate_val); ?>">
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Amount</label>
                                                <input type="text" name="amount[]" class="form-control design-amount amount_1" value="<?php echo htmlspecialchars($amount_val); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-design-row">Remove</button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary btn-sm" id="addDesignRow">+ Add Design Row</button>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" id="total_amount" name="total_amount" class="form-control"
                                        value="<?php echo $row['total_amount'] ?>" readonly>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary cs-mr10" name="c_update"
                                        type="submit">Update</button>
                                </div>
                            </form>

                            <?PHP }
                                }
                            } else { ?>

                            <?php
                                // card_no & order_no Auto increase start;

                                $query = "SELECT * FROM `chalan` ORDER BY c_id DESC LIMIT 1";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_array($query_run)) {
                                        $chalan_no = $row['chalan_no'] + 1;
                                    }
                                }

                                // card_no & order_no Auto increase end;


                                ?>

                            <form method="POST" action="code.php">
                                <div>

                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Date</label>
                                            <input type="text" id="basic-datepicker" name="c_date" class="form-control"
                                                value="<?php echo $today; ?>">
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label">Chalan No.</label>
                                            <input type="text" id="chalan_no" name="chalan_no" class="form-control"
                                                value="<?php echo $chalan_no; ?>">
                                        </div>

                                        <div class="col-md-3 col-6 mb-3">
                                            <label class="form-label">Order No.</label>
                                            <input type="text" id="order_no" name="order_no" class="form-control"
                                                placeholder="Please enter order no">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Party Id</label>
                                            <input type="text" id="party_id" name="party_id" class="form-control"
                                                placeholder="Please select party name" readonly>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="simpleinput" class="form-label">Party Name</label>
                                            <select class="form-select" id="p_name" name="p_name">
                                                <option selected disabled>-- Select Party Name --</option>

                                                <?php
                                                        $clients  = mysqli_query($conn, "SELECT * FROM party");
                                                        while ($row = mysqli_fetch_array($clients )) {
                                                    ?>
                                                <option value="<?php echo $row['p_name']; ?>">
                                                    <?php echo $row['p_name']; ?>
                                                </option>';
                                                <?php
                                                        }
                                                    ?>

                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" id="p_address" name="p_address" class="form-control"
                                                placeholder="Please select party name" readonly>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div id="ChalanForm">
                                    <div class="design-row border p-3 mb-3 bg-light rounded position-relative">
                                        <div class="row">
                                            <div class="col-md-2 col-12 mb-3">
                                                <label class="form-label font-weight-bold">Card No</label>
                                                <select class="form-select card-select" name="card_no[]" required>
                                                    <option value="">-- Select Card No --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Design No</label>
                                                <input type="text" name="design_no[]" class="form-control design-no-val" readonly>
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Matching No</label>
                                                <input type="text" name="matching_no[]" class="form-control design-matching-val" readonly>
                                            </div>
                                            <div class="col-md-2 col-12 mb-3">
                                                <label class="form-label font-weight-bold">Cuts</label>
                                                <div class="cuts-section border p-2 rounded bg-white" style="min-height: 38px;">
                                                    <div class="cuts-container d-flex flex-wrap gap-1 align-items-center mb-1">
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary btn-xs add-cut-btn" style="padding: 2px 6px; font-size: 11px;">+ Add Cut</button>
                                                </div>
                                                <input type="hidden" name="cut[]" class="design-cut-hidden">
                                            </div>
                                            <div class="col-md-1 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Total Metre</label>
                                                <input type="text" name="total_metre[]" class="form-control design-metre" readonly>
                                            </div>
                                            <div class="col-md-1 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Rate</label>
                                                <input type="text" name="rate[]" class="form-control design-rate">
                                            </div>
                                            <div class="col-md-2 col-6 mb-3">
                                                <label class="form-label font-weight-bold">Amount</label>
                                                <input type="text" name="amount[]" class="form-control design-amount amount_1" readonly>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-design-row">Remove</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary btn-sm" id="addDesignRow">+ Add Design Row</button>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" id="total_amount" name="total_amount" class="form-control"
                                        value="0" readonly>
                                </div>


                                <div class="col-md-4 col-12 cs-mb-10">
                                    <button class="btn btn-primary cs-mr10 " name="c_submit"
                                        type="submit">Submit</button>
                                </div>
                            </form>

                            <?PHP } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Container Fluid -->




        <!-- Calculations are handled in assets/js/invoice.js -->




        <?php include "footer.php" ?>