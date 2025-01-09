<?php
session_start();
include_once('../../includes/dbcon.php');

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['upload_adopter_image'])) {
    // Validate and sanitize input parameters
    if (!empty($_POST['adopter_id']) && !empty($_FILES['adopter_image'])) {
        $adopter_id = sanitize_input($_POST['adopter_id']);
        $adopter_image = $_FILES['adopter_image'];

        // Retrieve adopter name from the database
        $sql_select_name = "SELECT adopter_name FROM tbl_adopter WHERE adopter_id = ?";
        $stmt_select_name = $conn->prepare($sql_select_name);
        $stmt_select_name->bind_param("i", $adopter_id);
        $stmt_select_name->execute();
        $stmt_select_name->bind_result($adopter_name);
        $stmt_select_name->fetch();
        $stmt_select_name->close();

        // Construct filename based on adopter name
        $extension = strtolower(pathinfo($adopter_image['name'], PATHINFO_EXTENSION));
        $file_name = $adopter_name . "." . $extension;
        $target_dir = "../adopter_upload/";
        $target_file = $target_dir . $file_name;

        // Check file size
        if ($adopter_image["size"] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
        } else {
            // Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file); // Delete existing file
            }
            
            // Upload file
            if (move_uploaded_file($adopter_image["tmp_name"], $target_file)) {
                // Update adopter image path in the database
                $sql_update_image = "UPDATE tbl_adopter SET adopter_profile = ? WHERE adopter_id = ?";
                $stmt_update_image = $conn->prepare($sql_update_image);
                $stmt_update_image->bind_param("si", $file_name, $adopter_id);

                if ($stmt_update_image->execute()) {
                    $_SESSION['success'] = "The file ". htmlspecialchars(basename($adopter_image["name"])) . " has been uploaded.";
                } else {
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                }
                $stmt_update_image->close();
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['error'] = 'Please select a file to upload';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

// Redirect to the adopter list page
header('location: ../adopter_list.php');
?>
