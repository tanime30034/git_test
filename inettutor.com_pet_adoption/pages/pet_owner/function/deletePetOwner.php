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

if (isset($_GET['id'])) {
    // Validate and sanitize input parameter
    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        $id = sanitize_input($_GET['id']);

        // Retrieve the name of the pet_owner being deleted
        $stmt_select_pet_owner = $conn->prepare("SELECT pet_owner_name FROM tbl_pet_owner WHERE pet_owner_id = ?");
        $stmt_select_pet_owner->bind_param("i", $id);
        $stmt_select_pet_owner->execute();
        $result = $stmt_select_pet_owner->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pet_owner_name = $row['pet_owner_name'];

            // SQL injection prevention
            $sql_delete_pet_owner = "DELETE FROM tbl_pet_owner WHERE pet_owner_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, log_type, details, date_time) VALUES (?, 'delete', ?, NOW())";

            // Prepare and bind parameters for deleting pet_owner
            $stmt_delete_pet_owner = $conn->prepare($sql_delete_pet_owner);
            $stmt_delete_pet_owner->bind_param("i", $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $details = "Deleted pet_owner: $pet_owner_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $details);

            // Execute the query to delete pet_owner
            if ($stmt_delete_pet_owner->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet Owner deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting the pet_owner';
            }

            // Close statements
            $stmt_delete_pet_owner->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'Pet Owner not found';
        }
        $stmt_select_pet_owner->close();
    } else {
        $_SESSION['error'] = 'Invalid pet_owner ID';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../pet_owner_list.php');
?>
