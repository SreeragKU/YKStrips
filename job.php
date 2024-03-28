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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    
    // Fetch the record to get the resume path
    $fetchSql = "SELECT * FROM job_applications WHERE id = $deleteId";
    $fetchResult = $conn->query($fetchSql);

    if ($fetchResult->num_rows > 0) {
        $row = $fetchResult->fetch_assoc();
        $resumePath = $row['resume_path'];

        // Perform delete operation in the database
        $deleteSql = "DELETE FROM job_applications WHERE id = $deleteId";
        $conn->query($deleteSql);

        // Remove the file from the CV directory
        if (file_exists($resumePath)) {
            unlink($resumePath);
        }

        // Redirect back to the page with the updated table
        header("Location: job.php");
        exit();
    }
}

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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Job Candidates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        #content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php
    include 'dashboard.php';
    include "conn.php";

    // Display data in the table
    $sql = "SELECT * FROM job_applications";
    $result = $conn->query($sql);
    ?>

    <div id="content" style="margin-left: 350px;">
        <h2>Job Candidates</h2>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Resume</th>
                <th>Submission Date</th>
                <th>Action</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['full_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td><a href='" . $row['resume_path'] . "' target='_blank'>Open Resume</a></td>";
                echo "<td>" . $row['submission_date'] . "</td>";
                echo "<td>
                    <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this record?\")'>
                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>

</html>
