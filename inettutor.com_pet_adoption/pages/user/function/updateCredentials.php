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

if (isset($_POST['change_credentials'])) {
    // Validate and sanitize input parameters
    if (!empty($_POST['user_id']) && !empty($_POST['new_username']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $user_id = sanitize_input($_POST['user_id']);
        $new_username = sanitize_input($_POST['new_username']);
        $new_password = sanitize_input($_POST['new_password']);
        $confirm_password = sanitize_input($_POST['confirm_password']);

        // Check if passwords match
        if ($new_password === $confirm_password) {
            // Hash the password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // SQL injection prevention
            $sql_update_credentials = "UPDATE tbl_user SET username = ?, password = ? WHERE user_id = ?";
            $stmt_update_credentials = $conn->prepare($sql_update_credentials);
            $stmt_update_credentials->bind_param("ssi", $new_username, $hashed_password, $user_id);

            // Execute the query to update credentials
            if ($stmt_update_credentials->execute()) {
                $_SESSION['success'] = 'Username and password changed successfully';
            } else {
                $_SESSION['error'] = 'Failed to change username and password';
            }

            // Close statement
            $stmt_update_credentials->close();
        } else {
            $_SESSION['error'] = 'Passwords do not match';
        }
    } else {
        $_SESSION['error'] = 'Please fill out all fields';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

// Redirect to the rider list page
header('location: ../users_list.php');
?>
