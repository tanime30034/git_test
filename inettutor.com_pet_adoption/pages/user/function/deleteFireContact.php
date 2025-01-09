<?php
    session_start();
    include_once('../../includes/dbcon.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        // Prepare and bind parameters
        $stmt = $conn->prepare("DELETE FROM tblUser WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if($stmt->execute()){
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Something went wrong in deleting the user';
        }
        
        // Close statement
        $stmt->close();
    }
    else{
        $_SESSION['error'] = 'Select user to delete first';
    }

    header('location: ../users_list.php');
?>
