<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventory_system";

//connection banauni
$conn = new mysqli($servername, $username, $password, $dbname);

//connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
