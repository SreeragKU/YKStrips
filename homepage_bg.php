<!-- Homepage_bg.php -->
<?php
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Background Image Upload</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 300px;
            margin-right: 80px;
        }

        form {
            margin-top: 20px;
        }

        #preview-container {
            display: none;
        }

        #preview {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        #delete-btn {
            margin-top: 20px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        #existing-images {
            margin-top: 30px;
        }

        #existing-images table {
            width: 100%;
            border-collapse: collapse;
        }

        #existing-images th,
        #existing-images td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #existing-images img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        #existing-images a {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }
        
    </style>
</head>

<body>

    <?php include "dashboard.php"; ?>

    <div id="container">
        <?php
        include('conn.php');

        // Delete Image
        if (isset($_GET['delete']) && !empty($_GET['delete'])) {
            $deleteId = $_GET['delete'];

            // Fetch image path from the database
            $sql = "SELECT image_path FROM background_images WHERE id = $deleteId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $imagePathToDelete = $row['image_path'];

                // Delete record from the database
                $deleteSql = "DELETE FROM background_images WHERE id = $deleteId";
                if ($conn->query($deleteSql) === TRUE) {
                    // Delete image file
                    if (file_exists($imagePathToDelete)) {
                        unlink($imagePathToDelete);
                        echo "Image deleted successfully.";
                    } else {
                    }
                } else {
                    echo "Error deleting image from the database: " . $conn->error;
                }
            } else {
            }
        }

        // Upload Image
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $targetDirectory = 'homepage_img/';
            $targetFile = $targetDirectory . basename($_FILES['image']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false) {
                echo 'File is an image - ' . $check['mime'] . '.';
                $uploadOk = 1;
            } else {
                echo 'File is not an image.';
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                echo 'Sorry, file already exists.';
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['image']['size'] > 50000000) {
                echo 'Sorry, your file is too large.';
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
                echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo 'Sorry, your file was not uploaded.';
            } else {
                // If everything is ok, try to upload the file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // File uploaded successfully, store data in the database
                    $imagePath = $targetFile;
                    $sql = "INSERT INTO background_images (image_path) VALUES ('$imagePath')";
                    if ($conn->query($sql) === TRUE) {
                        echo 'Image uploaded and stored in the database successfully.';
                    } else {
                        echo 'Error storing image in the database: ' . $conn->error;
                    }
                } else {
                    echo 'Sorry, there was an error uploading your file.';
                }
            }
        }

        // Fetch and display all images from the database
        $sql = "SELECT id, image_path FROM background_images";
        $result = $conn->query($sql);

        ?>
        <h2>Upload Background Image</h2>
        <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
            Select image to upload:
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this);">
            <br>
            <input type="submit" value="Upload Image" name="submit" class="btn btn-primary" id="submitBtn" disabled>
        </form>

        <h3>Preview:</h3>
        <div id="preview-container">
            <img id="preview" src="#" alt="Uploaded Image">
        </div>

        <?php
        // Fetch and display all images from the database
        $sql = "SELECT id, image_path FROM background_images";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<h2>Existing Background Images</h2>';
            echo '<div id="existing-images">';
            echo '<table>';
            echo '<tr><th>Image</th><th>Delete</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . $row['image_path'] . '" alt="Background Image"></td>';
                echo '<td><a href="?delete=' . $row['id'] . '">Delete Image</a></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No background images found.</p>';
        }
        ?>

    </div>

</body>
<script>
    function previewImage(input) {
        var preview = document.getElementById('preview');
        var previewContainer = document.getElementById('preview-container');
        var submitBtn = document.getElementById('submitBtn');

        // Hide the preview container if no file is selected
        if (input.files.length === 0) {
            previewContainer.style.display = 'none';
            submitBtn.disabled = true;
            return;
        }

        // Show the preview container, update the preview image, and enable the submit button
        previewContainer.style.display = 'block';
        preview.src = URL.createObjectURL(input.files[0]);
        submitBtn.disabled = false;
    }
</script>


</html>