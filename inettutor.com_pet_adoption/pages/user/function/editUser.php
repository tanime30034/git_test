<?php
session_start();
include_once('../../includes/dbcon.php');

if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $user_type = $_POST['user_type'];
    $complete_name = $_POST['complete_name'];
    $designation = $_POST['designation'];

    // Check for duplicate complete_name
    $stmt_check_duplicate = $conn->prepare("SELECT user_id FROM tbl_user WHERE complete_name = ? AND user_id != ?");
    $stmt_check_duplicate->bind_param("si", $complete_name, $id);
    $stmt_check_duplicate->execute();
    $result = $stmt_check_duplicate->get_result();
    if($result->num_rows > 0) {
        $_SESSION['error'] = 'A user with the same complete name already exists.';
    } else {
        // Prepare and bind parameters
        $stmt = $conn->prepare("UPDATE tbl_user SET user_type = ?, complete_name = ?, designation = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $user_type, $complete_name, $designation, $id);
        
        // Execute the query
        if($stmt->execute()){
            $_SESSION['success'] = 'User updated successfully';
        } else {
            $_SESSION['error'] = 'Something went wrong in updating the user';
        }
        
        // Close statement
        $stmt->close();
    }
    // Close statement
    $stmt_check_duplicate->close();
}
else{
    $_SESSION['error'] = 'Select user to edit first';
}

header('location: ../users_list.php');
?>
