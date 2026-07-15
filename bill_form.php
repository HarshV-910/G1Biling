<?php
$id = $_GET['b_id'] ?? null;

$today = date('Y-m-d');

?>



<?php include "header.php" ?>



<!====================================================>
    <! Start right Content here>
        <!====================================================>
            <div class="page-content">

                <! Start Container Fluid>
                    <div class="container-fluid">

                        <!==========Page Title Start==========>
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <h4 class="mb-0">
                                            <?php 
                                                if ($id) {
                                                    echo 'Update GST Bill (%)';
                                                } else {
                                                    echo 'Add GST Bill (%)';
                                                } 
                                            ?>
                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="bill.php">GST Bill (%)</a></li>

                                    <li class="breadcrumb-item active">
                                        <?php 
                                            if ($id) {
                                                echo 'Update GST Bill (%)';
                                            } else {
                                                echo 'Add GST Bill (%)';
                                            } 
                                        ?>
                                    </li>
                                </ol>
                            </div>

                            <hr>

                            <!==========Page Title End==========>

                                <div class="row row-cols">
                                    <div class="col">
                                        <div class="card">


                                            <div class="card-body">
                                                <div>

                                                    <?php if ($id) {

                                                        $query = "SELECT * FROM `bill` WHERE b_id='$id'";
                                                        $query_run = mysqli_query($conn, $query);

                                                        if (mysqli_num_rows($query_run) > 0) {
                                                            while ($row = mysqli_fetch_array($query_run)) {
                                                    ?>



                                                    <form method="POST" action="code.php">
                                                        <div>

                                                            <div class="row">
                                                                <input type="text" class="form-control" id='b_id' hidden
                                                                    name="b_id" value="<?php echo $id ?>" />

                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">Date</label>
                                                                    <input type="text" id="basic-datepicker"
                                                                        name="b_date" class="form-control"
                                                                        value="<?php echo $row['b_date']; ?>">
                                                                </div>
                                                                <div class="col-md-3 col-6 mb-3">
                                                                    <label class="form-label">Bill No.</label>
                                                                    <input type="text" id="bill_no" name="bill_no"
                                                                        class="form-control"
                                                                        value="<?php echo $row['bill_no']; ?>">
                                                                </div>


                                                                <div class="col-md-3 col-6 mb-3">
                                                                    <label class="form-label">Party Id</label>
                                                                    <input type="text" id="party_id" name="party_id"
                                                                        class="form-control"
                                                                        value="<?php echo $row['party_id']; ?>"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">GST</label>
                                                                    <input type="text" id="gst" name="gst"
                                                                        class="form-control"
                                                                        value="<?php echo $row['gst']; ?>"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="simpleinput" class="form-label">Party
                                                                        Name</label>
                                                                    <select class="form-select" id="p_name"
                                                                        name="p_name">
                                                                        <option selected disabled> -- Select Party
                                                                            Name-- </option>

                                                                        <?php
                                                                            $fetch_query = "SELECT * FROM party";
                                                                            $fetch_query_run = mysqli_query($conn, $fetch_query);
                                                                            if (mysqli_num_rows($fetch_query_run) > 0) {
                                                                                while ($row1 = mysqli_fetch_array($fetch_query_run)) {

                                                                            ?>
                                                                        <option value="<?php echo $row1['p_name']; ?>" <?php if ($row1['p_name'] == $row['p_name']) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                                            <?php echo $row1['p_name']; ?>
                                                                        </option>;
                                                                        <?php }
                                                                            }

                                                                            ?>

                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Address</label>
                                                                    <input type="text" id="p_address" name="p_address"
                                                                        class="form-control"
                                                                        value="<?php echo $row['p_address']; ?>"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <hr>


                                                         <div id="BillForm">
                                                             <?php
                                                             $chalan_nos = explode(', ', $row['chalan_no']);
                                                             $c_amounts = explode(', ', $row['c_amount']);
                                                             $saved_designs = isset($row['design_no']) ? explode(', ', $row['design_no']) : [];

                                                             $p_name_current = $row['p_name'];
                                                             $active_owner_id = $_SESSION['active_owner_id'] ?? 1;
                                                             $party_chalans_query = mysqli_query($conn, "SELECT chalan_no, design_no, total_metre, rate, amount, total_amount FROM chalan WHERE p_name = '" . mysqli_real_escape_string($conn, $p_name_current) . "' AND owner_id = $active_owner_id ORDER BY c_id DESC");
                                                             $chalans_list = [];
                                                             while ($ch_row = mysqli_fetch_assoc($party_chalans_query)) {
                                                                 $chalans_list[] = $ch_row;
                                                             }

                                                             for ($i = 0; $i < count($chalan_nos); $i++) {
                                                                 $c_no = $chalan_nos[$i];
                                                                 $c_amt = $c_amounts[$i] ?? '';
                                                                 $c_detail_query = mysqli_query($conn, "SELECT design_no, total_metre, rate, amount FROM chalan WHERE chalan_no = '" . mysqli_real_escape_string($conn, $c_no) . "' AND owner_id = $active_owner_id LIMIT 1");
                                                                 $c_detail = mysqli_fetch_assoc($c_detail_query);
                                                                 
                                                                 $ch_designs = array_map('trim', explode('/', $c_detail['design_no'] ?? ''));
                                                                 $ch_metres = array_map('trim', explode('/', $c_detail['total_metre'] ?? ''));
                                                                 $ch_rates = array_map('trim', explode('/', $c_detail['rate'] ?? ''));
                                                                 $ch_amounts = array_map('trim', explode('/', $c_detail['amount'] ?? ''));

                                                                 $saved_design = $saved_designs[$i] ?? ($ch_designs[0] ?? '');
                                                                 $selected_index = array_search($saved_design, $ch_designs);
                                                                 if ($selected_index === false) {
                                                                     $selected_index = 0;
                                                                 }
                                                                 $c_design = $ch_designs[$selected_index] ?? '';
                                                                 $c_metre = $ch_metres[$selected_index] ?? '';
                                                                 $c_rate = $ch_rates[$selected_index] ?? '';
                                                             ?>
                                                             <div class="row chalan-row mb-3 align-items-end">
                                                                 <div class="col-md-3 col-6 col-remove">
                                                                     <label class="form-label">Chalan No.</label>
                                                                     <select name="chalan_no[]" class="form-select chalan-select" required>
                                                                         <option value="">-- Select Chalan No --</option>
                                                                         <?php
                                                                         foreach ($chalans_list as $ch) {
                                                                             $selected_attr = ($c_no == $ch['chalan_no']) ? "selected" : "";
                                                                             echo '<option value="' . htmlspecialchars($ch['chalan_no']) . '" data-amount="' . htmlspecialchars($ch['total_amount']) . '" data-design="' . htmlspecialchars($ch['design_no'] ?? '') . '" data-metre="' . htmlspecialchars($ch['total_metre'] ?? '') . '" data-rate="' . htmlspecialchars($ch['rate'] ?? '') . '" data-amounts="' . htmlspecialchars($ch['amount'] ?? '') . '" ' . $selected_attr . '>' . htmlspecialchars($ch['chalan_no']) . '</option>';
                                                                         }
                                                                         ?>
                                                                     </select>
                                                                 </div>
                                                                 <div class="col-md-2 col-6">
                                                                     <label class="form-label">Design No.</label>
                                                                     <select name="design_no[]" class="form-select c_design" required>
                                                                         <option value="">-- Select Design --</option>
                                                                         <?php
                                                                         for ($j = 0; $j < count($ch_designs); $j++) {
                                                                             $d_val = $ch_designs[$j];
                                                                             $m_val = $ch_metres[$j] ?? '';
                                                                             $r_val = $ch_rates[$j] ?? '';
                                                                             $a_val = $ch_amounts[$j] ?? '';
                                                                             $selected_design_attr = ($d_val == $saved_design) ? "selected" : "";
                                                                             echo '<option value="' . htmlspecialchars($d_val) . '" data-metre="' . htmlspecialchars($m_val) . '" data-rate="' . htmlspecialchars($r_val) . '" data-amount="' . htmlspecialchars($a_val) . '" ' . $selected_design_attr . '>' . htmlspecialchars($d_val) . '</option>';
                                                                         }
                                                                         ?>
                                                                     </select>
                                                                 </div>
                                                                 <div class="col-md-2 col-6">
                                                                     <label class="form-label">Total Metre</label>
                                                                     <input type="text" class="form-control c_metre" value="<?php echo htmlspecialchars($c_metre); ?>" readonly>
                                                                 </div>
                                                                 <div class="col-md-2 col-6">
                                                                     <label class="form-label">Rate</label>
                                                                     <input type="text" class="form-control c_rate" value="<?php echo htmlspecialchars($c_rate); ?>" readonly>
                                                                 </div>
                                                                 <div class="col-md-2 col-6">
                                                                     <label class="form-label">Chalan Amount</label>
                                                                     <input type="text" name="c_amount[]" value="<?php echo htmlspecialchars($c_amt); ?>" class="form-control c_amount" readonly>
                                                                 </div>
                                                                 <div class="col-md-1 col-6">
                                                                     <button type="button" class="btn btn-danger btn-sm c_removeBtn">Remove</button>
                                                                 </div>
                                                             </div>
                                                             <?php } ?>
                                                         </div>

                                                         <div class="mb-3">
                                                             <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Add Chalan Row</button>
                                                         </div></div>

                                                        </div>

                                                        <hr>


                                                        <div class="row">

                                                         <div class="row">
                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label"><b>Total Chalan Amount</b></label>
                                                                 <input type="text" id="total_c_amount" name="total_c_amount"
                                                                     value="<?php echo $row['c_total_amount']; ?>"
                                                                     class="form-control total_c_amount" readonly>
                                                             </div>

                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Discount</label>
                                                                 <select class="form-select" id="dis_rate" name="dis_rate">
                                                                     <?php
                                                                     for ($d = 1; $d <= 10; $d++) {
                                                                         $sel = ($row['d_rate'] == $d) ? 'selected' : '';
                                                                         echo "<option value='{$d}' {$sel}>{$d}%</option>";
                                                                     }
                                                                     ?>
                                                                 </select>
                                                             </div>

                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Discount Amount</label>
                                                                 <input type="text" id="dis_amount" name="dis_amount"
                                                                     class="form-control dis_amount"
                                                                     value="<?php echo $row['d_amount']; ?>" readonly>
                                                             </div>
                                                         </div>

                                                         <div class="row">
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">CGST Rate (%)</label>
                                                                 <input type="number" step="0.01" id="cgst_rate" name="cgst_rate"
                                                                     class="form-control cgst_rate"
                                                                     value="<?php echo htmlspecialchars($row['cgst_rate'] ?? '2.50'); ?>">
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">CGST Amount</label>
                                                                 <input type="text" id="cgst" name="cgst"
                                                                     class="form-control cgst"
                                                                     value="<?php echo $row['cgst']; ?>" readonly>
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">SGST Rate (%)</label>
                                                                 <input type="number" step="0.01" id="sgst_rate" name="sgst_rate"
                                                                     class="form-control sgst_rate"
                                                                     value="<?php echo htmlspecialchars($row['sgst_rate'] ?? '2.50'); ?>">
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">SGST Amount</label>
                                                                 <input type="text" id="sgst" name="sgst"
                                                                     class="form-control sgst"
                                                                     value="<?php echo $row['sgst']; ?>" readonly>
                                                             </div>
                                                         </div>

                                                         <div class="row">
                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Total GST</label>
                                                                 <input type="text" id="totalgst" name="totalgst"
                                                                     class="form-control totalgst"
                                                                     value="<?php echo $row['total_gst']; ?>" readonly>
                                                             </div>
                                                         </div>


                                                        <hr>


                                                        <div class="row">

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Final Amount</label>
                                                                <input type="text" id="final_amount" name="final_amount"
                                                                    class="form-control final_amount"
                                                                    value="<?php echo $row['total_amount']; ?>"
                                                                    readonly>
                                                            </div>

                                                            <div class="col-md-4 col-6 mb-3">
                                                                <label class="form-label">Paid Amount</label>
                                                                <input type="text" id="paid_amount" name="paid_amount"
                                                                    class="form-control"
                                                                    value="<?php echo $row['paid_amount']; ?>"
                                                                    placeholder="Please enter paid amount">
                                                            </div>

                                                            <div class="col-md-4 col-6 mb-3">
                                                                <label class="form-label">Pending Amount</label>
                                                                <input type="text" id="pending_amount"
                                                                    name="pending_amount" class="form-control"
                                                                    value="<?php echo $row['pending_amount']; ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <button class="btn btn-primary cs-mr10" name="b_update" type="submit">Update</button>
                                                        </div>
                                                    </form>



                                                    <?PHP }
                                                        }
                                                        } else { 
                                                    ?>
                                                </div>

                                                <?php
                                                        // card_no & order_no Auto increase start;

                                                        $query = "SELECT * FROM `bill` ORDER BY b_id DESC LIMIT 1";
                                                        $query_run = mysqli_query($conn, $query);

                                                        if (mysqli_num_rows($query_run) > 0) {
                                                            while ($row = mysqli_fetch_array($query_run)) {
                                                                $bill_no = $row['bill_no'] + 1;
                                                            }
                                                        }

                                                        // card_no & order_no Auto increase end;


                                                    ?>
                                                <div>
                                                    <form method="POST" action="code.php">
                                                        <div>

                                                            <div class="row">
                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">Date</label>
                                                                    <input type="text" id="basic-datepicker"
                                                                        name="b_date" class="form-control"
                                                                        value="<?php echo $today; ?>">
                                                                </div>
                                                                <div class="col-md-3 col-6 mb-3">
                                                                    <label class="form-label">Bill No.</label>
                                                                    <input type="text" id="bill_no" name="bill_no"
                                                                        class="form-control"
                                                                        value="<?php echo $bill_no; ?>">
                                                                </div>


                                                                <div class="col-md-3 col-6 mb-3">
                                                                    <label class="form-label">Party Id</label>
                                                                    <input type="text" id="party_id" name="party_id"
                                                                        class="form-control"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">GST</label>
                                                                    <input type="text" id="gst" name="gst"
                                                                        class="form-control"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="simpleinput" class="form-label">Party
                                                                        Name</label>
                                                                    <select class="form-select" id="p_name"
                                                                        name="p_name">
                                                                        <option selected disabled> -- Select Party
                                                                            Name-- </option>

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
                                                                    <input type="text" id="p_address" name="p_address"
                                                                        class="form-control"
                                                                        placeholder="Please select party name" readonly>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <hr>

                                                        <!-- <div id="BillForm"> -->

                                                        <!-- <div class="row">

                                                                <div class="col-12 mb-3">

                                                                    <div type="button" id="chalan_no"
                                                                        class="btn btn-secondary w-100 text-center"
                                                                        placeholder="Click here chalan no select"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#chalanNo">
                                                                        Click here Chalan no select
                                                                    </div>

                                                                </div> -->


                                                        <div id="BillForm">
                                                            <div class="row chalan-row mb-3 align-items-end">
                                                                <div class="col-md-3 col-6 col-remove">
                                                                    <label class="form-label">Chalan No.</label>
                                                                    <select name="chalan_no[]" class="form-select chalan-select" required>
                                                                        <option value="">-- Select Chalan No --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-6">
                                                                    <label class="form-label">Design No.</label>
                                                                    <select name="design_no[]" class="form-select c_design" required>
                                                                        <option value="">-- Select Design --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-6">
                                                                    <label class="form-label">Total Metre</label>
                                                                    <input type="text" class="form-control c_metre" readonly>
                                                                </div>
                                                                <div class="col-md-2 col-6">
                                                                    <label class="form-label">Rate</label>
                                                                    <input type="text" class="form-control c_rate" readonly>
                                                                </div>
                                                                <div class="col-md-2 col-6">
                                                                    <label class="form-label">Chalan Amount</label>
                                                                    <input type="text" name="c_amount[]" class="form-control c_amount" readonly>
                                                                </div>
                                                                <div class="col-md-1 col-6">
                                                                    <button type="button" class="btn btn-danger btn-sm c_removeBtn">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="mb-3">
                                                             <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Add Chalan Row</button>
                                                         </div>

                                                         <hr>

                                                         <div class="row">
                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label"><b>Total Chalan Amount</b></label>
                                                                 <input type="text" id="total_c_amount" name="total_c_amount"
                                                                     class="form-control total_c_amount" value="0" readonly>
                                                             </div>

                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Discount</label>
                                                                 <select class="form-select" id="dis_rate" name="dis_rate">
                                                                     <?php
                                                                     for ($d = 1; $d <= 10; $d++) {
                                                                         $sel = ($d == 5) ? 'selected' : '';
                                                                         echo "<option value='{$d}' {$sel}>{$d}%</option>";
                                                                     }
                                                                     ?>
                                                                 </select>
                                                             </div>

                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Discount Amount</label>
                                                                 <input type="text" id="dis_amount" name="dis_amount"
                                                                     class="form-control dis_amount" readonly>
                                                             </div>
                                                         </div>

                                                         <div class="row">
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">CGST Rate (%)</label>
                                                                 <input type="number" step="0.01" id="cgst_rate" name="cgst_rate"
                                                                     class="form-control cgst_rate"
                                                                     value="2.50">
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">CGST Amount</label>
                                                                 <input type="text" id="cgst" name="cgst"
                                                                     class="form-control cgst" readonly>
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">SGST Rate (%)</label>
                                                                 <input type="number" step="0.01" id="sgst_rate" name="sgst_rate"
                                                                     class="form-control sgst_rate"
                                                                     value="2.50">
                                                             </div>
                                                             <div class="col-md-3 col-6 mb-3">
                                                                 <label class="form-label">SGST Amount</label>
                                                                 <input type="text" id="sgst" name="sgst"
                                                                     class="form-control sgst" readonly>
                                                             </div>
                                                         </div>

                                                         <div class="row">
                                                             <div class="col-md-4 col-6 mb-3">
                                                                 <label class="form-label">Total GST</label>
                                                                 <input type="text" id="totalgst" name="totalgst"
                                                                     class="form-control totalgst" readonly>
                                                             </div></div>

                                                        </div>


                                                        <hr>


                                                        <div class="row">

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Final Amount</label>
                                                                <input type="text" id="final_amount" name="final_amount"
                                                                    class="form-control final_amount" value="0"
                                                                    readonly>
                                                            </div>

                                                            <div class="col-md-4 col-6 mb-3">
                                                                <label class="form-label">Paid Amount</label>
                                                                <input type="text" id="paid_amount" name="paid_amount"
                                                                    class="form-control"
                                                                    placeholder="Please enter paid amount">
                                                            </div>

                                                            <div class="col-md-4 col-6 mb-3">
                                                                <label class="form-label">Pending Amount</label>
                                                                <input type="text" id="pending_amount"
                                                                    name="pending_amount" class="form-control" value="0"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-12 cs-mb-10">
                                                            <button class="btn btn-primary cs-mr10 " name="b_submit"
                                                                type="submit">Submit</button>
                                                        </div>
                                                    </form>

                                                    <?PHP } ?>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <! End Container Fluid>


                                    <!-- Modal -->
                                    <!-- <div class="modal fade center" id="chalanNo" aria-hidden="true"
                            aria-labelledby="chalanNoToggleLabel" tabindex="-1">
                            <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chalan No</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>


                                    <div class="modal-body" id="selectedChalanTable">
                                        <div id="Chalan_no">Please select party name</div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="applyInvoice">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->



                                    <script>
                                    // $("#applyInvoice").click(function() {

                                    //     $("#selectedInvoices").html("");

                                    //     $(".invoice-checkbox:checked").each(function() {

                                    //         let invoice = $(this).val();

                                    //         $("#selectedInvoices").append(`
                                    //                         <div class="mb-2">
                                    //                             <input type="text" name="chalan_no[]" class="form-control" value="${chalan}" readonly>
                                    //                         </div>
                                    //                     `);
                                    //     });

                                    //     $("#invoiceModal").modal("hide");
                                    // });
                                    </script>



                                    <?php include "footer.php" ?>