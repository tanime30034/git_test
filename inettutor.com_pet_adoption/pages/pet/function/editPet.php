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
    if (!empty($_POST['pet_id']) && !empty($_POST['pet_owner_id']) && !empty($_POST['pet_name']) && !empty($_POST['pet_type_id']) && !empty($_POST['description']) && !empty($_POST['age']) && !empty($_POST['gender']) && !empty($_POST['health_status']) && !empty($_POST['vaccination_status']) && !empty($_POST['adoption_status'])) {
        
        $pet_id = sanitize_input($_POST['pet_id']);
        $pet_owner_id = sanitize_input($_POST['pet_owner_id']);
        $pet_name = sanitize_input($_POST['pet_name']);
        $pet_type_id = sanitize_input($_POST['pet_type_id']);
        $description = sanitize_input($_POST['description']);
        $age = sanitize_input($_POST['age']);
        $gender = sanitize_input($_POST['gender']);
        $health_status = sanitize_input($_POST['health_status']);
        $vaccination_status = sanitize_input($_POST['vaccination_status']);
        $adoption_status = sanitize_input($_POST['adoption_status']);
        $date_registered = date('Y-m-d H:i:s'); // Update the registration date on edit
        
        // For file upload (health history and proof of vaccination)
        $upload_health_history = $_FILES['upload_health_history']['name'];
        $proof_of_vaccination = $_FILES['proof_of_vaccination']['name'];
        
        // Directory for file upload
        $target_dir = "../../uploads/";
        $health_history_path = $target_dir . basename($upload_health_history);
        $vaccination_proof_path = $target_dir . basename($proof_of_vaccination);

        // Upload files to server
        if (!empty($upload_health_history)) {
            move_uploaded_file($_FILES['upload_health_history']['tmp_name'], $health_history_path);
        }
        if (!empty($proof_of_vaccination)) {
            move_uploaded_file($_FILES['proof_of_vaccination']['tmp_name'], $vaccination_proof_path);
        }

        // Fetch existing pet details
        $stmt_select_old_pet = $conn->prepare("SELECT pet_name, pet_type_id, description, age, gender, health_status, vaccination_status, adoption_status, upload_health_history, proof_of_vaccination FROM tbl_pet WHERE pet_id = ?");
        $stmt_select_old_pet->bind_param("i", $pet_id);
        $stmt_select_old_pet->execute();
        $stmt_select_old_pet->bind_result($old_pet_name, $old_pet_type_id, $old_description, $old_age, $old_gender, $old_health_status, $old_vaccination_status, $old_adoption_status, $old_upload_health_history, $old_proof_of_vaccination);
        $stmt_select_old_pet->fetch();
        $stmt_select_old_pet->close();

        // Use existing file if no new file is uploaded
        if (empty($upload_health_history)) {
            $upload_health_history = $old_upload_health_history;
        }
        if (empty($proof_of_vaccination)) {
            $proof_of_vaccination = $old_proof_of_vaccination;
        }

        // Check if changes were made
        if ($pet_name != $old_pet_name || $pet_type_id != $old_pet_type_id || $description != $old_description || $age != $old_age || $gender != $old_gender || $health_status != $old_health_status || $vaccination_status != $old_vaccination_status || $adoption_status != $old_adoption_status || $upload_health_history != $old_upload_health_history || $proof_of_vaccination != $old_proof_of_vaccination) {

            // Update pet details query
            $sql_update_pet = "UPDATE tbl_pet SET pet_owner_id = ?, pet_name = ?, pet_type_id = ?, description = ?, age = ?, gender = ?, health_status = ?, vaccination_status = ?, adoption_status = ?, upload_health_history = ?, proof_of_vaccination = ?, date_registered = ? WHERE pet_id = ?";
            
            $stmt_update_pet = $conn->prepare($sql_update_pet);
            $stmt_update_pet->bind_param("isisisssssssi", $pet_owner_id, $pet_name, $pet_type_id, $description, $age, $gender, $health_status, $vaccination_status, $adoption_status, $upload_health_history, $proof_of_vaccination, $date_registered, $pet_id);

            // Activity log for the update
            $sql_insert_activitylog = "INSERT INTO tbl_activity_log (user_id, details, date_time) VALUES (?, ?, NOW())";
            $stmt_insert_activitylog = $conn->prepare($sql_insert_activitylog);
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $log_details = "Updated pet: $old_pet_name to $pet_name, Health: $old_health_status to $health_status, Vaccination: $old_vaccination_status to $vaccination_status";
            $stmt_insert_activitylog->bind_param("is", $user_id, $log_details);

            // Execute pet update and log insertion
            if ($stmt_update_pet->execute()) {
                if ($stmt_insert_activitylog->execute()) {
                    $_SESSION['success'] = 'Pet details updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to log activity';
                }
            } else {
                $_SESSION['error'] = 'Failed to update pet details';
            }

            // Close statements
            $stmt_update_pet->close();
            $stmt_insert_activitylog->close();
        } else {
            $_SESSION['error'] = 'No changes made to the pet details';
        }
    } else {
        $_SESSION['error'] = 'Incomplete or invalid input data';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: ../pet_list.php');
?>
