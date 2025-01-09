<?php
// Include the database connection file
include_once('../../includes/dbcon.php');

if (isset($_POST['adopterName'])) {
    $adopterName = mysqli_real_escape_string($conn, $_POST['adopterName']);

    // Prepare SQL statement to check for duplicate owner names
    $query = "SELECT adopter_name FROM tbl_adopter WHERE adopter_name = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $adopterName);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result
        mysqli_stmt_bind_result($stmt, $result);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        if ($result) {
            // Duplicate owner name found, display error message
            echo "<span style='color: red;'>Adopter name already exists. Please enter a different name.</span>";
            echo "<script>$('#response').html(\"<span style='color: red;'>Adopter name already exists. Please enter a different name.</span>\"); $('#add_button').prop('disabled', true);</script>";
        } else {
            // No duplicate found, display success message
            echo "<span style='color: green;'>Adopter name available.</span>";
            echo "<script>$('#response').html(\"<span style='color: green;'>Adopter name available.</span>\"); $('#add_button').prop('disabled', false);</script>";
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
