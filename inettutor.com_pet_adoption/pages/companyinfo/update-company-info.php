<?php
// Include the authentication check file
include_once('../includes/auth_check.php');

// Database connection and other necessary functions or configurations
require_once '../includes/dbcon.php';

// Handling form submission to update company information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $company_id = isset($_POST['company_id']) ? intval($_POST['company_id']) : 0;
    $company_name = isset($_POST['company_name']) ? htmlspecialchars($_POST['company_name']) : '';
    $company_address = isset($_POST['company_address']) ? htmlspecialchars($_POST['company_address']) : '';
    $company_contact = isset($_POST['company_contact']) ? htmlspecialchars($_POST['company_contact']) : '';
    $company_website = isset($_POST['company_website']) ? htmlspecialchars($_POST['company_website']) : '';

    // Prepare SQL statement
    if ($_FILES["company_logo"]["name"]) {
        // Handle file upload for logo if a new logo is uploaded
        $targetDir = "logo/";
        $fileName = basename($_FILES["company_logo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $targetFilePath)) {
                // Update company information in the database with new logo
                $sql = "UPDATE tbl_company SET company_name=?, company_address=?, company_contact=?, company_website=?, company_logo=? WHERE company_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $company_name, $company_address, $company_contact, $company_website, $fileName, $company_id);
                $stmt->execute();
                $stmt->close();
                $conn->close();
                header("Location: company.php"); // Redirect to company info page after successful update
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
        }
    } else {
        // Update company information in the database without changing the logo
        $sql = "UPDATE tbl_company SET company_name=?, company_address=?, company_contact=?, company_website=? WHERE company_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $company_name, $company_address, $company_contact, $company_website, $company_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: company.php"); // Redirect to company info page after successful update
        exit();
    }
}
?>
