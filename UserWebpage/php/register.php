<?php
include("dbc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["userName"]);
    $password = mysqli_real_escape_string($conn, $_POST["userPassword"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $stmt = mysqli_prepare($conn, "INSERT INTO userinfo (userName, userPassword, email) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Registration successful!';
        header("Location: ../login.html");

    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>