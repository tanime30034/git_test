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
    if (!empty($_POST['id']) && !empty($_POST['pet_type_name'])) {
        $id = sanitize_input($_POST['id']);
        $new_pet_type_name = sanitize_input($_POST['pet_type_name']);

        // Get the existing pet_type_name name from the database
        $stmt_select_old_pet_type_name = $conn->prepare("SELECT pet_type_name FROM tbl_pet_type WHERE pet_type_id = ?");
        $stmt_select_old_pet_type_name->bind_param("i", $id);
        $stmt_select_old_pet_type_name->execute();
        $stmt_select_old_pet_type_name->bind_result($old_pet_type_name);
        $stmt_select_old_pet_type_name->fetch();
        $stmt_select_old_pet_type_name->close();

        // Check if the new pet_type_name name is different from the existing one
        if ($new_pet_type_name != $old_pet_type_name) {
            // SQL injection prevention
            $sql_update_pet_type_name = "UPDATE tbl_pet_type SET pet_type_name = ? WHERE pet_type_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for updating pet_type_name
            $stmt_update_pet_type_name = $conn->prepare($sql_update_pet_type_name);
            $stmt_update_pet_type_name->bind_param("si", $new_pet_type_name, $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $log_details = "Updated pet_type_name: $old_pet_type_name to $new_pet_type_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $log_details);

            // Execute the query to update pet_type_name
            if ($stmt_update_pet_type_name->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet Type updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in updating the pet_type_name';
            }

            // Close statements
            $stmt_update_pet_type_name->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'No changes made to the pet_type_name';
        }
    } else {
        $_SESSION['error'] = 'Select pet_type_name to edit first';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../pet_type_list.php');
?>
