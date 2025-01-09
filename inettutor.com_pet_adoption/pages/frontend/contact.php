<?php
// Include database connection
include_once('../includes/dbcon.php');

$sql_company_info = "SELECT company_name, company_address, company_contact FROM tbl_company";
$result_company_info = $conn->query($sql_company_info);

if ($result_company_info === false) {
  // Handle query error
  echo "Error: " . $conn->error;
} elseif ($result_company_info->num_rows > 0) {
  $row_company_info = $result_company_info->fetch_assoc();
  $company_name = $row_company_info['company_name'];
  $company_address = $row_company_info['company_address'];
  $company_phone = $row_company_info['company_contact'];
} else {
  // Set default values if no company information found
  $company_name = "Company Name";
  $company_address = "123 Company Address, City, Country";
  $company_phone = "+1 234 56789012";
}


// Close database connection
//$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../includes/header.php'; ?>

<body class="hold-transition layout-top-nav">
<div class="wrapper">

<?php include 'navbar.php'; ?>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Contact Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <!-- Default box -->
        <div class="card">
          <div class="card-body row">
            <div class="col-5 text-center d-flex align-items-center justify-content-center">
              <div class="">
                <h2><?php echo $company_name; ?></h2>
                <p class="lead mb-5">
                  <?php echo $company_address; ?><br>
                  Phone: <?php echo $company_phone; ?>
                </p>
              </div>
            </div>
            <div class="col-7">
              <form action="process_contact_form.php" method="post">
                <div class="form-group">
                  <label for="inputName">Name</label>
                  <input type="text" id="inputName" name="name" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="inputEmail">E-Mail</label>
                  <input type="email" id="inputEmail" name="email" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="inputSubject">Subject</label>
                  <input type="text" id="inputSubject" name="subject" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="inputMessage">Message</label>
                  <textarea id="inputMessage" name="message" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Send message">
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include '../includes/dashboard_footer.php'; ?>
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php'; ?>

</body>
</html>


