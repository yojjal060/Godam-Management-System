<?php
require "./includes/header.php";
// Ensure the suppliers table exists
$sql = "CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    province VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
)";
$conn->query($sql);

// Handle supplier addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_supplier'])) {
    $company_name = $_POST['company_name'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO suppliers (company_name, province, city, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $company_name, $province, $city, $phone_number);
    if ($stmt->execute()) {
        echo "Supplier added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle supplier deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM suppliers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo "Supplier deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle supplier editing
if (isset($_POST['edit_supplier'])) {
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];

    $sql = "UPDATE suppliers SET company_name=?, province=?, city=?, phone_number=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $company_name, $province, $city, $phone_number, $id);
    if($stmt->execute()){
        header("Location: supplier.php");
    };
    
}

// Display suppliers
$supplier_sql = "SELECT * FROM suppliers";
$supplier_result = $conn->query($supplier_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Suppliers</h1>
    <div class="form-container">
    <h2>Add New Supplier</h2>
    <form method="post" action="">
        Company Name: <input type="text" name="company_name" required>
        Province: <input type="text" name="province" required>
        City: <input type="text" name="city" required>
        Phone Number: <input type="text" name="phone_number" required>
        <input type="submit" name="add_supplier" value="Add Supplier">
    </form>
    </div>

    <h2>Supplier List</h2>
    <table border="1">
        <tr>
            <th>Company Name</th>
            <th>Province</th>
            <th>City</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $supplier_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['company_name']; ?></td>
            <td><?php echo $row['province']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $row['phone_number']; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])): ?>
        <?php
        $id = $_GET['edit'];
        $sql = "SELECT * FROM suppliers WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $supplier = $result->fetch_assoc();
        ?>
        <div class="form-container">
        <h2>Edit Supplier</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>">
            Company Name: <input type="text" name="company_name" value="<?php echo $supplier['company_name']; ?>" required>
            Province: <input type="text" name="province" value="<?php echo $supplier['province']; ?>" required>
            City: <input type="text" name="city" value="<?php echo $supplier['city']; ?>" required>
            Phone Number: <input type="text" name="phone_number" value="<?php echo $supplier['phone_number']; ?>" required>
            <input type="submit" name="edit_supplier" value="Update Supplier">
        </form>
    </div>
    <?php endif; ?>
</body>
</html>
