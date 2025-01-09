<?php
// Include the authentication check file
include_once('../includes/auth_check.php');

// Database connection and other necessary functions or configurations

// Handling form submission to update company information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload for logo
    $targetDir = "uploads/";
    $fileName = basename($_FILES["company_logo"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validate and process uploaded logo file
    // Update company information in the database
    // Redirect or show appropriate messages after processing
}
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
            <h1 class="m-0">Project Information</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Form to update company information -->
        <!-- Main content -->
<section class="content">
    <?php 
        // Include necessary files
        include 'edit-company-info-modal.php';  
       // include 'function.php'; 
        
        // Require database configuration
        require_once '../includes/dbcon.php';
        
        // Establish database connection
        $cn = new mysqli($servername, $username, $password, $database);
        
        // Query to fetch company information
        $sql = "SELECT company_id, company_logo, company_name, company_address, company_contact, company_website FROM tbl_company";
        $qry = $cn->prepare($sql);
        $qry->execute();
        $qry->bind_result($company_id, $company_logo, $company_name, $company_address, $company_contact, $company_website);
        $qry->store_result();
        $qry->fetch();
    ?>

    <!-- Display company information -->
    <div class="card col-md-12 mx-auto" id='x'>
        <div class="card-header">
            <!-- Buttons to edit company info and logo -->
            <button class='btn btn-flat btn-primary ' onclick="populateEditModal(<?php echo $company_id; ?>, '<?php echo $company_name; ?>', '<?php echo $company_address; ?>', '<?php echo $company_contact; ?>', '<?php echo $company_website; ?>')" data-toggle='modal' data-target='#edit-company_info'>Edit Project Info</button> 
        </div>
        <div class="card-body">
            <!-- Display company logo -->
            <div class="image text-center">
                <img src="logo/<?php echo $company_logo;?>" class="img-circle elevation-1" alt="company logo" style="height:200px;">
            </div>
            <!-- Display company information in a table -->
            <table id="" class="table table-bordered">
                <tbody>
                    <!-- Display company name -->
                    <tr>
                        <td style='width: 200px'><strong>Project Name:</strong></td>
                        <td><?php echo $company_name; ?></td>
                    </tr>
                    <br>
                    <!-- Display company address -->
                    <tr>
                        <td><strong>Study Site:</strong></td>
                        <td><?php echo $company_address; ?></td>
                    </tr>
                    <!-- Display company contact-->
                    <tr>
                        <td><strong>Contact:</strong></td>
                        <td><?php echo $company_contact; ?></td>
                    </tr>
                    <!-- Display company website-->
                    <tr>
                        <td><strong>Website:</strong></td>
                        <td><a href="<?php echo $company_website; ?>" target="_blank"><?php echo $company_website; ?></a></td>
                    </tr>

                    <!-- Include modal forms for editing company info and logo -->
                    <?php
                       // include 'edit-modal.php';
                       // include 'edit-modal-logo.php';
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</section>
<!-- /.content -->

        <!-- End Form -->
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
