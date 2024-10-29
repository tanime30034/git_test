<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
            $username = $_SESSION['username'];
        } 
    ?>
    <div class="navbar">
        <h1>Welcome to the Dashboard</h1>
        <a href="profile.php" class="button">Go to Profile</a>
        <a href="settings.php" class="button">Settings</a>
        <a href="reports.php" class="button">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h2 class="username-greeting">Hello, <?php echo htmlspecialchars($username); ?></h2>
        <div class="center-paragraph">
            <p>Welcome to your dashboard! Here you can manage your profile, view data, and access different sections of the system.</p>
        </div>   
    </div>
</body>

</html>
