<?php
include 'conn.php';

// Check if an ID is provided in the query string
if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Fetch package details from the database
    $sql = "SELECT * FROM PackageDetails WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $packageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Deserialize arrays
        $itinerary = unserialize($row['itinerary']);
        $faqs = unserialize($row['faqs']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Package Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Add your styling here */
    </style>
</head>

<body>
    <div class="container">
        <h2>View Package Details</h2>

        <!-- Display general information -->
        <h3>General Information</h3>
        <p>Package Name: <?php echo $row['package_name']; ?></p>
        <!-- Display other general fields -->

        <!-- Display itinerary -->
        <h3>Itinerary</h3>
        <?php foreach ($itinerary as $day): ?>
            <p>Day <?php echo $day['title']; ?>: <?php echo $day['description']; ?></p>
        <?php endforeach; ?>

        <!-- Display cost information -->
        <h3>Cost Information</h3>
        <p>Cost Includes: <?php echo $row['cost_includes']; ?></p>
        <p>Cost Excludes: <?php echo $row['cost_excludes']; ?></p>

        <!-- Display FAQs -->
        <h3>FAQs</h3>
        <?php foreach ($faqs as $faq): ?>
            <p>Q: <?php echo $faq['question']; ?><br>A: <?php echo $faq['answer']; ?></p>
        <?php endforeach; ?>

        <!-- Display map -->
        <h3>Map</h3>
        <p>Map Link: <?php echo $row['map_link']; ?></p>

        <!-- Display image -->
        <h3>Image</h3>
        <img src="<?php echo $row['package_image']; ?>" alt="Package Image" style="max-width: 300px;">

        <!-- Add edit and delete options with appropriate links -->
        <p><a href="editpackage.php?id=<?php echo $packageId; ?>">Edit</a></p>
        <p><a href="deletepackage.php?id=<?php echo $packageId; ?>" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a></p>
    </div>
</body>

</html>

<?php
    } else {
        echo "Package not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Package ID not provided.";
}
?>
