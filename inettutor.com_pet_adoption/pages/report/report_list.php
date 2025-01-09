<?php
// Include the authentication check file
include_once('../includes/auth_check.php');
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
            <h1 class="m-0">Reports</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Pet Adoption Status Report</h3>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <p class="card-text">
                A detailed report on the adoption status of all pets. It could include fields like pet name, type, age, health status, vaccination status, and whether the pet is available for adoption, adopted, or pending adoption.
                </p>
                <a href="https://youtu.be/06LNqBHimks" class="btn btn-primary">View Report</a>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Vaccination Status Report</h3>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <p class="card-text">
                A report that shows the vaccination status of all pets, helping track which pets are up-to-date or overdue for vaccination. Fields could include pet name, type, age, health status, and last vaccination date.
                </p>
                <a href="https://youtu.be/06LNqBHimks" class="btn btn-primary">View Report</a>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Health Status Report</h3>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <p class="card-text">
                This report would summarize the health status of all pets, highlighting pets with any health issues. It could include pet name, type, age, health history, and health status (e.g., healthy, requires treatment, or under observation).
                </p>
                <a href="https://youtu.be/06LNqBHimks" class="btn btn-primary">View Report</a>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Pet Owner Activity Report</h3>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <p class="card-text">
                A report detailing the activities of each pet owner, including the pets they own, the adoption date, pet health and vaccination records, and any updates they have made to pet details over time.
                </p>
                <a href="https://youtu.be/06LNqBHimks" class="btn btn-primary">View Report</a>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Pet Type Distribution Report</h3>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <p class="card-text">
                •	A report that provides statistics on the types of pets in the system (e.g., dogs, cats, etc.), their respective counts, and other relevant information like their age, gender, and adoption status. This can help the management identify trends or imbalances in the types of pets available for adoption.
                </p>
                <a href="https://youtu.be/06LNqBHimks" class="btn btn-primary">View Report</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
