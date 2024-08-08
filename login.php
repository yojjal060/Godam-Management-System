<?php
session_start();
include './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password === $row['password']) { // Plain text comparison
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>



<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<div class="login-container">
<div class="blur"></div>
<div class="container">
    <div class="content">
        <img src="./concept-art/logo.png" alt="logo" width="60" height="60">
      <form class="content__form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <div class="content__inputs">
          <label>
            <input required="" type="text" name="username">
            <span>Phone number, username, or email</span>
          </label>
          <label>
            <input required="" type="password" name="password">
            <span>Password</span>
          </label>
        </div>
        <button>Log In</button>
      </form>
    
    </div>
  </div>
</div>
</body>
</html>