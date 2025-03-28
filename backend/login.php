<?php
session_start();
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header('Location: homepage.php');
            exit();
        } else {
            echo "<p class='error'>Invalid password.</p>";
        }
    } else {
        echo "<p class='error'>No account found with that email.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Shelfy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-login {
            background: linear-gradient(90deg, #ff8c00, #ff4500);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #ff4500, #ff8c00);
        }

        .register-link {
            color: #ff8c00;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link:hover {
            color: #ff4500;
        }

        .error {
            color: #ff4c4c;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="mb-4">Login to <span style="background: linear-gradient(90deg, #ff8c00, #ff4500); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Shelfy</span></h2>
    <form method="post">
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
</div>

</body>
</html>
