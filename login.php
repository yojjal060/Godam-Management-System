<?php
session_start();
include './includes/db.php';

$username_error = "";
$password_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = sha1($password); 

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if ($hashed_password === $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            header('Location: index.php');
            exit();
        } else {
            $password_error = "Invalid password.";
        }
    } else {
        $username_error = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="./concept-art/logo.png" type="image/png">
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
        
            <input required="" type="text" name="username" class="login-username">
            <span>Phone number, username, or email</span>
          </label>
          <label class="password-label">
            <input required="" type="password" name="password" class="login-password">
            <span>Password</span>
          </label>
        </div>
        <button>Log In</button>
        
      </form>
      <h3 class="error-message"><?php echo "$username_error"; ?></h3>
      <h3 class="error-message"><?php echo "$password_error"; ?></h3>
    
    </div>
  </div>
</div>
</body>
</html>