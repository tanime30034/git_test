<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<?php 
include '../includes/header.php'; 
include_once('../includes/dbcon.php');

// Function to get company name from the database
function getCompanyName($conn) {
    $sql = "SELECT company_name FROM tbl_company LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['company_name'];
    } else {
        return 'Company'; // Default name if not found
    }
}

// Fetch the company name
$companyName = getCompanyName($conn);
?>
<!-- Header -->

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b><?php echo htmlspecialchars($companyName); ?></b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <!-- Display error message if present -->
                <?php if (isset($_GET['error']) && !empty($_GET['error'])) : ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>

                <form action="login_process.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</body>

</html>
