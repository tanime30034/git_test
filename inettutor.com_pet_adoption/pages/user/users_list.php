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
            <h1>Project Member</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
      <?php include 'add_modal.php'; ?>
      <?php include '../includes/success_message.php'; ?>
      <?php include '../includes/error_message.php'; ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class='hidden-column'>User ID</th>
                    <th>Profile Image</th>
                    <th>Complete Name</th>
                    <th>Designation</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      include_once('../includes/dbcon.php');
                      $sql = "SELECT * FROM tbl_user";

                      //use for MySQLi-OOP
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc())
                      {
                        echo 
                        "<tr>
                          <td class='hidden-column'>".$row['user_id']."</td>
                          <td class='text-center'>
                            <a href='#' data-toggle='modal' data-target='#edit_image_".$row['user_id']."'>
                              <img src='user_upload/".$row['profile_image']."' class='img-thumbnail' style='width:100px;' alt='Profile Image'>
                            </a>
                          </td>
                          <td>".$row['complete_name']."</td>
                          <td>".$row['designation']."</td>
                          <td>
                            <a href='#edit_".$row['user_id']."' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Edit</a>
                            <a href='#delete_".$row['user_id']."' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
                            <a href='#change_credentials_" . $row['user_id'] . "' class='btn btn-info btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-lock'></span> Login Credentials</a>
                          </td>
                        </tr>";
                        include('edit_delete_modal.php');
                        include('update_image_modal.php');
                        include('change_credentials_modal.php');
                      }
                    ?>
                  </tbody>
                </table>
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
