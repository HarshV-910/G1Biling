<?php
$id = $_GET['o_id'] ?? null;
?>

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
                    <h4 class="mb-0"><?php if($id){ echo 'Update Owner'; }else{ echo 'Add Owner'; } ?></h4>

                </div>
            </div>
        </div>
        <div>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="owner.php">Owner</a></li>

                <li class="breadcrumb-item active">
                    <?php if($id){ echo 'Update Owner'; }else{ echo 'Add Owner'; } ?>
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

                            <?php if($id){ 
                                
                                $query = "SELECT * FROM `owner` WHERE owner_id='$id'";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row1 = mysqli_fetch_array($query_run)) {
                                ?>

                            <form method="POST" action="code.php">
                                <div>
                                    <input type="hidden" class="form-control" id='category_id' name="owner_id"
                                        value=<?php echo $id ?> />
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" autofocus
                                            value="<?php echo $row1['name']?>" placeholder="Please enter your name">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number 1</label>
                                            <input type="text" name="mobile_1" id="mobile_1" class="form-control"
                                                value="<?php echo $row1['mobile_1']?>"
                                                placeholder="Please enter mobile number 1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number 2</label>
                                            <input type="text" name="mobile_2" id="mobile_2" class="form-control"
                                                value="<?php echo $row1['mobile_2']?>"
                                                placeholder="Please enter mobile number 2">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-textarea" class="form-label">Address</label>
                                        <textarea class="form-control" rows="3" id="address" name="address"
                                            placeholder="Please enter address"> <?php echo $row1['address']?> </textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <p class="form-label">User name</p>
                                            <input type="text" id="user_name" name="user_name" class="form-control"
                                                value="<?php echo $row1['user_name']?>"
                                                placeholder="Please enter user name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <p class="form-label">Password</p>
                                            <input type="text" id="password" name="password" class="form-control"
                                                value="<?php echo $row1['password']?>"
                                                placeholder="Please enter password">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" id="submit" type="submit"
                                        name="o_update">Update</button>
                                </div>

                            </form>

                            <?PHP }}} else { ?>

                            <form method="POST" action="code.php">
                                <div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" autofocus
                                                placeholder="Please enter your name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number 1</label>
                                            <input type="text" name="mobile_1" id="mobile_1" class="form-control"
                                                placeholder="Please enter mobile number 1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number 2</label>
                                            <input type="text" name="mobile_2" id="mobile_2" class="form-control"
                                                placeholder="Please enter mobile number 2">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Upload Logo</label>
                                            <input type="file" name="image" required class="form-control" placeholder="Please upload logo">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-textarea" class="form-label">Address</label>
                                        <textarea class="form-control" rows="3" id="address" name="address"
                                            placeholder="Please enter address"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <p class="form-label">User name</p>
                                            <input type="text" id="user_name" name="user_name" class="form-control"
                                                placeholder="Please enter user name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <p class="form-label">Password</p>
                                            <input type="password" id="password" name="pass" class="form-control"
                                                placeholder="Please enter password">
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- ========== image upload Page Start ========== -->

                                    <!-- <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Upload Logo</h5>
                                                </div>

                                                <div class="card-body">

                                                    <div class="mb-3">

                                                        <div class="dropzone">
                                                            <div class="fallback">
                                                                <input type="file" name="image" accept="assets/img/*" required>
                                                            </div>
                                                            <div class="dz-message needsclick">
                                                                <i class="h1 bx bx-cloud-upload"></i>
                                                                <h3>Drop files here or click to upload.</h3>
                                                                <span class="text-muted fs-13">
                                                                    (This is just a demo dropzone. Selected files are
                                                                    <strong>not</strong> actually uploaded.)
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                                                            <li class="mt-2" id="dropzone-preview-list">
                                                                <div class="border rounded">
                                                                    <div class="d-flex align-items-center p-2">
                                                                        <div class="flex-shrink-0 me-3">
                                                                            <div class="avatar-sm bg-light rounded">
                                                                                <img data-dz-thumbnail
                                                                                    class="img-fluid rounded d-block"
                                                                                    src="#" alt="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <div class="pt-1">
                                                                                <h5 class="fs-14 mb-1" data-dz-name>
                                                                                    &nbsp;
                                                                                </h5>
                                                                                <p class="fs-13 text-muted mb-0"
                                                                                    data-dz-size></p>
                                                                                <strong class="error text-danger"
                                                                                    data-dz-errormessage></strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-shrink-0 ms-3">
                                                                            <button data-dz-remove
                                                                                class="btn btn-sm btn-danger">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </div> 
                                    </div>  -->

                                    <!-- ========== image upload Page End ========== -->

                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" id="submit" type="submit"
                                        name="o_submit">Submit</button>
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