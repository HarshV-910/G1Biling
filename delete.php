<?php include "header.php"?>

<?php

$o_id = $_GET['o_id'] ?? null;
$p_id = $_GET['p_id'] ?? null;
$i_id = $_GET['i_id'] ?? null;
$c_id = $_GET['c_id'] ?? null;
$b_id = $_GET['b_id'] ?? null;

// echo 'Owner Id : '.$id
?>

<div class="page-content">
<!-- ✅ Delete Modal -->

<?php 
if($o_id){?>
<div class="align-middle">
    <form action="code.php" method="POST">
        <div class="body">
             <input type="hidden" class="form-control" id='owner_id' name="owner_id" value=<?php echo $o_id ?> />
            <h1 class="text-center">Are you sure, </h1>
            <h3 class="text-center">You want to delete this data...?</h3>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-secondary px-5 m-2" data-bs-dismiss="modal">
            <a href="settings.php">No</a>
          </button>
          <button type="submit" class="btn btn-danger px-5 m-2" name="o_delete">Yes</button>
        </div>

    </form>

</div>

<?php 
} 

if($p_id)
  {
    
  ?>
  <div class="align-middle">
    <form action="code.php" method="POST">
        <div class="body">
             <input type="hidden" class="form-control" id='p_id' name="p_id" value=<?php echo $p_id ?> />
            <h1 class="text-center">Are you sure, </h1>
            <h3 class="text-center">You want to delete this data...?</h3>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-secondary px-5 m-2" data-bs-dismiss="modal">
            <a href="party.php">No</a>
          </button>
          <button type="submit" class="btn btn-danger px-5 m-2" name="p_delete">Yes</button>
        </div>

    </form>

</div>

<?php
}


if($i_id)
  {
    
  ?>
  <div class="align-middle">
    <form action="code.php" method="POST">
        <div class="body">
             <input type="hidden" class="form-control" id='i_id' name="i_id" value=<?php echo $i_id ?> />
            <h1 class="text-center">Are you sure, </h1>
            <h3 class="text-center">You want to delete this data...?</h3>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-secondary px-5 m-2" data-bs-dismiss="modal">
            <a href="order.php">No</a>
          </button>
          <button type="submit" class="btn btn-danger px-5 m-2" name="i_delete">Yes</button>
        </div>

    </form>

</div>

<?php
}




if($c_id)
  {
  ?>
  <div class="align-middle">
    <form action="code.php" method="POST">
        <div class="body">
             <input type="hidden" class="form-control" id='c_id' name="c_id" value=<?php echo $c_id ?> />
            <h1 class="text-center">Are you sure, </h1>
            <h3 class="text-center">You want to delete this data...?</h3>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-secondary px-5 m-2" data-bs-dismiss="modal">
            <a href="chalan.php">No</a>
          </button>
          <button type="submit" class="btn btn-danger px-5 m-2" name="c_delete">Yes</button>
        </div>

    </form>

</div>

<?php
}








if($b_id)
  {
  ?>
  <div class="align-middle">
    <form action="code.php" method="POST">
        <div class="body">
             <input type="hidden" class="form-control" id='b_id' name="b_id" value=<?php echo $b_id ?> />
            <h1 class="text-center">Are you sure, </h1>
            <h3 class="text-center">You want to delete this data...?</h3>
        </div>

        <div class="text-center"> 
          <a href="bill.php">
            <button type="button" class="btn btn-secondary px-5 m-2" data-bs-dismiss="modal"> No </button>
          </a>
          <button type="submit" class="btn btn-danger px-5 m-2" name="b_delete">Yes</button>
        </div>

    </form>

</div>

<?php
}

?>



<?php include "footer.php"?>


