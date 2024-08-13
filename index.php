<?php
include './includes/db.php';
require './includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="./css/db.css">
    <title>Dashboard</title>
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
    
</head>
<body>
    

    <main>
    <p id="p-id" class="p-class">Dashboard Overview</p>
    <div class="dashboardd">
        <section class="dashboard-overview">
            
            <div class="dashboard-cards">
                <div class="card" id="card1">
                    <a  href="./products.php"><h2>Total Products</h2></a>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM products");
                    $data = $result->fetch_assoc();
                    echo "<p>{$data['total']}</p>";
                    ?>
                </div>
                <div class="card" id="card2">
                    <a href="./sales.php"><h2>Total Sales</h2></a>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM sales");
                    $data = $result->fetch_assoc();
                    echo "<p>{$data['total']}</p>";
                    ?>
                </div>
                <div class="card" id="card3" >
                    <a href="./employee.php"><h2>Total Employees</h2></a>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM employees");
                    $data = $result->fetch_assoc();
                    echo "<p>{$data['total']}</p>";
                    ?>
                </div>
                <div class="card" id="card4">
                    <a href="./supplier.php"><h2>Total Suppliers</h2></a>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM suppliers");
                    $data = $result->fetch_assoc();
                    echo "<p>{$data['total']}</p>";
                    ?>
                </div>
            </div>
        </section>
        </div>
        </div>
    </main>

    
</body>
</html>
