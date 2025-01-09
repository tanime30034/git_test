<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('dbcon.php');

// Assuming the user_id is stored in the session
$user_id = $_SESSION['user_id'];

// Fetch the user's complete_name and profile_image from the database
$stmt = $conn->prepare("SELECT complete_name, profile_image FROM tbl_user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$complete_name = $user['complete_name'];
$profile_image = $user['profile_image'];

// Retrieve company information
$sql = "SELECT * FROM tbl_company";
$result = $conn->query($sql);
$company = $result->fetch_assoc();

// Set default values for logo and project name
$logo = isset($company['company_logo']) ? $company['company_logo'] : '../../dist/img/AdminLTELogo.png';
$project_name = isset($company['company_name']) ? $company['company_name'] : 'MyProjectName';

// Close the statement
$stmt->close();

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
    
      <img src="../companyinfo/logo/<?php echo htmlspecialchars($logo); ?>" alt="ProjectMIS" class="brand-image img-circle elevation-3"
        style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $project_name; ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="../user/user_upload/<?php echo htmlspecialchars($profile_image); ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?php echo htmlspecialchars($complete_name); ?></a>
              </div>
          </div>

          <li class="nav-item">
            <a href="../dashboard/dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-folder"></i>
                  <p>
                      Records
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="../pet_type/pet_type_list.php" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pet Type</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../pet_owner/pet_owner_list.php" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pet Owner</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../pet/pet_list.php" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pet Info</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../adopter/adopter_list.php" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Adopter</p>
                      </a>
                  </li>
              </ul>
          </li>

          
          
         
          <li class="nav-item">
            <a href="../report/report_list.php" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Reports
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                      Administration
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="../api/email_settings.php" class="nav-link">
                          <i class="nav-icon fas fa-envelope"></i>
                          <p>Email Settings</p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="../sms_email/sms_settings.php" class="nav-link">
                      <i class="nav-icon fas fa-sms"></i>
                      <p>
                        SMS Settings
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                      <a href="../activitylog/activity_log_list.php" class="nav-link">
                          <i class="nav-icon fas fa-history"></i>
                          <p>User Activity Log</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../companyinfo/company.php" class="nav-link">
                          <i class="nav-icon fas fa-info-circle"></i>
                          <p>Project Info</p>
                      </a>
                  </li>
                  <?php 
                  // Check if user type is admin before displaying the Users link
                  if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') { 
                  ?>
                  <li class="nav-item">
                      <a href="../user/users_list.php" class="nav-link">
                          <i class="nav-icon fas fa-users"></i>
                          <p>User Accounts</p>
                      </a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                      <a href="../backup/backup.php" class="nav-link">
                          <i class="nav-icon fas fa-database"></i>
                          <p>Backup Database</p>
                      </a>
                  </li>
              </ul>
          </li>
          <li class="nav-item">
            <a href="../user/my_profile.php" class="nav-link">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                My Profile
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="../frontend/frontend.php" class="nav-link" target="_blank">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Visit Front-end Website
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../includes/logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
