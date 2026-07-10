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

                                    <div class="row">
                                        <?php 

                                         $design_no = $row['design_no'];
                                        // Split full name
                                        $designParts  = explode(" / ", $design_no, 2);
                                        $design_no_1 = $designParts[0];
                                        $design_no_2 = isset($designParts[1]) ? $designParts[1] : "";

                                        $cut = $row['cut'];
                                        // Split full name
                                        $cutParts  = explode(" / ", $cut, 2);
                                        $cut_1 = $cutParts[0];
                                        $cut_2 = isset($cutParts[1]) ? $cutParts[1] : "";



                                        $total_metre = $row['total_metre'];
                                        // Split full name
                                        $metreParts  = explode(" / ", $total_metre, 2);
                                        $total_metre_1 = $metreParts[0];
                                        $total_metre_2 = isset($metreParts[1]) ? $metreParts[1] : "";



                                        $rate = $row['rate'];
                                        // Split full name
                                        $ratetParts  = explode(" / ", $rate, 2);
                                        $rate_1 = $ratetParts[0];
                                        $rate_2 = isset($ratetParts[1]) ? $ratetParts[1] : "";



                                        $amount = $row['amount'];
                                        // Split full name
                                        $amountParts  = explode(" / ", $amount, 2);
                                        $amount_1 = $amountParts[0];
                                        $amount_2 = isset($amountParts[1]) ? $amountParts[1] : "";



                                        ?>

                                         <div class="col-md-6">
                                            <div class="col-12 mb-3">
                                                <label for="simpleinput" class="form-label">Design No - 1</label>
                                                <select class="form-select design_no_1" id="design_no_1"
                                                    name="design_no_1">
                                                    <option value="">-- Select Design No -- </option>

                                                    <?php 
                                                        $clients  = mysqli_query($conn, "SELECT * FROM orders");
                                                            while ($row1 = mysqli_fetch_assoc($clients )) {
                                                    ?>
                                                            <option value="<?php echo $row1['design_no']; ?>" 
                                                                <?php if ($design_no_1 == $row1['design_no']) 
                                                                        {echo "selected";} ?> >
                                                                <?php echo $row1['design_no']; ?>
                                                                        </option>';
                                                                <?php
                                                                    }
                                                                ?>
                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Cut - 1</label>
                                                    <input type="text" id="cut_1" name="cut_1" class="form-control"
                                                        placeholder="Please select design no 1" 
                                                        value="<?php echo htmlspecialchars($cut_1); ?>" readonly>
                                                </div>


                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Total Metre - 1</label>
                                                    <input type="text" id="total_metre_1" name="total_metre_1"
                                                        class="form-control" placeholder="Please select design no 1"
                                                        value="<?php echo htmlspecialchars($total_metre_1); ?>" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Rate - 1</label>
                                                    <input type="text" id="rate_1" name="rate_1" class="form-control"
                                                        placeholder="Please select design no 1" 
                                                        value="<?php echo htmlspecialchars($rate_1); ?>" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Amount - 1</label>
                                                    <input type="text" id="amount_1" name="amount_1"
                                                        class="form-control amount_1"
                                                        placeholder="Please select design no 1" 
                                                        value="<?php echo htmlspecialchars($amount_1); ?>" readonly>
                                                </div>


                                            </div>

                                        </div>


                                        <div class="col-md-6">
                                            <div class="col-12 mb-3">
                                                <label for="simpleinput" class="form-label">Design No - 2</label>
                                                <select class="form-select design_no_2" id="design_no_2"
                                                    name="design_no_2">
                                                    <option value="">-- Select Design No -- </option>
                                                    
                                                    <?php 
                                                        $clients  = mysqli_query($conn, "SELECT * FROM orders");
                                                            while ($row1 = mysqli_fetch_assoc($clients )) {
                                                    ?>
                                                            <option value="<?php echo $row1['design_no']; ?>" 
                                                                <?php if ($design_no_2 == $row1['design_no']) 
                                                                        {echo "selected";} ?> >
                                                                <?php echo $row1['design_no']; ?>
                                                                        </option>';
                                                                <?php
                                                                    }
                                                                ?>

                                                </select>
                                            </div>


                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Cut - 2</label>
                                                    <input type="text" id="cut_2" name="cut_2" class="form-control"
                                                        placeholder="Please select design no 2" 
                                                        value="<?php echo htmlspecialchars($cut_2); ?>" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Total Metre - 2</label>
                                                    <input type="text" id="total_metre_2" name="total_metre_2"
                                                        class="form-control" placeholder="Please select design no 2"
                                                        value="<?php echo htmlspecialchars($total_metre_2); ?>" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Rate - 2</label>
                                                    <input type="text" id="rate_2" name="rate_2" class="form-control"
                                                        placeholder="Please select design no 2" 
                                                        value="<?php echo htmlspecialchars($rate_2); ?>" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Amount - 2</label>
                                                    <input type="text" id="amount_2" name="amount_2"
                                                        class="form-control amount_2"
                                                        placeholder="Please select design no 2" 
                                                        value="<?php echo htmlspecialchars($amount_2); ?>" readonly>
                                                </div>

                                            </div>

                                        </div>

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

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-12 mb-3">
                                                <label for="simpleinput" class="form-label">Design No - 1</label>
                                                <select class="form-select design_no_1" id="design_no_1"
                                                    name="design_no_1">
                                                    <option value="">-- Select Design No -- </option>
                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Cut - 1</label>
                                                    <input type="text" id="cut_1" name="cut_1" class="form-control"
                                                        placeholder="Please select design no 1" readonly>
                                                </div>


                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Total Metre - 1</label>
                                                    <input type="text" id="total_metre_1" name="total_metre_1"
                                                        class="form-control" placeholder="Please select design no 1"
                                                        readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Rate - 1</label>
                                                    <input type="text" id="rate_1" name="rate_1" class="form-control"
                                                        placeholder="Please select design no 1" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Amount - 1</label>
                                                    <input type="text" id="amount_1" name="amount_1"
                                                        class="form-control amount_1"
                                                        placeholder="Please select design no 1" readonly>
                                                </div>


                                            </div>

                                        </div>


                                        <div class="col-md-6">
                                            <div class="col-12 mb-3">
                                                <label for="simpleinput" class="form-label">Design No - 2</label>
                                                <select class="form-select design_no_2" id="design_no_2"
                                                    name="design_no_2">
                                                    <option value="">-- Select Design No -- </option>
                                                </select>
                                            </div>


                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Cut - 2</label>
                                                    <input type="text" id="cut_2" name="cut_2" class="form-control"
                                                        placeholder="Please select design no 2" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Total Metre - 2</label>
                                                    <input type="text" id="total_metre_2" name="total_metre_2"
                                                        class="form-control" placeholder="Please select design no 2"
                                                        readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Rate - 2</label>
                                                    <input type="text" id="rate_2" name="rate_2" class="form-control"
                                                        placeholder="Please select design no 2" readonly>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Amount - 2</label>
                                                    <input type="text" id="amount_2" name="amount_2"
                                                        class="form-control amount_2"
                                                        placeholder="Please select design no 2" readonly>
                                                </div>

                                            </div>

                                        </div>

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




        <script>
        function calculateChalanTotal() {

            let value1 = parseFloat(document.getElementById("amount_1").value) || 0;
            let value2 = parseFloat(document.getElementById("amount_2").value) || 0;

            document.getElementById("total_amount").value = value1 + value2;

        }

        document.getElementById("design_no_1").addEventListener("change", calculateChalanTotal);
        document.getElementById("design_no_2").addEventListener("change", calculateChalanTotal);
        </script>




        <?php include "footer.php" ?>