<?php
require "./includes/header.php";

// Ensure the inventory table exists
$sql = "CREATE TABLE IF NOT EXISTS inventory (
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
$conn->query($sql);

// Display products
$sql = "SELECT p.*, (p.quantity * p.price) AS total_price, i.quantity AS inventory_quantity 
        FROM products p 
        LEFT JOIN inventory i ON p.id = i.product_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Product Inventory</h1>
    <h2>Product List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
            <th>Total Price</th>
            
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
