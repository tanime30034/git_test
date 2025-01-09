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

        // Retrieve the name of the pet_type_name being deleted
        $stmt_select_pet_type_name = $conn->prepare("SELECT pet_type_name FROM tbl_pet_type WHERE pet_type_id = ?");
        $stmt_select_pet_type_name->bind_param("i", $id);
        $stmt_select_pet_type_name->execute();
        $stmt_select_pet_type_name->store_result();
        if ($stmt_select_pet_type_name->num_rows > 0) {
            $stmt_select_pet_type_name->bind_result($pet_type_name_name);
            $stmt_select_pet_type_name->fetch();

            // SQL injection prevention
            $sql_delete_pet_type_name = "DELETE FROM tbl_pet_type WHERE pet_type_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for deleting pet_type_name
            $stmt_delete_pet_type_name = $conn->prepare($sql_delete_pet_type_name);
            $stmt_delete_pet_type_name->bind_param("i", $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $details = "Deleted pet_type_name: $pet_type_name_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $details);

            // Execute the query to delete pet_type_name
            if ($stmt_delete_pet_type_name->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet Type deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting the pet_type_name';
            }

            // Close statements
            $stmt_delete_pet_type_name->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'Pet Type not found';
        }
        $stmt_select_pet_type_name->close();
    } else {
        $_SESSION['error'] = 'Invalid pet_type_name ID';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../pet_type_list.php');
?>
