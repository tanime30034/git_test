<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
    <?php
    $message = "";
    // Database connection
    $server_name = 'localhost';
    $user_name = 'root';
    $password = '';
    $database = 'users';

    $conn = new mysqli($server_name, $user_name, $password, $database);
    if ($conn->connect_error) {
        die('Connection Error' . $conn->connect_error);
    }

    // Check if the data is posted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve posted data
        $productname = $_POST['productname'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO products (productname, category, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $productname, $category, $quantity, $price);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "New Product has been added successfully";
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $conn->close();
    ?>

    <div class="header">
        <h1>Inventory Manager</h1>
        <?php
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $username = $_SESSION['username'];
        }
        ?>
        <h1><?php echo htmlspecialchars($username); ?></h1>
        <button class="logout">Logout</button>
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="">Product</a></li>
            <li><a href="">Order & Sales</a></li>
            <li><a href="">Transaction</a></li>
            <li><a href="">Inventory</a></li>
            <li><a href="">Customer</a></li>
            <li><a href="">User logs</a></li>
        </ul>
    </nav>

    <div class="content-container">
        <div class="box">
            <div class="title">Add a Product:</div>

            <!-- Display success message if it exists -->
            <?php if (!empty($message)): ?>
                <p style="color: green;"><?php echo $message; ?></p>
            <?php endif; ?>
            <form class="form" method="POST" action="">
                <div class="input_field">
                    <label>Product Name</label>
                    <input type="text" class="input" name="productname" required>
                </div>
                <div class="input_field">
                    <label>Product Category</label>
                    <select name="category" required>
                        <option>Select</option>
                        <option>Electronics</option>
                        <option>Clothes</option>
                        <option>Accessories</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Product Quantity</label>
                    <input type="number" class="input" name="quantity" required>
                </div>
                <div class="input_field">
                    <label>Product Price</label>
                    <input type="number" class="input" name="price" required>
                </div>
                <div class="input_field_button">
                    <input type="submit" value="Add product" class="button-primary">
                </div>
            </form>
        </div>

        <!-- Search Product-->
        <div class="box">
            <div class="title">Product Search:</div>
            <div class="search">
                <input type="text" placeholder="Enter product name..." class="search-input">
                <button class="search-button">Search</button>
            </div>
            <div class="product-list">
                <!-- Placeholder for product details -->
                <p>No products found.</p>
            </div>
        </div>

        <div class="product-details">
            <!-- Product details table -->
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Stock Level</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <tbody>
                    <?php
                    // Database connection details
                    $server_name = 'localhost';
                    $user_name = 'root';
                    $password = '';
                    $database = 'users';
                    
                    // Connect to the database
                    $conn = new mysqli($server_name, $user_name, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die('Connection Error: ' . $conn->connect_error);
                    }

                    // Query to get all products
                    $sql = "SELECT productname, category, quantity, price FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Fetch each product row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['productname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>" . ($row['quantity'] > 0 ? "In Stock" : "Out of Stock") . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                    <!-- Additional rows can be added here dynamically if needed -->
                    </tbody>
                </thead>
            </table>
        </div>
    </div>
</body>
</html>
