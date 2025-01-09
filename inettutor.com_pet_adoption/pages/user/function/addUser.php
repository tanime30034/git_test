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
    // Validate and sanitize user inputs
    if (!empty($_POST['complete_name']) && !empty($_POST['designation']) && !empty($_POST['user_type']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_FILES['profile_image']['name'])) {
        $completeName = sanitize_input($_POST['complete_name']);
        $designation = sanitize_input($_POST['designation']);
        $userType = sanitize_input($_POST['user_type']);
        $username = sanitize_input($_POST['username']);
        $password = password_hash(sanitize_input($_POST['password']), PASSWORD_DEFAULT); // Hashing the password
        
        // Upload image
        $targetDirectory = "../user_upload/";
        $targetFile = $targetDirectory . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $imageName = $completeName . '.' . $imageFileType;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["profile_image"]["size"] > 20000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // if everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetDirectory . $imageName)) {
                        // SQL injection prevention
                        $sql_insert_user = "INSERT INTO tbl_user (complete_name, designation, user_type, username, password, profile_image) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt_insert_user = $conn->prepare($sql_insert_user);
                        $stmt_insert_user->bind_param("ssssss", $completeName, $designation, $userType, $username, $password, $imageName);
                        
                        // Execute the statement to insert user
                            if ($stmt_insert_user->execute()) {
                                // Log activity
                                $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
                                $details = "Added new user: $completeName";
                                $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";
                                $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
                                $stmt_insert_activitylog->bind_param("is", $user_id, $details);
                                if ($stmt_insert_activitylog->execute()) {
                                    $_SESSION['success'] = 'User added successfully';
                                } else {
                                    $_SESSION['error'] = 'Failed to log activity: ' . mysqli_error($conn);
                                }
                                // Close statement
                                $stmt_insert_activitylog->close();
                            } else {
                                // Check for duplicate entry error
                                if ($conn->errno == 1062) { // MySQL error code for duplicate entry
                                    // Check if the duplicate entry is in username or complete_name
                                    $error_message = '';
                                    if (strpos($conn->error, 'username') !== false) {
                                        $error_message .= "Username already exists. ";
                                    }
                                    if (strpos($conn->error, 'complete_name') !== false) {
                                        $error_message .= "Complete name already exists. ";
                                    }
                                    $_SESSION['error'] = $error_message;
                                } else {
                                    $_SESSION['error'] = 'Something went wrong while adding the user: ' . mysqli_error($conn);
                                }
                            }
                        // Close statement
                        $stmt_insert_user->close();
                    } else {
                        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                    }
                }
            }
        } else {
            $_SESSION['error'] = "File is not an image.";
        }
    } else {
        $_SESSION['error'] = 'Please fill up all fields';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

// Redirect to the appropriate page
header('location: ../users_list.php');
?>