<?php
include("dbc.php");

$login = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST["loginUserName"];
    $password = $_POST["loginPassword"];

    $sql = "SELECT * FROM userinfo  WHERE userName='$username' AND  userPassword = '$password'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1)
    {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location:../dashboard.html");
        exit();
    }
    else echo"<br> Invalid Username or Password <br>";
}
?>