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
    // Validate and sanitize adopter inputs
    if (!empty($_POST['adopter_name']) && !empty($_POST['adopter_contact']) && !empty($_POST['adopter_email']) && !empty($_POST['adopter_address']) && !empty($_POST['adopter_username']) && !empty($_POST['adopter_password']) && !empty($_FILES['adopter_profile']['name'])) {
        $adopterName = sanitize_input($_POST['adopter_name']);
        $petOwnerContact = sanitize_input($_POST['adopter_contact']);
        $petOwnerEmail = sanitize_input($_POST['adopter_email']);
        $petOwnerAddress = sanitize_input($_POST['adopter_address']);
        $petOwnerUsername = sanitize_input($_POST['adopter_username']);
        $petOwnerPassword = password_hash(sanitize_input($_POST['adopter_password']), PASSWORD_DEFAULT); // Hashing the password
        
        // Check if adopter with the same email or username already exists
        $stmt_check_duplicate = $conn->prepare("SELECT adopter_id FROM tbl_adopter WHERE adopter_email = ? OR adopter_username = ?");
        $stmt_check_duplicate->bind_param("ss", $petOwnerEmail, $petOwnerUsername);
        $stmt_check_duplicate->execute();
        $stmt_check_duplicate->store_result();
        if ($stmt_check_duplicate->num_rows > 0) {
            $_SESSION['error'] = 'A adopter with the same email or username already exists';
            $stmt_check_duplicate->close();
            header('location: ../adopter_list.php');
            exit();
        }
        $stmt_check_duplicate->close();

        // Upload profile image
        $targetDirectory = "../adopter_upload/";
        $targetFile = $targetDirectory . basename($_FILES["adopter_profile"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $imageName = $adopterName . '.' . $imageFileType;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["adopter_profile"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["adopter_profile"]["size"] > 10000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // If everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["adopter_profile"]["tmp_name"], $targetDirectory . $imageName)) {
                        // SQL injection prevention
                        $sql_insert_adopter = "INSERT INTO tbl_adopter (adopter_name, adopter_contact, adopter_email, adopter_address, adopter_profile, adopter_username, adopter_password) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt_insert_adopter = $conn->prepare($sql_insert_adopter);
                        $stmt_insert_adopter->bind_param("sssssss", $adopterName, $petOwnerContact, $petOwnerEmail, $petOwnerAddress, $imageName, $petOwnerUsername, $petOwnerPassword);
                        
                        // Execute the statement to insert adopter
                        if ($stmt_insert_adopter->execute()) {
                            // Log activity
                            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
                            $details = "Added new adopter: $adopterName";
                            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";
                            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
                            $stmt_insert_activitylog->bind_param("is", $user_id, $details);
                            if ($stmt_insert_activitylog->execute()) {
                                $_SESSION['success'] = 'Adopter added successfully';
                            } else {
                                $_SESSION['error'] = 'Failed to log activity: ' . mysqli_error($conn);
                            }
                            // Close statement
                            $stmt_insert_activitylog->close();
                        } else {
                            $_SESSION['error'] = 'Something went wrong while adding the adopter: ' . mysqli_error($conn);
                        }
                        
                        // Close statement
                        $stmt_insert_adopter->close();
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
header('location: ../adopter_list.php');
?>
