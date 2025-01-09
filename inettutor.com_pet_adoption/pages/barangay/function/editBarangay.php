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
    if (!empty($_POST['id']) && !empty($_POST['barangay'])) {
        $id = sanitize_input($_POST['id']);
        $new_barangay = sanitize_input($_POST['barangay']);

        // Get the existing barangay name from the database
        $stmt_select_old_barangay = $conn->prepare("SELECT barangay FROM tbl_barangay WHERE location_id = ?");
        $stmt_select_old_barangay->bind_param("i", $id);
        $stmt_select_old_barangay->execute();
        $stmt_select_old_barangay->bind_result($old_barangay);
        $stmt_select_old_barangay->fetch();
        $stmt_select_old_barangay->close();

        // Check if the new barangay name is different from the existing one
        if ($new_barangay != $old_barangay) {
            // SQL injection prevention
            $sql_update_barangay = "UPDATE tbl_barangay SET barangay = ? WHERE location_id = ?";
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

            // Prepare and bind parameters for updating barangay
            $stmt_update_barangay = $conn->prepare($sql_update_barangay);
            $stmt_update_barangay->bind_param("si", $new_barangay, $id);

            // Prepare and bind parameters for inserting activity log
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $log_details = "Updated barangay: $old_barangay to $new_barangay";
            $stmt_insert_activitylog->bind_param("is", $user_id, $log_details);

            // Execute the query to update barangay
            if ($stmt_update_barangay->execute()) {
                // Insert record into tblactivitylog
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Barangay updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Something went wrong in updating the barangay';
            }

            // Close statements
            $stmt_update_barangay->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'No changes made to the barangay';
        }
    } else {
        $_SESSION['error'] = 'Select barangay to edit first';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../barangay_list.php');
?>
