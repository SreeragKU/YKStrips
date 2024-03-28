<?php
// Define the correct username and password
$correctUsername = 'ykstrip';
$correctPassword = 'Ykstrip!20';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered username and password
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // Check if the entered credentials are correct
    if ($enteredUsername === $correctUsername && $enteredPassword === $correctPassword) {
        // Generate a unique token (you can use a more secure method)
        $token = bin2hex(random_bytes(16));

        // Store the token in the local storage
        echo "<script>
                localStorage.setItem('token', '$token');
                window.location.href = 'viewall.php';
              </script>";
        exit;
    } else {
        $errorMessage = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        input {
            margin-bottom: 15px;
            padding: 12px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            outline: none;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff3333;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="img/logo.png" alt="Logo" style="max-width: 100%;">
        </div>
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <p class="error-message"><?= $errorMessage; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>