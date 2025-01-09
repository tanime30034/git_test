<?php
// Start the session
session_start();

// Include the database connection
include '../includes/dbcon.php';

// Initialize error message variable
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind parameters
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows == 1) {
        // Fetch the row
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables for successful login
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $row['user_type']; // Store user type in session
            $_SESSION['complete_name'] = $row['complete_name'];

            // Redirect user to the dashboard upon successful login
            header("Location: ../dashboard/dashboard.php");
            exit();
        } else {
            // Set error message
            $error = 'Invalid username or password. Please try again.';
        }
    } else {
        // Set error message
        $error = 'Invalid username or password. Please try again.';
    }
}

// Redirect back to the login form with error message in query string
header("Location: login.php?error=" . urlencode($error));
exit();
?>
