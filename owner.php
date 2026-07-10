<?php
$id = $_GET['id'] ?? null;

?>
<?php include "header.php"?>

<?php //include "delete.php" ?>


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
                    <h4 class="mb-0">Owner</h4>
                    <a href="owner_form.php">
                        <button type='button' class='btn btn-sm btn-light'>Add Owner</button>
                    </a>
                </div>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Owner</li>
                    </ol>
                </div>
                <hr>
            </div>
        </div>
        <!-- ========== Page Title End ========== -->

        <div class="card">
            <div class="card-body">
                <div>
                    <div id="table-usersjs"></div>
                </div>
            </div>
        </div>


    </div>
    <!-- End Container Fluid -->









    <?php include "footer.php" ?>