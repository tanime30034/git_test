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

        // Retrieve the name of the pet being deleted
        $stmt_select_pet = $conn->prepare("SELECT pet_name FROM tbl_pet WHERE pet_id = ?");
        $stmt_select_pet->bind_param("i", $id);
        $stmt_select_pet->execute();
        $result = $stmt_select_pet->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pet_name = $row['pet_name'];

            // SQL injection prevention
            $sql_delete_pet = "DELETE FROM tbl_pet WHERE pet_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, log_type, details, date_time) VALUES (?, 'delete', ?, NOW())";

            // Prepare and bind parameters for deleting pet
            $stmt_delete_pet = $conn->prepare($sql_delete_pet);
            $stmt_delete_pet->bind_param("i", $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $details = "Deleted pet: $pet_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $details);

            // Execute the query to delete pet
            if ($stmt_delete_pet->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting the pet';
            }

            // Close statements
            $stmt_delete_pet->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'Pet not found';
        }
        $stmt_select_pet->close();
    } else {
        $_SESSION['error'] = 'Invalid pet ID';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../pet_list.php');
?>
