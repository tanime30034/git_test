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

if (isset($_POST['edit'])) {
    // Validate and sanitize input parameters
    if (!empty($_POST['id']) && !empty($_POST['adopter_name']) && !empty($_POST['adopter_contact']) && !empty($_POST['adopter_email']) && !empty($_POST['adopter_address'])) {
        $id = sanitize_input($_POST['id']);
        $new_adopter_name = sanitize_input($_POST['adopter_name']);
        $new_adopter_contact = sanitize_input($_POST['adopter_contact']);
        $new_adopter_email = sanitize_input($_POST['adopter_email']);
        $new_adopter_address = sanitize_input($_POST['adopter_address']);

        // Get the existing pet owner details from the database
        $stmt_select_old_adopter = $conn->prepare("SELECT adopter_name, adopter_contact, adopter_email, adopter_address FROM tbl_adopter WHERE adopter_id = ?");
        $stmt_select_old_adopter->bind_param("i", $id);
        $stmt_select_old_adopter->execute();
        $stmt_select_old_adopter->bind_result($old_adopter_name, $old_adopter_contact, $old_adopter_email, $old_adopter_address);
        $stmt_select_old_adopter->fetch();
        $stmt_select_old_adopter->close();

        // Check if the new pet owner details are different from the existing one
        if ($new_adopter_name != $old_adopter_name || $new_adopter_contact != $old_adopter_contact || $new_adopter_email != $old_adopter_email || $new_adopter_address != $old_adopter_address) {
            // SQL injection prevention
            $sql_update_adopter = "UPDATE tbl_adopter SET adopter_name = ?, adopter_contact = ?, adopter_email = ?, adopter_address = ? WHERE adopter_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for updating pet owner
            $stmt_update_adopter = $conn->prepare($sql_update_adopter);
            $stmt_update_adopter->bind_param("ssssi", $new_adopter_name, $new_adopter_contact, $new_adopter_email, $new_adopter_address, $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $log_details = "Updated pet owner: $old_adopter_name to $new_adopter_name, $old_adopter_contact to $new_adopter_contact, $old_adopter_email to $new_adopter_email, $old_adopter_address to $new_adopter_address";
            $stmt_insert_activitylog->bind_param("is", $user_id, $log_details);

            // Execute the query to update pet owner
            if ($stmt_update_adopter->execute()) {
                // Insert record into tbl_activity_log
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet owner updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in updating the pet owner';
            }

            // Close statements
            $stmt_update_adopter->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'No changes made to the pet owner';
        }
    } else {
        $_SESSION['error'] = 'Incomplete or invalid input data';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../adopter_list.php');
?>
