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

// Check if the package ID is provided in the URL
if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Prepare and execute the SQL DELETE query
    $sql = "DELETE FROM PackageDetails WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $packageId);

    if ($stmt->execute()) {
        // Redirect back to viewall.php after successful deletion
        header("Location: viewall.php");
        exit();
    } else {
        echo "Error deleting package: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Package ID not provided.";
}
