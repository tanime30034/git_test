<?php
// Include the authentication check file
include_once('../includes/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../includes/header.php'; ?>
<style>
  .hidden-column {
    display: none;
  }
</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include '../includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Log</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Activity</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        include_once('../includes/dbcon.php');
                        $sql = "SELECT al.date_time, u.complete_name, al.details 
                                FROM tbl_activity_log al 
                                INNER JOIN tbl_user u ON al.user_id = u.user_id
                                ORDER BY al.date_time DESC";

                        // Use for MySQLi-OOP
                        $query = $conn->query($sql);
                        if ($query) {
                          while($row = $query->fetch_assoc())
                          {
                            echo 
                            "<tr>
                              <td>".$row['date_time']."</td>
                              <td>".$row['complete_name']."</td>
                              <td>".$row['details']."</td>
                            </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='3'>No activity logs found.</td></tr>";
                        }
                        // Close the database connection
                        $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php'; ?>
</body>
</html>
