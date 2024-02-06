<?php
include 'conn.php';

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

// Check if the form is submitted for adding or updating categories
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addCategory'])) {
        // Process the form for adding a new category
        $categoryName = $_POST['categoryName'];
        // Insert the new category into the database
        $insertSql = "INSERT INTO categories (category_name) VALUES ('$categoryName')";
        $conn->query($insertSql);
    } elseif (isset($_POST['updateCategory'])) {
        // Process the form for updating an existing category
        $categoryId = $_POST['categoryId'];
        $newCategoryName = $_POST['newCategoryName'];

        // Update the category in the database
        $updateSql = "UPDATE categories SET category_name = '$newCategoryName' WHERE id = $categoryId";
        $conn->query($updateSql);
    } elseif (isset($_POST['deleteCategory'])) {
        // Process the form for deleting an existing category
        $categoryId = $_POST['categoryId'];

        // Delete the category from the database
        $deleteSql = "DELETE FROM categories WHERE id = $categoryId";
        $conn->query($deleteSql);
    } elseif (isset($_POST['uploadIcon'])) {
        // Process the form for uploading an icon
        $categoryId = $_POST['categoryId'];

        // Handle file upload
        $uploadDir = 'icons/';
        $uploadFile = $uploadDir . basename($_FILES['icon']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Check if the file already exists in the directory
        if (file_exists($uploadFile)) {
            echo "<script>alert('File with the same name already exists. Please choose a different file.');</script>";
        } else {
            // If it doesn't exist, move the uploaded file to the directory
            if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadFile)) {
                // Update the database with the new path
                $updateSql = "UPDATE categories SET icon_path = '$uploadFile' WHERE id = $categoryId";
                $conn->query($updateSql);
            } else {
                echo "Error uploading file.";
            }
        }
    }
}

// Fetch all categories from the database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Destination</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            width: 1200px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .edit-btn,
        .delete-btn,
        .btn-file {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #4caf50;
            color: #fff;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #ff3333;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #e52424;
        }

        .btn-file {
            background-color: #3498db;
            color: #fff;
        }

        .btn-file:hover {
            background-color: #2980b9;
        }

        .category-form {
            margin-top: 20px;
        }

        .category-form label {
            font-weight: bold;
        }

        .category-form input {
            margin-bottom: 10px;
        }

        .category-table {
            margin-top: 20px;
        }

        .category-table th,
        .category-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .category-table th {
            background-color: #4caf50;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="logo mb-4 text-center">
            <img src="img/logo.png" alt="Logo" class="img-fluid rounded">
        </div>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewall.php">View All Packages</a>
        <a href="addpackage.php">Add New Package</a>
        <a href="categories.php">Manage Destination</a>
        <a href="#" onclick="logout()">Logout</a>
    </div>

    <div id="content">
        <div class="container">
            <h2 class="text-center text-dark mb-4">Manage Destination</h2>

            <!-- Category Form -->
            <form method="post" action="" class="category-form">
                <div class="form-group">
                    <label for="categoryName">Destination Name:</label>
                    <input type="text" id="categoryName" name="categoryName" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="addCategory" value="Add Destination" class="btn btn-success">
                </div>
            </form>

            <!-- Category Table -->
            <div class="category-table">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Destination Name</th>
                            <th>Icon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["category_name"] . "</td>";
                                echo "<td>";
                                if (!empty($row["icon_path"])) {
                                    echo "<img src='" . $row["icon_path"] . "' alt='Icon' class='img-fluid rounded' style='max-width: 350px; max-height: 100px;'>";
                                } else {
                                    echo "No Icon";
                                }
                                echo "</td>";
                                echo "<td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='categoryId' value='" . $row["id"] . "'>
                                        <input type='text' name='newCategoryName' placeholder='New Name' required class='form-control mb-2'>
                                        <button type='submit' name='updateCategory' class='btn btn-primary edit-btn'>Update</button>
                                    </form>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='categoryId' value='" . $row["id"] . "'>
                                        <button type='submit' name='deleteCategory' class='btn btn-danger delete-btn'>Delete</button>
                                    </form>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='categoryId' value='" . $row["id"] . "'>
                                        <input type='file' name='icon' accept='image/*' style='display: none;' id='fileInput_" . $row["id"] . "'> <!-- Unique ID for each row -->
                                        <label for='fileInput_" . $row["id"] . "' class='btn btn-info btn-file'>Upload Icon</label>
                                        <button type='submit' name='uploadIcon' class='btn btn-info' style='display: none;'></button>
                                    </form>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='no-categories'>No categories available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[id^="fileInput_"]').forEach(function(fileInput) {
            fileInput.addEventListener('change', function() {
                this.form.querySelector('[type="submit"]').click();
            });
        });
    </script>
</body>

</html>