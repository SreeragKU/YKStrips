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

if (isset($_POST['submit'])) {
    $name = $_POST['package_name'];
    $description = $_POST['package_description'];
    $price = $_POST['package_price'];
    $overV = $_POST['overview'];
    $highL = $_POST['highlight'];
    $no_of_days = $_POST['no_of_days'];
    $locations = $_POST['locations'];
    $discount_price = isset($_POST['discount_price']) ? $_POST['discount_price'] : null;
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

    // Image Upload
    $targetDirectory = "upload/"; // Update the path to remove leading slash
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Create the target directory if it doesn't exist
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    // Check if the image file already exists
    if (file_exists($targetFile)) {
        $imagePath = $targetFile; // Reuse existing image path
    } else {
        // Upload new image
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
    // Prepare and execute the SQL INSERT query
    $sql = "INSERT INTO packagedetails 
    (package_name, no_of_days, package_description, locations, package_price, discount_price, overview, highlight, accommodation, meals, transportation, itinerary, cost_includes, cost_excludes, faqs, map_link, package_image) 
    VALUES 
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sdssddsssssssssss",
        $name,
        $no_of_days,
        $description,
        $locations,
        $price,
        $discount_price,
        $overV,
        $highL,
        $accommodation,
        $meals,
        $transportation,
        $itinerarySerialized,
        $costIncludes,
        $costExcludes,
        $faqsSerialized,
        $mapLink,
        $imagePath
    );




    $result = $stmt->execute();

    if ($result) {
        echo "Package added successfully!";
    } else {
        echo "Error adding package: " . $stmt->error;
    }

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

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
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
        <form action="addpackage.php" method="post" enctype="multipart/form-data" class="container">
            <h2>Add Package Details</h2>

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
                <input type="text" name="package_name" required>

                <label for="no_of_days">No. of Days:</label>
                <input type="number" name="no_of_days" required>

                <label for="image">Select an image:</label>
                <input type="file" name="image" id="image" required>

                <label for="package_description">Package Description:</label>
                <textarea name="package_description" required></textarea>

                <label for="accommodation">Accommodation:</label>
                <textarea name="accommodation" required></textarea>

                <label for="meals">Meals:</label>
                <textarea name="meals" required></textarea>

                <label for="transportation">Transportation:</label>
                <textarea name="transportation" required></textarea>

                <label for="locations">Locations:</label>
                <input type="text" name="locations" required>

                <label for="package_price">Package Price:</label>
                <input type="number" name="package_price" required>

                <label for="discount_price">Discount Price:</label>
                <input type="number" name="discount_price">

                <label for="overview">Overview:</label>
                <textarea name="overview" required></textarea>

                <label for="highlight">Highlight:</label>
                <textarea name="highlight" required></textarea>
            </div>

            <div id="tab-itinerary" class="tab-content">
                <!-- Itinerary Tab - No specific fields are marked as required, but you may add if needed -->
                <button type="button" onclick="addNewDay()">Add New Day</button>
            </div>

            <div id="tab-cost" class="tab-content">
                <!-- Cost Tab -->
                <label for="cost">Cost:</label>
                <label for="cost_includes">Cost Includes:</label>
                <textarea name="cost_includes" required></textarea>
                <label for="cost_excludes">Cost Excludes:</label>
                <textarea name="cost_excludes" required></textarea>
            </div>

            <div id="tab-faqs" class="tab-content">
                <!-- FAQs Tab - No specific fields are marked as required, but you may add if needed -->
                <button type="button" onclick="addNewFAQ()">Add New FAQ</button>
            </div>

            <div id="tab-map" class="tab-content">
                <label for="map">Map:</label>
                <textarea id="map-link" name="map" placeholder="Paste your Google Map link here" required></textarea>
                <div id="map-preview"></div>
                <div style="margin-top: 10px">
                    <button type="submit" name="submit">Add Package</button>
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

            // Check if all required fields are filled in the current tab
            if (!validateCurrentTab()) {
                alert('Please fill in all required fields before proceeding.');
                return;
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

        function validateCurrentTab() {
            var currentTab = document.querySelector(".tab-content.active");

            // Check if there are required fields in the current tab
            var requiredFields = currentTab.querySelectorAll('[required]');
            for (var i = 0; i < requiredFields.length; i++) {
                // Check if the value is empty or whitespace
                if (!requiredFields[i].value.trim()) {
                    return false; // Return false if any required field is empty
                }
            }
            return true; // All required fields are filled
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

        function embedMap() {
            const mapLinkInput = document.getElementById('map-link');
            const mapLinkHTML = mapLinkInput.value;

            // Create a temporary container to parse the HTML
            const tempContainer = document.createElement('div');
            tempContainer.innerHTML = mapLinkHTML;

            // Extract attributes from the parsed HTML
            const attributes = {};
            const iframe = tempContainer.querySelector('iframe');
            if (iframe) {
                for (const attribute of iframe.attributes) {
                    attributes[attribute.name] = attribute.value;
                }
            }

            // Creating an iframe to embed the map using the extracted attributes
            const iframeEmbed = document.createElement('iframe');
            for (const [key, value] of Object.entries(attributes)) {
                iframeEmbed.setAttribute(key, value);
            }

            // Clearing the previous preview and appending the new one
            const mapPreviewContainer = document.getElementById('map-preview');
            mapPreviewContainer.innerHTML = '';
            mapPreviewContainer.appendChild(iframeEmbed);
        }

        // Embed the map when the input value changes
        document.getElementById('map-link').addEventListener('input', embedMap);
    </script>

    <script>
        function previewMap() {
            const mapLink = document.getElementById('map-link').value;

            // Creating an iframe to embed the map using the provided link
            const iframe = document.createElement('iframe');
            iframe.setAttribute('width', '100%');
            iframe.setAttribute('height', '400');
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('style', 'border:0');
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('loading', 'lazy');
            iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
            iframe.src = mapLink;

            // Clearing the previous preview and appending the new one
            const mapPreviewContainer = document.getElementById('map-preview');
            mapPreviewContainer.innerHTML = '';
            mapPreviewContainer.appendChild(iframe);
        }
    </script>
</body>

</html>