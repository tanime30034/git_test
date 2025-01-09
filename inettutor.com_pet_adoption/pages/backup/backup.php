<?php
// Include the authentication check file
include_once('../includes/auth_check.php');

// Include the database connection file
include_once('../includes/dbcon.php');

// Function to perform database backup
function performBackup($conn, $backupDir) {
    // Validate backup directory
    if (!is_dir($backupDir) || !is_writable($backupDir)) {
        return false;
    }

    // Initialize message variable
    $backupFile = '';

    // Backup filename
    $backupFile = $backupDir . 'database_backup_' . date('Y-m-d_H-i-s') . '.sql';

    // Initialize backup content
    $backupContent = '';

    // Retrieve a list of tables in the database
    $tablesResult = $conn->query('SHOW TABLES');

    // Loop through each table
    while ($row = $tablesResult->fetch_row()) {
        $table = $row[0];
        
        // Retrieve the table structure and data
        $result = $conn->query("SHOW CREATE TABLE `$table`");
        $tableData = $result->fetch_row();
        
        // Append table creation SQL to backup content
        $backupContent .= "\n\n" . $tableData[1] . ";\n\n";
        
        // Retrieve table data
        $result = $conn->query("SELECT * FROM `$table`");
        
        // Loop through table rows
        while ($row = $result->fetch_assoc()) {
            $backupContent .= "INSERT INTO `$table` VALUES (";
            
            // Build values string for each row
            foreach ($row as $value) {
                $backupContent .= "'" . $conn->real_escape_string($value) . "',";
            }
            // Remove trailing comma
            $backupContent = rtrim($backupContent, ',');
            
            $backupContent .= ");\n";
        }
    }

    // Save backup content to a file
    if (file_put_contents($backupFile, $backupContent) !== false) {
        return $backupFile;
    } else {
        return false;
    }
}

// Initialize message variables
$successMessage = '';
$errorMessage = '';

// Check if the backup button is clicked and perform backup
if (isset($_POST['backup'])) {
    // Backup directory
    $backupDir = 'backup/';

    // Perform the backup
    $backupFile = performBackup($conn, $backupDir);

    // Set success or error message
    if ($backupFile) {
        $successMessage = "Backup completed successfully. File saved as: $backupFile";

        // Insert backup record into tbl_backup
        $insertQuery = "INSERT INTO tbl_backup (user_id, backup_file) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $stmt->bind_param("is", $userId, $backupFile);
        $stmt->execute();
        $stmt->close();
    } else {
        $errorMessage = "Backup failed. Please try again.";
    }
}

// Fetch backup records from tbl_backup (if session user_id is set)
$backupRecords = array();
if (isset($_SESSION['user_id'])) {
    $selectQuery = "SELECT b.*, u.complete_name
                    FROM tbl_backup b
                    INNER JOIN tbl_user u ON b.user_id = u.user_id
                    ORDER BY b.backup_date DESC";

    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $backupRecords[] = $row;
        }
    }
}

// Include header and sidebar


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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Backup Page</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <!-- Display success message if set -->
                <?php if ($successMessage): ?>
                    <div class="alert alert-success" role="alert"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <!-- Display error message if set -->
                <?php if ($errorMessage): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <form method="post">
                  <button type="submit" name="backup" class="btn btn-primary">Backup Database</button>
                </form>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->

        <!-- Display backup records -->
        <?php if ($backupRecords): ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Backup Records</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example3" class="table table-bordered">
                      <thead>
                        <tr>
                          <th class='hidden-column'>ID</th>
                          <th>User</th>
                          <th>Backup File</th>
                          <th>Backup Date</th>
                          <th>Download</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($backupRecords as $record): ?>
                            <tr>
                              <td class="hidden-column"><?php echo $record['id']; ?></td>
                              <td><?php echo htmlspecialchars($record['complete_name']); ?></td>
                              <td><?php echo htmlspecialchars($record['backup_file']); ?></td>
                              <td><?php echo htmlspecialchars($record['backup_date']); ?></td>
                              <td><a href="<?php echo htmlspecialchars($record['backup_file']); ?>" class="btn btn-primary">Download</a></td>
                            </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        <?php endif; ?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper-->
  <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php' ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php' ?>

</body>
</html>
<?php
// Close database connection
$conn->close();
?>
