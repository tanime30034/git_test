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
            <h1>Pet List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
      <?php include '../includes/success_message.php'; ?>
      <?php include '../includes/error_message.php'; ?>
      <?php include 'add_modal.php'; ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th class='hidden-column'>Pet ID</th>
                        <th>Profile Image</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                        <th>Description</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Health Status</th>
                        <th>Vaccination Status</th>
                        <th>Adoption Status</th>
                        <th>Date Registered</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once('../includes/dbcon.php');
                        
                        // Define the SQL query with JOIN for tbl_pet_owner
                        $sql = "SELECT p.pet_id, p.pet_name, pt.pet_type_name, p.description, p.age, p.gender, 
                                      p.health_status, p.vaccination_status, p.adoption_status, p.pet_profile_image, 
                                      p.date_registered, pt.pet_type_id, po.pet_owner_id, po.pet_owner_name,upload_health_history, proof_of_vaccination
                                FROM tbl_pet p 
                                JOIN tbl_pet_type pt ON p.pet_type_id = pt.pet_type_id
                                JOIN tbl_pet_owner po ON p.pet_owner_id = po.pet_owner_id";  // Join with pet_owner table
                        
                        // Execute the query
                        $query = $conn->query($sql);
                        
                        // Check for errors in query execution
                        if (!$query) {
                            echo "Error executing query: " . $conn->error;
                        } else {
                            // Process result set
                            while($row = $query->fetch_assoc()) {
                                echo "<tr>
                                        <td>
                                          <a href='#edit_" . $row['pet_id'] . "' class='btn btn-success btn-sm' data-toggle='modal'>Edit</a>
                                          <a href='#delete_" . $row['pet_id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'>Delete</a>
                                        </td>
                                        <td class='hidden-column'>" . $row['pet_id'] . "</td>
                                        <td class='text-center'>
                                            <img src='pet_profile_upload/" . $row['pet_profile_image'] . "' class='img-thumbnail' style='width:100px;' alt='Profile Image'><br>
                                            <button class='btn btn-flat btn-warning btn-xs' data-toggle='modal' data-target='#edit_image_" . $row['pet_id'] . "'><i class='nav-icon fas fa-pen'></i> Edit Image</button>
                                        </td>
                                        <td>" . $row['pet_name'] . "</td>
                                        <td>" . $row['pet_type_name'] . "</td>
                                        <td>" . $row['description'] . "</td>
                                        <td>" . $row['age'] . "</td>
                                        <td>" . $row['gender'] . "</td>
                                        <td>" . $row['health_status'] . "</td>
                                        <td>" . $row['vaccination_status'] . "</td>
                                        <td>" . $row['adoption_status'] . "</td>
                                        <td>" . $row['date_registered'] . "</td>
                                      </tr>";
                                // Include modal files
                                include('edit_delete_modal.php');
                                include('update_image_modal.php');
                            }
                        }
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
 
  </div>
  <!-- /.content-wrapper -->

   <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php'; ?>
</body>
</html>
