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

if (isset($_POST['upload_profile_image'])) {
    // Validate and sanitize input parameters
    if (!empty($_POST['user_id']) && !empty($_FILES['profile_image'])) {
        $user_id = sanitize_input($_POST['user_id']);
        $profile_image = $_FILES['profile_image'];

        // Retrieve rider name from the database
        $sql_select_name = "SELECT complete_name FROM tbl_user WHERE user_id = ?";
        $stmt_select_name = $conn->prepare($sql_select_name);
        $stmt_select_name->bind_param("i", $user_id);
        $stmt_select_name->execute();
        $stmt_select_name->bind_result($complete_name);
        $stmt_select_name->fetch();
        $stmt_select_name->close();

        // Construct filename based on rider name
        $extension = strtolower(pathinfo($profile_image['name'], PATHINFO_EXTENSION));
        $file_name = $complete_name . "." . $extension;
        $target_dir = "../user_upload/";
        $target_file = $target_dir . $file_name;

        // Check file size
        if ($profile_image["size"] > 20000000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
        } else {
            // Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file); // Delete existing file
            }
            
            // Upload file
            if (move_uploaded_file($profile_image["tmp_name"], $target_file)) {
                // Update rider image path in the database
                $sql_update_image = "UPDATE tbl_user SET profile_image = ? WHERE user_id = ?";
                $stmt_update_image = $conn->prepare($sql_update_image);
                $stmt_update_image->bind_param("si", $file_name, $user_id);

                if ($stmt_update_image->execute()) {
                    $_SESSION['success'] = "The file ". htmlspecialchars(basename($profile_image["name"])) . " has been uploaded.";
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

// Redirect to the rider list page
header('location: ../users_list.php');
?>