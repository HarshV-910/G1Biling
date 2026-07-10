<?php include "header.php"?>

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
                                   <h4 class="mb-0">Orders</h4>
                                   <a href="order_form.php">
                                        <button type='button' class='btn btn-sm btn-light'>New Order</button>
                                   </a>
                              </div>
                              <div>
                                   <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Orders</li>
                                   </ol>
                              </div>
                              <hr>
                         </div>
                    </div>
                    <!-- ========== Page Title End ========== -->

                    <div class="card">
                         <div class="card-body">
                              <div>
                                   <div id="table-orderjs"></div>
                              </div>
                         </div>
                    </div>


               </div>
               <!-- End Container Fluid -->

 <?php include "footer.php" ?>

 