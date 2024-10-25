<?php
    //Connecting to a database
    $server_name="localhost";
    $user_name ="root";
    $password = "";
    $database = "users";
    //Connection
    $conn = mysqli_connect($server_name,$user_name,$password,$database);
    if(!$conn) echo"Connection error"; 
    else echo "<br> Connection Successful <br>"; 
?>