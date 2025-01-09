<?php

// Include the database connection file
include_once('../../includes/dbcon.php');

if (isset($_POST['barangay'])) {
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);

    // Prepare SQL statement to check for duplicate barangay
    $query = "SELECT barangay FROM tblBarangay WHERE barangay = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $barangay);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result
        mysqli_stmt_bind_result($stmt, $result);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        if ($result) {
            // Duplicate barangay found, display error message
            echo "<span style='color: red;'>Barangay already exists. Please enter a different barangay.</span>";
            echo "<script>document.getElementById('add_button').disabled = true;</script>";
        } else {
            // No duplicate found, display success message
            echo "<span style='color: green;'>Barangay available.</span>";
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
