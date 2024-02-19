<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Fetch package details from the database
    $sql = "SELECT * FROM packagedetails WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $packageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Extract values from the fetched row
        $name = $row['package_name'];
        $description = $row['package_description'];
        $price = $row['package_price'];
        $overV = $row['overview'];
        $highL = $row['highlight'];
        $noOfDays = $row['no_of_days'];
        $locations = $row['locations'];
        $discountPrice = $row['discount_price'];
        $accommodation = $row['accommodation'];
        $meals = $row['meals'];
        $transportation = $row['transportation'];

        // Deserialize the arrays
        $itinerary = unserialize($row['itinerary']);
        $costIncludes = $row['cost_includes'];
        $costExcludes = $row['cost_excludes'];
        $faqs = unserialize($row['faqs']);
        $mapLink = $row['map_link'];
        $imagePath = $row['package_image'];

        // Close the statement
        $stmt->close();
    } else {
        echo "Package not found.";
        exit;
    }
} else {
    echo "Package ID not provided.";
    exit;
}

if (isset($_POST['submit'])) {
    $name = $_POST['package_name'];
    $description = $_POST['package_description'];
    $price = $_POST['package_price'];
    $overV = $_POST['overview'];
    $highL = $_POST['highlight'];
    $noOfDays = $_POST['no_of_days'];
    $locations = $_POST['locations'];
    $discountPrice = $_POST['discount_price'];
    $accommodation = $_POST['accommodation'];
    $meals = $_POST['meals'];
    $transportation = $_POST['transportation'];
    

    // Itinerary
    $itinerary = [];
    if (isset($_POST['itinerary_day_title']) && is_array($_POST['itinerary_day_title'])) {
        foreach ($_POST['itinerary_day_title'] as $i => $dayTitle) {
            $dayDescription = $_POST['itinerary_day_description'][$i];
            $itinerary[] = ['title' => $dayTitle, 'description' => $dayDescription];
        }
    }

    // Cost
    $costIncludes = $_POST['cost_includes'];
    $costExcludes = $_POST['cost_excludes'];

    // FAQs
    $faqs = [];
    if (isset($_POST['faq_question']) && is_array($_POST['faq_question'])) {
        foreach ($_POST['faq_question'] as $i => $faqQuestion) {
            $faqAnswer = $_POST['faq_answer'][$i];
            $faqs[] = ['question' => $faqQuestion, 'answer' => $faqAnswer];
        }
    }

    // Map
    $mapLink = $_POST['map'];

    // Update Image Upload Logic
    if ($_FILES["image"]["size"] > 0) {
        $targetDirectory = "upload/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Serialize the arrays
    $itinerarySerialized = serialize($itinerary);
    $faqsSerialized = serialize($faqs);

    $sql = "UPDATE packagedetails SET 
    package_name = ?, 
    package_description = ?, 
    package_price = ?, 
    overview = ?, 
    highlight = ?, 
    itinerary = ?, 
    cost_includes = ?, 
    cost_excludes = ?, 
    faqs = ?, 
    map_link = ?, 
    package_image = ?, 
    no_of_days = ?, 
    locations = ?, 
    discount_price = ?,
    accommodation = ?,
    meals = ?,
    transportation = ?
    WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param(
        "ssdssssssssisdsssi", 
        $name,
        $description,
        $price,
        $overV,
        $highL,
        $itinerarySerialized,
        $costIncludes,
        $costExcludes,
        $faqsSerialized,
        $mapLink,
        $imagePath,
        $noOfDays,
        $locations,
        $discountPrice,
        $accommodation,
        $meals,
        $transportation,
        $packageId  
    );
    
$stmt->execute();

$stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Package Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
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
            width: calc(100% - 250px);
            /* Adjust the width to fit your design */
        }

        .container {
            max-width: 1200px;
            width: 1200px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .tab-container {
            overflow: hidden;
            background-color: #f4f4f4;
            border-radius: 5px;
            margin-bottom: 20px;
            /* Added margin for separation */
        }

        .tab-button {
            background-color: #ddd;
            float: left;
            border: 1px solid #ccc;
            outline: none;
            cursor: pointer;
            padding: 10px;
            transition: background-color 0.3s;
            border-radius: 5px 5px 0 0;
            width: 19%;
            /* Adjust the width to fit your design */
        }

        .tab-button:hover {
            background-color: #bbb;
        }

        .tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 0 0 5px 5px;
        }

        .day-field,
        .faq-field {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .remove-item {
            color: #ff0000;
            cursor: pointer;
            float: right;
        }

        .remove-item:hover {
            text-decoration: underline;
        }

        .tab-button.active {
            background-color: #4caf50;
            color: #fff;
        }

        .tab-content.active {
            display: block;
        }
    </style>

</head>

<body>
<?php include "dashboard.php"; ?>
    <div id="content">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="container">
                <h2>Edit Package Details</h2>

                <div class="tab-container">
                    <button class="tab-button active" onclick="openTab('tab-general')">General</button>
                    <button class="tab-button" onclick="openTab('tab-itinerary')">Itinerary</button>
                    <button class="tab-button" onclick="openTab('tab-cost')">Cost</button>
                    <button class="tab-button" onclick="openTab('tab-faqs')">FAQs</button>
                    <button class="tab-button" onclick="openTab('tab-map')">Map</button>
                </div>

                <!-- General Tab -->
                <div id="tab-general" class="tab-content active">
                    <label for="package_name">Package Name:</label>
                    <input type="text" name="package_name" value="<?php echo $name; ?>" required>

                    <label for="no_of_days">No. of Days:</label>
                    <input type="number" name="no_of_days" value="<?php echo $noOfDays; ?>" required>

                    <!-- Display the existing image -->
                    <img src="<?php echo $imagePath; ?>" alt="Package Image" style="max-width: 100%; margin-bottom: 10px;">

                    <!-- Add new input for image upload -->
                    <label for="image">Select a new image:</label>
                    <input type="file" name="image" id="image">

                    <label for="accommodation">Accommodation:</label>
                    <textarea name="accommodation"><?php echo $accommodation; ?></textarea>

                    <label for="meals">Meals:</label>
                    <textarea name="meals"><?php echo $meals; ?></textarea>

                    <label for="transportation">Transportation:</label>
                    <textarea name="transportation" required><?php echo $transportation; ?></textarea>

                    <label for="package_description">Package Description:</label>
                    <textarea name="package_description" required><?php echo $description; ?></textarea>

                    <label for="locations">Locations:</label>
                    <input type="text" name="locations" value="<?php echo $locations; ?>" required>

                    <label for="package_price">Package Price:</label>
                    <input type="number" name="package_price" value="<?php echo $price; ?>" required>

                    <label for="discount_price">Discount Price:</label>
                    <input type="number" name="discount_price" value="<?php echo $discountPrice; ?>">

                    <label for="overview">Overview:</label>
                    <textarea name="overview"><?php echo $overV; ?></textarea>

                    <label for="highlight">Highlight:</label>
                    <textarea name="highlight"><?php echo $highL; ?></textarea>

                </div>

                <div id="tab-itinerary" class="tab-content">
                    <?php
                    // Loop through existing itinerary data and display fields
                    foreach ($itinerary as $index => $day) {
                        echo '<div class="day-field">';
                        echo '<label for="itinerary_day_title">Title:</label>';
                        echo '<input type="text" name="itinerary_day_title[]" value="' . $day['title'] . '">';
                        echo '<label for="itinerary_day_description">Description:</label>';
                        echo '<textarea name="itinerary_day_description[]">' . $day['description'] . '</textarea>';
                        echo '<span class="remove-item" onclick="removeDay(this)">Remove Day</span>';
                        echo '</div>';
                    }
                    ?>
                    <button type="button" onclick="addNewDay()">Add New Day</button>
                </div>

                <div id="tab-cost" class="tab-content">
                    <!-- Cost Tab -->
                    <label for="cost">Cost:</label>
                    <label for="cost_includes">Cost Includes:</label>
                    <textarea name="cost_includes"><?php echo $costIncludes; ?></textarea>
                    <label for="cost_excludes">Cost Excludes:</label>
                    <textarea name="cost_excludes"><?php echo $costExcludes; ?></textarea>
                </div>

                <div id="tab-faqs" class="tab-content">
                    <?php
                    // Loop through existing FAQs data and display fields
                    foreach ($faqs as $index => $faq) {
                        echo '<div class="faq-field">';
                        echo '<label for="faq_question">Question:</label>';
                        echo '<input type="text" name="faq_question[]" value="' . $faq['question'] . '">';
                        echo '<label for="faq_answer">Answer:</label>';
                        echo '<textarea name="faq_answer[]">' . $faq['answer'] . '</textarea>';
                        echo '<span class="remove-item" onclick="removeFAQ(this)">Remove FAQ</span>';
                        echo '</div>';
                    }
                    ?>
                    <button type="button" onclick="addNewFAQ()">Add New FAQ</button>
                </div>

                <div id="tab-map" class="tab-content">
                    <label for="map">Map:</label>
                    <textarea id="map-link" name="map" placeholder="Paste your Google Map link here"><?php echo $mapLink; ?></textarea>
                    <button type="button" onclick="previewMap()">Preview Map</button>
                    <div id="map-preview"></div>
                </div>

                <div style="margin-top: 10px">
                    <button type="submit" name="submit">Update Package</button>
                </div>
            </div>
    </div>
    </form>
    </div>

    <script>
        function logout() {
            localStorage.removeItem('token');
            window.location.href = 'login.php';
        }

        function openTab(tabName) {
            var i, tabContent, tabButtons;
            tabContent = document.getElementsByClassName("tab-content");
            tabButtons = document.getElementsByClassName("tab-button");

            // Check if the form is being submitted and prevent it
            if (event.target.tagName === 'BUTTON') {
                event.preventDefault();
            }

            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active");
                tabButtons[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            for (i = 0; i < tabButtons.length; i++) {
                if (tabButtons[i].getAttribute("onclick").includes(tabName)) {
                    tabButtons[i].classList.add("active");
                    break;
                }
            }
        }


        let dayCounter = 1;

        function addNewDay() {
            const container = document.getElementById('tab-itinerary');
            const newDayField = document.createElement('div');
            newDayField.className = 'day-field';
            newDayField.innerHTML = `
        <label for="itinerary_day_title">Title:</label>
        <input type="text" name="itinerary_day_title[]"> <!-- Notice the [] here -->
        <label for="itinerary_day_description">Description:</label>
        <textarea name="itinerary_day_description[]"></textarea>
        <span class="remove-item" onclick="removeDay(this)">Remove Day</span>
    `;
            container.appendChild(newDayField);
            dayCounter++;
        }

        let faqCounter = 1;

        function addNewFAQ() {
            const container = document.getElementById('tab-faqs');
            const newFAQField = document.createElement('div');
            newFAQField.className = 'faq-field';
            newFAQField.innerHTML = `
        <label for="faq_question">Question:</label>
        <input type="text" name="faq_question[]"> <!-- Notice the [] here -->
        <label for="faq_answer">Answer:</label>
        <textarea name="faq_answer[]"></textarea>
        <span class="remove-item" onclick="removeFAQ(this)">Remove FAQ</span>
    `;
            container.appendChild(newFAQField);
            faqCounter++;
        }

        function removeDay(element) {
            const container = document.getElementById('tab-itinerary');
            const dayField = element.closest('.day-field');
            container.removeChild(dayField);
            dayCounter--;
        }

        function removeFAQ(element) {
            const container = document.getElementById('tab-faqs');
            const faqField = element.closest('.faq-field');
            container.removeChild(faqField);
            faqCounter--;
        }
    </script>
    <script>
        function previewMap() {
            const mapLink = document.getElementById('map-link').value;

            if (mapLink.includes('google.com/maps')) {
                // Extracting the place ID from the regular Google Maps link
                const placeIdMatch = mapLink.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);

                if (placeIdMatch && placeIdMatch.length === 3) {
                    const latitude = placeIdMatch[1];
                    const longitude = placeIdMatch[2];

                    // Creating an iframe to embed the map using the place ID
                    const iframe = document.createElement('iframe');
                    iframe.setAttribute('width', '100%');
                    iframe.setAttribute('height', '400');
                    iframe.setAttribute('frameborder', '0');
                    iframe.setAttribute('style', 'border:0');
                    iframe.setAttribute('src', `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.2748465438767!2d${longitude}!3d${latitude}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b063626ed32c771%3A0xff305e1affdbb4b4!2sAmal%20Jyothi%20College%20of%20Engineering!5e0!3m2!1sen!2sin!4v1648729644567!5m2!1sen!2sin`);

                    // Clearing the previous preview and appending the new one
                    document.getElementById('map-preview').innerHTML = '';
                    document.getElementById('map-preview').appendChild(iframe);
                } else {
                    alert('Invalid Google Map link. Please enter a valid link.');
                }
            } else {
                alert('Please enter a valid Google Map link.');
            }
        }
    </script>
</body>

</html>