<?php 
include_once('../includes/auth_check.php');
require_once('../includes/dbcon.php');

// Retrieve user information based on their session
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tbl_user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Ensure the 'designation', 'user_type', 'profile_image', and 'username' fields are set to avoid undefined array key warnings
$complete_name = isset($user['complete_name']) ? $user['complete_name'] : '';
$designation = isset($user['designation']) ? $user['designation'] : '';
$user_type = isset($user['user_type']) ? $user['user_type'] : '';
$profile_image = isset($user['profile_image']) ? $user['profile_image'] : 'default.png';
$username = isset($user['username']) ? $user['username'] : '';

// Handling form submission to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Retrieve form data
    $complete_name = $_POST['complete_name'];
    $designation = $_POST['designation'];
    $user_type = $_POST['user_type'];

    // Update user information in the database
    $update_sql = "UPDATE tbl_user SET complete_name = ?, designation = ?, user_type = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $complete_name, $designation, $user_type, $user_id);
    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully";
    } else {
        $_SESSION['error'] = "Error updating profile";
    }

    header("Location: my_profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_picture'])) {
    // Handle file upload for profile image
    if (!empty($_FILES["profile_image"]["name"])) {
        $targetDir = "user_upload/";
        $fileName = basename($_FILES["profile_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if($check !== false) {
            // Allow certain file formats
            $allowedTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType, $allowedTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)){
                    // Update user information in the database
                    $update_sql = "UPDATE tbl_user SET profile_image = ? WHERE user_id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("si", $fileName, $user_id);
                    if ($update_stmt->execute()) {
                        $_SESSION['success'] = "Profile picture updated successfully";
                    } else {
                        $_SESSION['error'] = "Error updating profile picture";
                    }
                } else {
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            $_SESSION['error'] = "File is not an image.";
        }
    } else {
        $_SESSION['error'] = "Please select a file.";
    }

    header("Location: my_profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Validate if passwords match
    if ($new_password != $confirm_new_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: my_profile.php");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update user information in the database
    $update_sql = "UPDATE tbl_user SET username = ?, password = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $username, $hashed_password, $user_id);
    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Username and password updated successfully";
    } else {
        $_SESSION['error'] = "Error updating username and password";
    }

    header("Location: my_profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../includes/header.php'; ?>
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
            <h1>My Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php include '../includes/success_message.php'; ?>
        <?php include '../includes/error_message.php'; ?>    
        <div class="row">
          <!-- Left column for profile information -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <form method="post">
                  <!-- Input fields for user information -->
                  <div class="form-group">
                    <label for="complete_name">Full Name</label>
                    <input type="text" class="form-control" id="complete_name" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>">
                  </div>
                  <div class="form-group">
                    <label for="designation">Designation</label>
                    <textarea class="form-control" id="designation" name="designation"><?php echo htmlspecialchars($designation); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select class="form-control" id="user_type" name="user_type">
                      <option value="admin" <?php echo ($user_type == 'admin') ? 'selected' : ''; ?>>Admin</option>
                      <option value="user" <?php echo ($user_type == 'user') ? 'selected' : ''; ?>>User</option>
                    </select>
                  </div>
                  <!-- Submit button for profile -->
                  <button type="submit" class="btn btn-primary btn-block mt-2" name="update_profile">Update Profile</button>
                </form>
              </div>
            </div>
          </div>
          <!-- Right column for profile picture -->
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <!-- Profile picture -->
                <div class="text-center">
                  <img src="user_upload/<?php echo htmlspecialchars($profile_image); ?>" class="img-fluid img" alt="Profile Picture">
                  <!-- Form for profile picture upload -->
                  <form method="post" enctype="multipart/form-data">
                    <input type="file" class="form-control-file mt-2" id="profile_image" name="profile_image">
                    <br>
                    <!-- Submit button for profile picture -->
                    <button type="submit" class="btn btn-primary btn-block" name="update_picture">Update Profile Picture</button>
                  </form>
                  <hr>
                  <!-- Form for username and password -->
                  <form method="post">
                    <!-- Username -->
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <!-- New Password -->
                    <div class="form-group">
                      <label for="new_password">New Password</label>
                      <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    <!-- Confirm New Password -->
                    <div class="form-group">
                      <label for="confirm_new_password">Confirm New Password</label>
                      <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                    </div>
                    <!-- Submit button for username and password -->
                    <button type="submit" class="btn btn-primary btn-block" name="update_password">Update Login Credentials</button>
                  </form>
                </div>    
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php'; ?>

</div>
<!-- ./wrapper -->
<?php include '../includes/footer.php'; ?>
</body>
</html>
