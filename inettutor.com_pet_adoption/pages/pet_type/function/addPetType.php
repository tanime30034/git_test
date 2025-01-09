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
    // Validate and sanitize pet_type_name input
    if (!empty($_POST['pet_type_name'])) {
        $pet_type_name = sanitize_input($_POST['pet_type_name']);

        // SQL injection prevention
        $sql_insert_pet_type_name = "INSERT INTO tbl_pet_type (pet_type_name) VALUES (?)";
        $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";

        // Prepare and bind parameters for inserting pet_type_name
        $stmt_insert_pet_type_name = $conn->prepare($sql_insert_pet_type_name);
        $stmt_insert_pet_type_name->bind_param("s", $pet_type_name);

        // Prepare and bind parameters for inserting activity log
        $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
        $details = "Add new pet_type_name: $pet_type_name";
        $stmt_insert_activitylog->bind_param("is", $user_id, $details);

        // Execute the statement to insert pet_type_name
        if ($stmt_insert_pet_type_name->execute()) {
            // Insert record into tblactivitylog
            if ($stmt_insert_activitylog->execute()) {
                $_SESSION['success'] = 'Pet Type added successfully';
            } else {
                $_SESSION['error'] = 'Failed to log activity';
            }
        } else {
            $_SESSION['error'] = 'Something went wrong while adding pet_type_name';
        }

        // Close statements
        $stmt_insert_pet_type_name->close();
        $stmt_insert_activitylog->close();
    } else {
        $_SESSION['error'] = 'Pet Type field is required';
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

// Redirect to the appropriate page
header('location: ../pet_type_list.php');
?>
