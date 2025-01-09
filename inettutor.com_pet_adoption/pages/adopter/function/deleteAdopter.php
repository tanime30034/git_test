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

        // Retrieve the name of the adopter being deleted
        $stmt_select_adopter = $conn->prepare("SELECT adopter_name FROM tbl_adopter WHERE adopter_id = ?");
        $stmt_select_adopter->bind_param("i", $id);
        $stmt_select_adopter->execute();
        $result = $stmt_select_adopter->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $adopter_name = $row['adopter_name'];

            // SQL injection prevention
            $sql_delete_adopter = "DELETE FROM tbl_adopter WHERE adopter_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, log_type, details, date_time) VALUES (?, 'delete', ?, NOW())";

            // Prepare and bind parameters for deleting adopter
            $stmt_delete_adopter = $conn->prepare($sql_delete_adopter);
            $stmt_delete_adopter->bind_param("i", $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $details = "Deleted adopter: $adopter_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $details);

            // Execute the query to delete adopter
            if ($stmt_delete_adopter->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Adopter deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting the adopter';
            }

            // Close statements
            $stmt_delete_adopter->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'Adopter not found';
        }
        $stmt_select_adopter->close();
    } else {
        $_SESSION['error'] = 'Invalid adopter ID';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../adopter_list.php');
?>
