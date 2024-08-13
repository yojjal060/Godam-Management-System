<?php

require "./includes/header.php";
include './includes/db.php';
// Ensure the inventory table exists
$sql = "CREATE TABLE IF NOT EXISTS inventory (
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
$conn->query($sql);

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete related sales records first
    $sql = "DELETE FROM sales WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Delete the product from inventory first
    $sql = "DELETE FROM inventory WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Delete the product
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }
}


if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE products SET name=?, quantity=?, price=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sidsi', $name, $quantity, $price, $description, $id);
    if ($stmt->execute()) {
        // Update the inventory quantity
        $sql = "UPDATE inventory SET quantity=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $quantity, $id);
        if($stmt->execute()){
            header("Location: products.php");
        }
        echo "Product updated successfully.";
        
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "INSERT INTO products (name, quantity, price, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sids', $name, $quantity, $price, $description);
    if ($stmt->execute()) {
        // Get the last inserted product id
        $product_id = $stmt->insert_id;
        
        // Insert into inventory
        $sql = "INSERT INTO inventory (product_id, quantity) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $product_id, $quantity);
        $stmt->execute();
        
        
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Display products
$sql = "SELECT p.*, (p.quantity * p.price) AS total_price, i.quantity AS inventory_quantity FROM products p LEFT JOIN inventory i ON p.id = i.product_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Product</title>
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
</head>
<body>
    <h1>Manage Products</h1>
    <div class="form-container">
    <h2>Add New Product</h2>
    <form method="post" action="">
        Name: <input type="text" name="name" required>
        Quantity: <input type="number" name="quantity" required>
        Price: <input type="text" name="price" required>
        Description: <textarea name="description"></textarea>
        <input type="submit" name="add" value="Add Product">
    </form>
    </div>

    <h2>Product List</h2>
    <table border="1">
        <tr>
            <th>P_ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <td style="border-bottom: none; border-left: none;" class="actions" >
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])): ?>
        <?php
        $id = $_GET['edit'];
        $sql = "SELECT * FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        ?>
        
        <div class="form-container">
        <h2>Edit Product</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            Name: <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            Quantity: <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
            Price: <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
            Description: <textarea name="description"><?php echo $product['description']; ?></textarea>
            <input type="submit" name="edit" value="Update Product">
        </form>
        </div>
    <?php endif; ?>
</body>
</html>
