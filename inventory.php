<?php
include './includes/db.php';
require "./includes/header.php";





// Display products and their profits
$sql = "SELECT p.*, (p.quantity * p.price) AS total_price, i.quantity AS inventory_quantity, COALESCE(SUM(pr.profit), 0) AS total_profit 
        FROM products p 
        LEFT JOIN inventory i ON p.id = i.product_id
        LEFT JOIN profits pr ON p.id = pr.product_id
        GROUP BY p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Inventory</title>
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
</head>
<body>
    <h1>Product Inventory</h1>
    <h2>Product List</h2>
    <div class="table-center">
        <table border="1">
            <tr>
                <th>P_ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Description</th>
                <th>Total Price</th>
                <th>Total Profit</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td><?php echo $row['total_profit']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
