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
    if (!empty($_POST['id']) && !empty($_POST['pet_owner_name']) && !empty($_POST['pet_owner_contact']) && !empty($_POST['pet_owner_email']) && !empty($_POST['pet_owner_address'])) {
        $id = sanitize_input($_POST['id']);
        $new_pet_owner_name = sanitize_input($_POST['pet_owner_name']);
        $new_pet_owner_contact = sanitize_input($_POST['pet_owner_contact']);
        $new_pet_owner_email = sanitize_input($_POST['pet_owner_email']);
        $new_pet_owner_address = sanitize_input($_POST['pet_owner_address']);

        // Get the existing pet owner details from the database
        $stmt_select_old_pet_owner = $conn->prepare("SELECT pet_owner_name, pet_owner_contact, pet_owner_email, pet_owner_address FROM tbl_pet_owner WHERE pet_owner_id = ?");
        $stmt_select_old_pet_owner->bind_param("i", $id);
        $stmt_select_old_pet_owner->execute();
        $stmt_select_old_pet_owner->bind_result($old_pet_owner_name, $old_pet_owner_contact, $old_pet_owner_email, $old_pet_owner_address);
        $stmt_select_old_pet_owner->fetch();
        $stmt_select_old_pet_owner->close();

        // Check if the new pet owner details are different from the existing one
        if ($new_pet_owner_name != $old_pet_owner_name || $new_pet_owner_contact != $old_pet_owner_contact || $new_pet_owner_email != $old_pet_owner_email || $new_pet_owner_address != $old_pet_owner_address) {
            // SQL injection prevention
            $sql_update_pet_owner = "UPDATE tbl_pet_owner SET pet_owner_name = ?, pet_owner_contact = ?, pet_owner_email = ?, pet_owner_address = ? WHERE pet_owner_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for updating pet owner
            $stmt_update_pet_owner = $conn->prepare($sql_update_pet_owner);
            $stmt_update_pet_owner->bind_param("ssssi", $new_pet_owner_name, $new_pet_owner_contact, $new_pet_owner_email, $new_pet_owner_address, $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $log_details = "Updated pet owner: $old_pet_owner_name to $new_pet_owner_name, $old_pet_owner_contact to $new_pet_owner_contact, $old_pet_owner_email to $new_pet_owner_email, $old_pet_owner_address to $new_pet_owner_address";
            $stmt_insert_activitylog->bind_param("is", $user_id, $log_details);

            // Execute the query to update pet owner
            if ($stmt_update_pet_owner->execute()) {
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
            $stmt_update_pet_owner->close();
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

header('location: ../pet_owner_list.php');
?>
