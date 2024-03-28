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
// Include database connection file (conn.php)
include 'conn.php';

// Function to get packages from the database
function get_packages() {
    global $conn;
    $query = "SELECT id, package_name FROM packagedetails";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to get images for a specific package
function get_images($package_id) {
    global $conn;
    $query = "SELECT id, image_name FROM gallery WHERE package_id = $package_id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to insert a new image into the database and handle duplicates
function insert_image($package_id, $image_name) {
    global $conn;

    // Check if the image already exists for the package
    $check_query = "SELECT id FROM gallery WHERE package_id = $package_id AND image_name = '$image_name'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert new image if it doesn't exist
        $insert_query = "INSERT INTO gallery (package_id, image_name) VALUES ($package_id, '$image_name')";
        mysqli_query($conn, $insert_query);
        return "Image uploaded successfully.";
    } else {
        return "Duplicate image. Please choose a different image.";
    }
}

// Function to delete an image from the database and directory
function delete_image($image_id, $image_name) {
    global $conn;
    // Delete image from the database
    $delete_query = "DELETE FROM gallery WHERE id = $image_id";
    mysqli_query($conn, $delete_query);

    // Delete image from the directory
    $image_path = "pack_img/" . $image_name;
    unlink($image_path);

    return "Image deleted successfully.";
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['package_select'])) {
        $selected_package_id = $_POST['package_select'];
        $images = get_images($selected_package_id);
    } elseif (isset($_POST['upload_image'])) {
        $selected_package_id = $_POST['selected_package'];
        $image_name = $_FILES['new_image']['name'];
        $temp_image = $_FILES['new_image']['tmp_name'];

        // Upload image to the directory
        move_uploaded_file($temp_image, "pack_img/" . $image_name);

        // Insert image into the database
        $upload_message = insert_image($selected_package_id, $image_name);

        // Refresh images list
        $images = get_images($selected_package_id);
    } elseif (isset($_POST['delete_image'])) {
        $image_id = $_POST['image_id'];
        $image_name = $_POST['image_name'];

        // Delete image from the database and directory
        $delete_message = delete_image($image_id, $image_name);

        // Refresh images list
        $selected_package_id = $_POST['selected_package'];
        $images = get_images($selected_package_id);
    }
}
function get_package_name($package_id) {
    global $conn;
    $query = "SELECT package_name FROM packagedetails WHERE id = $package_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['package_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        h2,
        h3 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="file"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        p {
            color: #333;
            text-align: center;
        }
    </style>
</head>

<body>
    
<?php include "dashboard.php"; ?>
    <div id="content">
        <h2 style="text-align: center;">Package Gallery</h2>

        <!-- Package selection dropdown -->
        <form method="POST" action="">
            <label for="package_select">Select a package:</label>
            <select name="package_select" id="package_select">
                <option value="" disabled selected>Select a package</option>
                <?php
                $packages = get_packages();
                while ($row = mysqli_fetch_assoc($packages)) {
                    echo "<option value='{$row['id']}'>{$row['package_name']}</option>";
                }
                ?>
            </select>
            <button type="submit">Submit</button>
        </form>

        <?php
        if (isset($selected_package_id)) {
            $selected_package_name = get_package_name($selected_package_id);

            // Display images for the selected package
            echo "<h3 style='text-align: center;'>Images from $selected_package_name</h3>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Image</th><th>Image Name</th><th>Delete</th></tr>";
            while ($image_row = mysqli_fetch_assoc($images)) {
                echo "<tr>";
                echo "<td>{$image_row['id']}</td>";
                echo "<td><img src='pack_img/{$image_row['image_name']}' alt='Image Preview'></td>";
                echo "<td>{$image_row['image_name']}</td>";
                echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='selected_package' value='$selected_package_id'>
                            <input type='hidden' name='image_id' value='{$image_row['id']}'>
                            <input type='hidden' name='image_name' value='{$image_row['image_name']}'>
                            <button type='submit' name='delete_image'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";

            // Upload new image form
            echo "<h3 style='text-align: center;'>Upload New Image:</h3>";
            echo "<form method='POST' action='' enctype='multipart/form-data' style='text-align: center;'>
                    <input type='hidden' name='selected_package' value='$selected_package_id'>
                    <label for='new_image'>Select image to upload:</label>
                    <input type='file' name='new_image' id='new_image' accept='image/*' required>
                    <button type='submit' name='upload_image'>Upload Image</button>
                  </form>";

            if (isset($upload_message)) {
                echo "<p style='text-align: center;'>$upload_message</p>";
            }

            // Delete image message
            if (isset($delete_message)) {
                echo "<p style='text-align: center;'>$delete_message</p>";
            }
        }
        ?>
    </div>
</body>

</html>

