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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
    // Check if the form is submitted
    $updatedStatus = isset($_POST['trending']) ? $_POST['trending'] : [];

    // Fetch all packages from the database
    $sql = "SELECT id, trending FROM packagedetails";
    $result = $conn->query($sql);
    $packageStatus = [];
    while ($row = $result->fetch_assoc()) {
        $packageStatus[$row['id']] = $row['trending'];
    }

    // Update the trending status in the database for checked packages
    foreach ($updatedStatus as $id => $status) {
        // Sanitize inputs to prevent SQL injection
        $id = intval($id);

        // Update the trending status in the database for checked packages
        $updateSql = "UPDATE packagedetails SET trending = 1 WHERE id = $id";
        $conn->query($updateSql);

        // Remove checked package from the array to identify unchecked packages later
        unset($packageStatus[$id]);
    }

    // Identify previously true packages that are now unchecked
    foreach ($packageStatus as $id => $status) {
        // Sanitize inputs to prevent SQL injection
        $id = intval($id);

        // Update the trending status in the database for previously true packages that are now unchecked
        $updateSql = "UPDATE packagedetails SET trending = 0 WHERE id = $id";
        $conn->query($updateSql);
    }

    // Redirect to the same page after updating
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCategory'])) {
    $updatedCategories = isset($_POST['category']) ? $_POST['category'] : [];

    foreach ($updatedCategories as $id => $categoryId) {
        // Sanitize inputs to prevent SQL injection
        $id = intval($id);
        $categoryId = ($categoryId !== '') ? intval($categoryId) : null;

        // Update the category in the database for the specified package
        $updateCategorySql = "UPDATE packagedetails SET category_id = " . ($categoryId !== null ? $categoryId : "NULL") . " WHERE id = $id";
        $conn->query($updateCategorySql);
    }

    // Redirect to the same page after updating
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Fetch categories from the "categories" table
$categorySql = "SELECT id, category_name FROM categories";
$categoryResult = $conn->query($categorySql);
$categories = [];
while ($categoryRow = $categoryResult->fetch_assoc()) {
    $categories[$categoryRow['id']] = $categoryRow['category_name'];
}

// Fetch all packages from the database
$sql = "SELECT * FROM packagedetails";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View All Packages</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            background-color: #fff;
            border-radius: 5px;
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
        .delete-btn {
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

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .no-packages {
            text-align: center;
            font-style: italic;
            color: #555;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        #search {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #update-btn {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #update-btn:hover {
            background-color: #45a049;
        }

        .tab-content {
            display: none;
        }

        .active-tab {
            display: block;
        }

        .tab-btn {
            cursor: pointer;
        }

        #details-tab .table-container {
            max-height: 600px;
            overflow-y: auto;
        }

        #details-tab table td:nth-child(3),
        #details-tab table td:nth-child(5) {
            max-width: 800px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <script>
        function showTab(tabName) {
            const tabContent = document.querySelectorAll('.tab-content');
            const tabButtons = document.querySelectorAll('.tab-btn');

            for (let i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active-tab");
            }

            for (let i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }

            const selectedTab = document.getElementById(tabName + '-tab');
            selectedTab.classList.add("active-tab");

            for (let i = 0; i < tabButtons.length; i++) {
                if (tabButtons[i].getAttribute("onclick").includes(tabName)) {
                    tabButtons[i].classList.add("active");
                    break;
                }
            }
        }
    </script>
</head>

