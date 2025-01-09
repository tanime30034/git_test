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
    // Validate and sanitize pet owner inputs
    if (!empty($_POST['pet_owner_name']) && !empty($_POST['pet_owner_contact']) && !empty($_POST['pet_owner_email']) && !empty($_POST['pet_owner_address']) && !empty($_POST['pet_owner_username']) && !empty($_POST['pet_owner_password']) && !empty($_FILES['pet_owner_profile']['name'])) {
        $petOwnerName = sanitize_input($_POST['pet_owner_name']);
        $petOwnerContact = sanitize_input($_POST['pet_owner_contact']);
        $petOwnerEmail = sanitize_input($_POST['pet_owner_email']);
        $petOwnerAddress = sanitize_input($_POST['pet_owner_address']);
        $petOwnerUsername = sanitize_input($_POST['pet_owner_username']);
        $petOwnerPassword = password_hash(sanitize_input($_POST['pet_owner_password']), PASSWORD_DEFAULT); // Hashing the password
        
        // Check if pet owner with the same email or username already exists
        $stmt_check_duplicate = $conn->prepare("SELECT pet_owner_id FROM tbl_pet_owner WHERE pet_owner_email = ? OR pet_owner_username = ?");
        $stmt_check_duplicate->bind_param("ss", $petOwnerEmail, $petOwnerUsername);
        $stmt_check_duplicate->execute();
        $stmt_check_duplicate->store_result();
        if ($stmt_check_duplicate->num_rows > 0) {
            $_SESSION['error'] = 'A pet owner with the same email or username already exists';
            $stmt_check_duplicate->close();
            header('location: ../pet_owner_list.php');
            exit();
        }
        $stmt_check_duplicate->close();

        // Upload profile image
        $targetDirectory = "../pet_owner_upload/";
        $targetFile = $targetDirectory . basename($_FILES["pet_owner_profile"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $imageName = $petOwnerName . '.' . $imageFileType;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["pet_owner_profile"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["pet_owner_profile"]["size"] > 10000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // If everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["pet_owner_profile"]["tmp_name"], $targetDirectory . $imageName)) {
                        // SQL injection prevention
                        $sql_insert_pet_owner = "INSERT INTO tbl_pet_owner (pet_owner_name, pet_owner_contact, pet_owner_email, pet_owner_address, pet_owner_profile, pet_owner_username, pet_owner_password) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt_insert_pet_owner = $conn->prepare($sql_insert_pet_owner);
                        $stmt_insert_pet_owner->bind_param("sssssss", $petOwnerName, $petOwnerContact, $petOwnerEmail, $petOwnerAddress, $imageName, $petOwnerUsername, $petOwnerPassword);
                        
                        // Execute the statement to insert pet owner
                        if ($stmt_insert_pet_owner->execute()) {
                            // Log activity
                            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
                            $details = "Added new pet owner: $petOwnerName";
                            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";
                            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
                            $stmt_insert_activitylog->bind_param("is", $user_id, $details);
                            if ($stmt_insert_activitylog->execute()) {
                                $_SESSION['success'] = 'Pet owner added successfully';
                            } else {
                                $_SESSION['error'] = 'Failed to log activity: ' . mysqli_error($conn);
                            }
                            // Close statement
                            $stmt_insert_activitylog->close();
                        } else {
                            $_SESSION['error'] = 'Something went wrong while adding the pet owner: ' . mysqli_error($conn);
                        }
                        
                        // Close statement
                        $stmt_insert_pet_owner->close();
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
header('location: ../pet_owner_list.php');
?>
