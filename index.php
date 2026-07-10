<?php include "header.php";
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;

// Fetch stats
$tot_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE owner_id = $active_owner_id"))['total'] ?? 0;
$comp_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE owner_id = $active_owner_id AND status = 'Complete'"))['total'] ?? 0;
$pend_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE owner_id = $active_owner_id AND status = 'Pending'"))['total'] ?? 0;
$canc_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE owner_id = $active_owner_id AND status = 'Cancel'"))['total'] ?? 0;
?>

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
                            <h4 class="mb-0">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- ========== Page Title End ========== -->


                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Total Orders</p>
                                        <h3 class="text-dark mt-2 mb-0"><?php echo $tot_orders; ?></h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="mingcute:box-line"
                                                class="fs-32 avatar-title text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Complete Orders</p>
                                        <h3 class="text-dark mt-2 mb-0"><?php echo $comp_orders; ?></h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-success rounded">
                                            <iconify-icon icon="mingcute:box-line"
                                                class="fs-32 avatar-title text-success"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Pending Orders</p>
                                        <h3 class="text-dark mt-2 mb-0"><?php echo $pend_orders; ?></h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-warning rounded">
                                            <iconify-icon icon="mingcute:box-line"
                                                class="fs-32 avatar-title text-warning"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Cancel Orders</p>
                                        <h3 class="text-dark mt-2 mb-0"><?php echo $canc_orders; ?></h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-danger rounded">
                                            <iconify-icon icon="mingcute:box-line"
                                                class="fs-32 avatar-title text-danger"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Pending Amount</h4>
                                <a href="party.php" class="btn btn-sm btn-light">
                                    View All
                                </a>
                            </div>
                            <!-- end card-header-->

                            <div class="card-body pb-1">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 table-centered">
                                        <thead>
                                            <th class="py-1">Party ID</th>
                                            <th class="py-1">Name</th>
                                            <th class="py-1">Mobile Number</th>
                                            <th class="py-1">Address</th>
                                            <th class="py-1">Pending Amount</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pending_q = mysqli_query($conn, "SELECT party_id, p_name, mobile_no, p_address, pending_amount FROM party WHERE owner_id = $active_owner_id AND pending_amount > 0 ORDER BY pending_amount DESC LIMIT 8");
                                            if ($pending_q && mysqli_num_rows($pending_q) > 0) {
                                                while ($p_row = mysqli_fetch_assoc($pending_q)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($p_row['party_id']); ?></td>
                                                <td><?php echo htmlspecialchars($p_row['p_name']); ?></td>
                                                <td><?php echo htmlspecialchars($p_row['mobile_no']); ?></td>
                                                <td><?php echo htmlspecialchars($p_row['p_address']); ?></td>
                                                <td><span class="text-danger fw-bold">₹<?php echo number_format($p_row['pending_amount'], 2); ?></span></td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center text-muted">No pending amounts.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">
                                    Recent Pending Orders
                                </h4>

                                <a href="order.php" class="btn btn-sm btn-light">
                                    View All
                                </a>
                            </div>
                            <!-- end card-header-->

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 table-centered">
                                        <thead>
                                            <th class="py-1">ID</th>
                                            <th class="py-1">Date</th>
                                            <th class="py-1">Party Name</th>
                                            <th class="py-1">Amount</th>
                                            <th class="py-1">Status</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $orders_q = mysqli_query($conn, "SELECT i_id, date, p_name, amount, status FROM orders WHERE owner_id = $active_owner_id AND status = 'Pending' ORDER BY i_id DESC LIMIT 8");
                                            if ($orders_q && mysqli_num_rows($orders_q) > 0) {
                                                while ($o_row = mysqli_fetch_assoc($orders_q)) {
                                                    $o_date = new DateTime($o_row['date']);
                                                    $formatted_date = $o_date->format('d M, Y');
                                            ?>
                                            <tr>
                                                <td>#<?php echo htmlspecialchars($o_row['i_id']); ?></td>
                                                <td><?php echo htmlspecialchars($formatted_date); ?></td>
                                                <td><?php echo htmlspecialchars($o_row['p_name']); ?></td>
                                                <td>₹<?php echo number_format($o_row['amount'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-warning">Pending</span>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center text-muted">No pending orders.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
            <!-- End Container Fluid -->


<?php include "footer.php" ?>