<body>
<?php include "dashboard.php"; ?>

    <div id="content">
        <div class="container">
            <form method="post" action="">
                <h2 class="text-center text-dark mb-4">View All Packages</h2>
                <div class="search-bar">
                    <label for="search">Search by Package Name:</label>
                    <input type="text" id="search" oninput="filterPackages()" placeholder="Enter package name..." class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" id="update-btn" name="updateStatus" value="Update Trending" class="btn btn-success">
                    <div id="status-update-msg"></div>
                </div>
                <div class="mb-3">
                    <input type="submit" id="update-category-btn" name="updateCategory" value="Update Destination" class="btn btn-primary">
                    <div id="category-update-msg"></div>
                </div>


                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link tab-btn active" onclick="showTab('general')">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-btn" onclick="showTab('details')">Details</a>
                    </li>
                </ul>

                <!-- General Tab Content -->
                <div id="general-tab" class="tab-content active-tab">
                    <div class="table-container">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Package Name</th>
                                    <th>Package Description</th>
                                    <th>Package Price</th>
                                    <th>Discount Price</th>
                                    <th>No. of Days</th>
                                    <th>Package Image</th>
                                    <th>Destination</th>
                                    <th>Trending</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["package_name"] . "</td>";
                                        echo "<td>" . $row["package_description"] . "</td>";
                                        echo "<td>" . $row["package_price"] . "</td>";
                                        echo "<td>" . $row["discount_price"] . "</td>";
                                        echo "<td>" . $row["no_of_days"] . "</td>";
                                        echo "<td><img src='" . $row["package_image"] . "' alt='Package Image'></td>";
                                        echo "<td><select name='category[" . $row["id"] . "]'>";
                                        echo "<option value='' " . (empty($row["category_id"]) ? "selected" : "") . ">Select a Category</option>";
                                        foreach ($categories as $categoryId => $categoryName) {
                                            echo "<option value='$categoryId'";
                                            echo isset($row["category_id"]) && $row["category_id"] == $categoryId ? " selected" : "";
                                            echo ">$categoryName</option>";
                                        }
                                        echo "</select></td>";
                                        echo "<td><input type='checkbox' name='trending[" . $row["id"] . "]' ";
                                        echo $row["trending"] ? "checked" : "";
                                        echo "></td>";
                                        echo "<td>
                                        <a href='editpackage.php?id=" . $row["id"] . "' title='Edit'><i class='fas fa-edit'></i></a>
                                        <a href='deletepackage.php?id=" . $row["id"] . "' title='Delete'><i class='fas fa-trash-alt'></i></a>
                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11' class='no-packages'>No packages available</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Details Tab Content -->
<div id="details-tab" class="tab-content">
    <div class="table-container">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Package Name</th>
                    <th>Overview</th>
                    <th>Accommodation</th>
                    <th>Meals</th>
                    <th>Transportation</th>
                    <th>Locations</th>
                    <th>Highlight</th>
                    <th>Itinerary</th>
                    <th>Cost Includes</th>
                    <th>Cost Excludes</th>
                    <th>FAQs</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the pointer of the result set to the beginning
                $result->data_seek(0);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["package_name"] . "</td>";
                    echo "<td>" . $row["overview"] . "</td>";
                    echo "<td>" . $row["accommodation"] . "</td>";
                    echo "<td>" . $row["meals"] . "</td>";
                    echo "<td>" . $row["transportation"] . "</td>";
                    echo "<td>" . implode(",<br>", explode(",", $row["locations"])) . "</td>";
                    echo "<td>" . implode(",<br>", explode(",", $row["highlight"])) . "</td>";

                    // Unserialize the stored arrays
                    $itinerary = unserialize($row["itinerary"]);
                    $faqs = unserialize($row["faqs"]);

                    // Convert arrays to readable format (you may need to adjust this based on your data structure)
                    $itineraryText = "<ul>";
                    foreach ($itinerary as $index => $day) {
                        $dayNumber = $index + 1;
                        $itineraryText .= "<li><strong>Day $dayNumber:</strong> " . $day['title'] . "<br>Description: " . $day['description'] . "</li>";
                    }
                    $itineraryText .= "</ul>";

                    echo "<td>" . $itineraryText . "</td>";
                    echo "<td>" . implode(",<br>", explode(",", $row["cost_includes"])) . "</td>";
                    echo "<td>" . implode(",<br>", explode(",", $row["cost_excludes"])) . "</td>";
                    echo "<td>";
                    foreach ($faqs as $faq) {
                        echo "Q: " . $faq['question'] . "<br>A: " . $faq['answer'] . "<br>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


            </form>
        </div>
    </div>

    <script>

        document.getElementById('update-category-btn').addEventListener('click', function() {
            // Perform any additional client-side validations if needed

            // Submit the form
            document.forms[0].submit();
        });



        function logout() {
            localStorage.removeItem('token');
            window.location.href = 'login.php';
        }

        function filterPackages() {
            const input = document.getElementById('search').value.toUpperCase();
            const activeTab = document.querySelector('.tab-content.active-tab');
            const table = activeTab.querySelector('table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const nameColumn = rows[i].getElementsByTagName('td')[1];
                if (nameColumn) {
                    const packageName = nameColumn.textContent || nameColumn.innerText;
                    if (packageName.toUpperCase().indexOf(input) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>

</html>