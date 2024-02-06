<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
        }

        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: #fff;
            padding-top: 20px;
            position: fixed;
        }

        .logo {
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        #sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            color: #fff;
            display: block;
            transition: background-color 0.3s;
        }

        #sidebar a:hover {
            background-color: #555;
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        h2 {
            color: #333;
        }
    </style>
</head>

<body>

    <?php
    // Check if the token exists in the local storage
    echo "<script>
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = 'login.php';
            }

            function logout() {
                localStorage.removeItem('token');
                window.location.href = 'login.php';
            }
          </script>";
    ?>

    <div id="sidebar">
        <div class="logo">
            <img src="img/logo.png" alt="Logo" style="max-width: 100%;">
        </div>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewall.php">View All Packages</a>
        <a href="addpackage.php">Add New Package</a>
        <a href="categories.php">Manage Destination</a>
        <a href="#" onclick="logout()">Logout</a>
        <!-- Add more links as needed -->
    </div>

    <div id="content">
        <h2>Welcome to the Dashboard</h2>
        <!-- Add content specific to your dashboard here -->
    </div>
</body>

</html>