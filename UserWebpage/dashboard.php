<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title> 
    <link rel="stylesheet" href="css/dashboard.css">
    <body>
        <div class="header">
            <h1>Welcome to the Dashboard</h1>
            <?php
            session_start();
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
            {
                $username = $_SESSION['username'];
            } 
            ?>
            <h1>Hello,<?php echo htmlspecialchars( $username); ?></h1>
            <button class="logout">Logout</button>
        </div>
        
        <nav class="navbar">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="">Order & Sales</a></li>
                <li><a href="">Transaction</a></li>
                <li><a href="">Inventory</a></li>
                <li><a href="">Customer</a></li>
                <li><a href="">User logs</a></li>
            </ul>
        </nav>

        <main>
            
            <div class="dashboard">
                <div class="box">
                    <h2>Product Overview</h2>
                    <p>Total Product: 1200</p>
                    <p>Products in Stock: 120</p>
                    <p>Products out of Stock: 20</p>
                </div>
            
                <div class="box">
                    <h2>Recent Activity</h2>
                    <p>User1 added a new product.</p>
                    <p>Order #1234 was processed.</p>
                    <p>Inventory updated for Product XYZ.<p>
                </div>

                <div class="box">
                    <h2>Notifications</h2>
                    <p>⚠️ Low stock on Product ABC.</p>
                    <p>✅ Order #5678 was successfully shipped.</p>
                </div>
            
                <div class="box">
                    <h2>Sales Performance</h2>
                        <p>Total Sales:$5000</p>
                        <p>Transaction Today: $1200</p>
                        <p>Top Selling Product: Product A</p>
                </div>
            </div>  

        </main>
    </body>
</head>
</html>