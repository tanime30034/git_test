<?php
include_once('../includes/dbcon.php');
// Retrieve company information
$sql = "SELECT * FROM tbl_company";
$result = $conn->query($sql);
$company = $result->fetch_assoc();

// Set default values for logo and project name
$logo = isset($company['company_logo']) ? $company['company_logo'] : '../../dist/img/AdminLTELogo.png';
$project_name = isset($company['company_name']) ? $company['company_name'] : 'MyProjectName';
// Close the statement


?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="../companyinfo/logo/<?php echo htmlspecialchars($logo); ?>" alt="SuyacMIS" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $project_name; ?></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="frontend.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="mapping.php" class="nav-link">Map</a>
          </li>
          
        <!-- SEARCH FORM -->
          
      </div>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
          <div class="dropdown-menu" aria-labelledby="loginDropdown">
            <a class="dropdown-item" href="../login/login.php">Admin</a>
            <a class="dropdown-item" href="#">Pet Owner</a>
            <a class="dropdown-item" href="#">Adopter</a>
          </div>
        </li> 
        </ul>  
    </div>   
  </nav>
 