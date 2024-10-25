<?php
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Enkripsi password

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header('Location: Admin/admin_dashboard.php');
        } else {
            header('Location: Users/user_dashboard.php');
        }
        exit();
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('Assets/bg.png') no-repeat center center fixed;
            background-size: cover; /* Cover the entire page */
        }

        .blurred-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px); /* Apply blur effect */
            z-index: 1; /* Behind the form */
        }

        .login-container {
            max-width: 700px; /* Increase max width */
            padding: 3rem; /* Increase padding */
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            border-radius: 1rem; /* Rounded corners */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); /* Enhanced shadow effect */
            position: relative;
            z-index: 2; /* In front of the background */
        }

        .login-container h2 {
            font-size: 2rem; /* Increase heading font size */
        }

        .login-container .form-label {
            font-size: 1.1rem; /* Increase form label font size */
        }

        .login-container .form-control {
            font-size: 1rem; /* Increase input font size */
        }

        .login-container .btn {
            font-size: 1.2rem; /* Increase button font size */
            padding: 0.5rem; /* Add padding for the button */
        }
    </style>
</head>
<body>

<div class="blurred-background"></div>

<div class="login-container">
    <h2 class="text-center">Login</h2>

    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_message; ?>
        </div>
    <?php } ?>

    <form method="POST" action="">
        <div class="mb-4">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
    
    
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
