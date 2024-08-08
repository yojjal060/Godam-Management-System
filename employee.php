<?php
 require './includes/header.php';



// Handle employee deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM employees WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
     
}

// Handle employee editing
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];

    $sql = "UPDATE employees SET first_name=?, last_name=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $first_name, $last_name, $role, $id);
    if ($stmt->execute()) {
        echo "Employee updated successfully.";
        header("Location: employee.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle employee addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];

    $sql = "INSERT INTO employees (first_name, last_name, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $first_name, $last_name, $role);
    $stmt->execute();
}

// Display employees
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>Employee</title>
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
</head>
<body>
    <h1>Manage Employees</h1>
    <div class="form-container">
    <h2>Add New Employee</h2>
    <form method="post" action="">
        First Name: <input type="text" name="first_name" required>
        Last Name: <input type="text" name="last_name" required>
        Role: <input type="text" name="role" required>
        <input type="submit" name="add" value="Add Employee">
    </form>
    </div>
    <h2>Employee List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td class="actions">
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])): ?>
        <?php
        $id = $_GET['edit'];
        $sql = "SELECT * FROM employees WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();
        ?>
        <div class="form-container">
        <h2>Edit Employee</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
            First Name: <input type="text" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
            Last Name: <input type="text" name="last_name" value="<?php echo $employee['last_name']; ?>" required>
            Role: <input type="text" name="role" value="<?php echo $employee['role']; ?>" required>
            <input type="submit" name="edit" value="Update Employee">
        </form>
        </div>
    <?php endif; ?>
</body>
</html>
