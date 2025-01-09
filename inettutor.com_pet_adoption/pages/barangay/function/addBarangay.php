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

if (isset($_POST['add'])) {
    // Validate and sanitize barangay input
    if (!empty($_POST['barangay'])) {
        $barangay = sanitize_input($_POST['barangay']);

        // SQL injection prevention
        $sql_insert_barangay = "INSERT INTO tbl_barangay (barangay) VALUES (?)";
        $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

        // Prepare and bind parameters for inserting barangay
        $stmt_insert_barangay = $conn->prepare($sql_insert_barangay);
        $stmt_insert_barangay->bind_param("s", $barangay);

        // Prepare and bind parameters for inserting activity log
        $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
        $details = "Add new barangay: $barangay";
        $stmt_insert_activitylog->bind_param("is", $user_id, $details);

        // Execute the statement to insert barangay
        if ($stmt_insert_barangay->execute()) {
            // Insert record into tblactivitylog
            if ($stmt_insert_activitylog->execute()) {
                $_SESSION['success'] = 'Barangay added successfully';
            } else {
                $_SESSION['error'] = 'Failed to log activity';
            }
        } else {
            $_SESSION['error'] = 'Something went wrong while adding barangay';
        }

        // Close statements
        $stmt_insert_barangay->close();
        $stmt_insert_activitylog->close();
    } else {
        $_SESSION['error'] = 'Barangay field is required';
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

// Redirect to the appropriate page
header('location: ../barangay_list.php');
?>
