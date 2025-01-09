<?php

// Include the database connection file
include_once('../../includes/dbcon.php');

if (isset($_POST['pet_type_name'])) {
    $pet_type_name = mysqli_real_escape_string($conn, $_POST['pet_type_name']);

    // Prepare SQL statement to check for duplicate pet_type_name
    $query = "SELECT pet_type_name FROM tbl_pet_type WHERE pet_type_name = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $pet_type_name);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result
        mysqli_stmt_bind_result($stmt, $result);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        if ($result) {
            // Duplicate pet_type_name found, display error message
            echo "<span style='color: red;'>Pet Type already exists. Please enter a different pet_type_name.</span>";
            echo "<script>document.getElementById('add_button').disabled = true;</script>";
        } else {
            // No duplicate found, display success message
            echo "<span style='color: green;'>Pet Type available.</span>";
            echo "<script>document.getElementById('add_button').disabled = false;</script>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the SQL statement
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
