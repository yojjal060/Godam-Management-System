<?php

require "./includes/header.php";
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;

    // Check if the product_id exists in the products table and get the current quantity
    $sql = "SELECT quantity FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_quantity);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if ($current_quantity >= $quantity) {
            // Insert the sale with price
            $sql = "INSERT INTO sales (product_id, quantity, price, total_price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iidd', $product_id, $quantity, $price, $total_price);
            if ($stmt->execute()) {
                // Update the product quantity
                $new_quantity = $current_quantity - $quantity;
                $sql = "UPDATE products SET quantity=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $new_quantity, $product_id);
                $stmt->execute();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            $error_message = "Insufficient Quantity";
        }
    } else {
        echo "Error: Product ID does not exist.";
    }
}
?>
<div class="form-container">
<form method="post" action="">
    Product ID: <input type="number" name="product_id" required>
    Quantity: <input type="number" name="quantity" required>
    Price: <input type="text" name="price" required>
    <input type="submit" value="Record Sale">
</form>
<h3 class="error-message"><?php echo "$error_message"; ?></h3>
</div>

<h2>Sales History</h2>
<?php
$sql = "SELECT * FROM sales";
$result = $conn->query($sql);
if ($result->num_rows > 0) {?>
    <table border="1">
        <tr>
            <th>P_ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['product_id']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <td><?php echo $row['date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table><?php
} else {
    echo "No sales found.";
}
?>
