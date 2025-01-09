<?php
include '../includes/dbcon.php';
// Retrieve company contact from the database
$sql = "SELECT company_contact, company_name, company_website FROM tbl_company";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $company_contact = $row["company_contact"];
    $company_name = $row["company_name"];
    $company_website = $row["company_website"];
}
?>

<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        <?php echo "$company_contact"; ?>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 
        <a href="<?php echo $company_website; ?>"><?php echo "$company_name"; ?></a>.
    </strong> All rights reserved.
</footer>
