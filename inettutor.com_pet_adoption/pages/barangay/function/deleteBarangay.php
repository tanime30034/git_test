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

        // Retrieve the name of the barangay being deleted
        $stmt_select_barangay = $conn->prepare("SELECT barangay FROM tbl_barangay WHERE location_id = ?");
        $stmt_select_barangay->bind_param("i", $id);
        $stmt_select_barangay->execute();
        $stmt_select_barangay->store_result();
        if ($stmt_select_barangay->num_rows > 0) {
            $stmt_select_barangay->bind_result($barangay_name);
            $stmt_select_barangay->fetch();

            // SQL injection prevention
            $sql_delete_barangay = "DELETE FROM tbl_barangay WHERE location_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for deleting barangay
            $stmt_delete_barangay = $conn->prepare($sql_delete_barangay);
            $stmt_delete_barangay->bind_param("i", $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $details = "Deleted barangay: $barangay_name";
            $stmt_insert_activitylog->bind_param("is", $user_id, $details);

            // Execute the query to delete barangay
            if ($stmt_delete_barangay->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Barangay deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting the barangay';
            }

            // Close statements
            $stmt_delete_barangay->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'Barangay not found';
        }
        $stmt_select_barangay->close();
    } else {
        $_SESSION['error'] = 'Invalid barangay ID';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../barangay_list.php');
?>
