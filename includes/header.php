<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
include('includes/db.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
    <script src="../js-files/Toggle.js" defer></script>
    <script src="./markdown.js"></script>
    
    
</head>
<body>
    <nav>
        <img src="./concept-art/logo.png" alt="logo" width="60" height="60" class="logo" id="logo">
        
        <ul class="nav-links">
        <li><a href="./index.php">Dashboard</a></li>
        <li class="center"><a href="./employee.php">Employee</a></li>
        <li class="upward"><a href="./products.php">Product</a></li>
        <li class="forward"><a href="./inventory.php">Inventory</a></li>
        <li class="center"><a href="./sales.php">Sales</a></li>
        <li class="upward"><a href="./supplier.php">Suppliers</a></li>
  </ul>
     <img style="border-radius: 25px;" class="profile-photo" src="./concept-art/profile-removebg-preview.png" alt="profile photo" width="50" height="50" id="profile-photo">
    </nav>

    <div id="markdown-container" class="markdown-container" style="display: none;">
        <div class="content-markdown">
            <img src="./concept-art/logout-box-icon.svg" alt="SVG Image" width="20" height="20">
            <a href="./logout.php">Logout</a>
        </div>
    </div>