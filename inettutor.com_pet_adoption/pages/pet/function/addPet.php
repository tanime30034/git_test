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
    // Validate and sanitize pet inputs
    if (!empty($_POST['pet_owner_id']) && !empty($_POST['pet_name']) && !empty($_POST['pet_type_id']) && !empty($_POST['description']) && !empty($_POST['age']) && !empty($_POST['gender']) && !empty($_POST['health_status']) && !empty($_POST['vaccination_status']) && !empty($_POST['adoption_status']) && !empty($_FILES['pet_profile_image']['name'])) {
        
        $petOwnerId = sanitize_input($_POST['pet_owner_id']);
        $petName = sanitize_input($_POST['pet_name']);
        $petTypeId = sanitize_input($_POST['pet_type_id']);
        $description = sanitize_input($_POST['description']);
        $age = sanitize_input($_POST['age']);
        $gender = sanitize_input($_POST['gender']);
        $healthStatus = sanitize_input($_POST['health_status']);
        $vaccinationStatus = sanitize_input($_POST['vaccination_status']);
        $adoptionStatus = sanitize_input($_POST['adoption_status']);
        
        // Handle profile image upload
        $targetDirectory = "../pet_profile_upload/";
        $targetFile = $targetDirectory . basename($_FILES["pet_profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $imageName = $petName . '.' . $imageFileType;

        // Check if the file is an image
        $check = getimagesize($_FILES["pet_profile_image"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["pet_profile_image"]["size"] > 10000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Try to upload the file
                    if (move_uploaded_file($_FILES["pet_profile_image"]["tmp_name"], $targetDirectory . $imageName)) {
                        
                        // Handle health history file upload
                        $healthHistoryFile = '';
                        if (!empty($_FILES['upload_health_history']['name'])) {
                            $targetHealthHistory = "../health_history_upload/" . basename($_FILES["upload_health_history"]["name"]);
                            $healthHistoryFile = basename($_FILES["upload_health_history"]["name"]);
                            move_uploaded_file($_FILES["upload_health_history"]["tmp_name"], $targetHealthHistory);
                        }

                        // Handle proof of vaccination upload
                        $vaccinationProof = '';
                        if (!empty($_FILES['proof_of_vaccination']['name'])) {
                            $targetVaccinationProof = "../vaccination_proof_upload/" . basename($_FILES["proof_of_vaccination"]["name"]);
                            $vaccinationProof = basename($_FILES["proof_of_vaccination"]["name"]);
                            move_uploaded_file($_FILES["proof_of_vaccination"]["tmp_name"], $targetVaccinationProof);
                        }

                        // SQL query to insert the new pet
                        $sql_insert_pet = "INSERT INTO tbl_pet (pet_owner_id, pet_name, pet_type_id, description, age, gender, health_status, upload_health_history, vaccination_status, proof_of_vaccination, adoption_status, pet_profile_image, date_registered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                        $stmt_insert_pet = $conn->prepare($sql_insert_pet);
                        $stmt_insert_pet->bind_param("isisssssssss", $petOwnerId, $petName, $petTypeId, $description, $age, $gender, $healthStatus, $healthHistoryFile, $vaccinationStatus, $vaccinationProof, $adoptionStatus, $imageName);

                        // Execute the statement to insert pet
                        if ($stmt_insert_pet->execute()) {
                            // Log activity
                            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
                            $details = "Added new pet: $petName";
                            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";
                            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
                            $stmt_insert_activitylog->bind_param("is", $user_id, $details);
                            if ($stmt_insert_activitylog->execute()) {
                                $_SESSION['success'] = 'Pet added successfully';
                            } else {
                                $_SESSION['error'] = 'Failed to log activity: ' . mysqli_error($conn);
                            }
                            // Close statement
                            $stmt_insert_activitylog->close();
                        } else {
                            $_SESSION['error'] = 'Something went wrong while adding the pet: ' . mysqli_error($conn);
                        }
                        
                        // Close statement
                        $stmt_insert_pet->close();
                    } else {
                        $_SESSION['error'] = "Sorry, there was an error uploading your profile image.";
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
header('location: ../pet_list.php');
?>
