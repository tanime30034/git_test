<?php
// Include the authentication check file
include_once('../includes/auth_check.php');

// Include database connection
include_once('../includes/dbcon.php');

// Query to get the total number of pets
$sql_total_pets = "SELECT COUNT(*) AS num_pets FROM tbl_pet";
$result_total_pets = $conn->query($sql_total_pets);
$row_total_pets = $result_total_pets->fetch_assoc();
$num_pets = $row_total_pets['num_pets'];

// Query to get the number of adopted pets
$sql_adopted_pets = "SELECT COUNT(*) AS num_adopted FROM tbl_pet WHERE adoption_status = 'Adopted'";
$result_adopted_pets = $conn->query($sql_adopted_pets);
$row_adopted_pets = $result_adopted_pets->fetch_assoc();
$num_adopted = $row_adopted_pets['num_adopted'];

// Query to get the number of available pets
$sql_available_pets = "SELECT COUNT(*) AS num_available FROM tbl_pet WHERE adoption_status = 'Available'";
$result_available_pets = $conn->query($sql_available_pets);
$row_available_pets = $result_available_pets->fetch_assoc();
$num_available = $row_available_pets['num_available'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include '../includes/header.php' ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../includes/navbar.php' ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include '../includes/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $num_pets; ?></h3>
                <p>Number of Pets</p>
              </div>
              <div class="icon">
                <i class="ion ion-paw"></i>
              </div>
              <a href="../pet/pet_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $num_adopted; ?></h3>
                <p>Number of Adopted Pets</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark-circled"></i>
              </div>
              <a href="../pet/pet_list.php?status=adopted" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $num_available; ?></h3>
                <p>Number of Available Pets</p>
              </div>
              <div class="icon">
                <i class="ion ion-leaf"></i>
              </div>
              <a href="../pet/pet_list.php?status=available" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php' ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php' ?>

</body>
</html>
