<?php
include "conn.php";

if (isset($_GET['id'])) {
    $visaId = $_GET['id'];

    $sql = "SELECT * FROM visa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $visaId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Extract values from the fetched row
        $destination = $row['destination'];
        $processing_time = $row['processing_time'];
        $starting_from = $row['starting_from'];
        $destination_icon_path = $row['destination_icon_path'];
        $background_image_path = $row['background_image_path'];

        // Deserialize arrays
        $titles = unserialize($row['titles']);
        $processing_times = unserialize($row['processing_times']);
        $stay_periods = unserialize($row['stay_periods']);
        $validities = unserialize($row['validities']);
        $entry_types = unserialize($row['entry_types']);
        $number_of_entries = unserialize($row['number_of_entries']);
        $single_fees = unserialize($row['single_fees']);
        $visa_price_includes = unserialize($row['visa_price_includes']);
        $documents_required = unserialize($row['documents_required']);
        $visa_faqs = unserialize($row['visa_faqs']);
        $steps_to_get_visa = unserialize($row['steps_to_get_visa']);
        $visa_requirements = unserialize($row['visa_requirements']);
        $travel_checklist = unserialize($row['travel_checklist']);
        $what_to_do_when_arrive = unserialize($row['what_to_do_when_arrive']);
        $travel_guide = unserialize($row['travel_guide']);
        $reasons_for_rejection = unserialize($row['reasons_for_rejection']);
        $services_terms_conditions = unserialize($row['services_terms_conditions']);

        $stmt->close();
    } else {
        echo "Visa not found.";
        exit;
    }
} else {
    echo "Visa ID not provided.";
    exit;
}

if (isset($_POST['submit'])) {
    // General Tab
    $newDestination = $_POST['destination'];
    $newProcessingTime = $_POST['processing_time'];
    $newStartingFrom = $_POST['starting_from'];

    // Check if values are empty, if not, update them
    if (!empty($newDestination)) {
        $destination = $newDestination;
    }
    if (!empty($newProcessingTime)) {
        $processing_time = $newProcessingTime;
    }
    if (!empty($newStartingFrom)) {
        $starting_from = $newStartingFrom;
    }

    // Image Upload for Destination Icon
    $destination_icon_targetDirectory = "visa/";
    $destination_icon_targetFile = $destination_icon_targetDirectory . basename($_FILES["destination_icon"]["name"]);
    $destination_icon_uploadOk = 1;
    $destination_icon_fileType = strtolower(pathinfo($destination_icon_targetFile, PATHINFO_EXTENSION));

    // Check if a new image is provided
    if ($_FILES["destination_icon"]["size"] > 0) {
        if (move_uploaded_file($_FILES["destination_icon"]["tmp_name"], $destination_icon_targetFile)) {
            $destination_icon_path = $destination_icon_targetFile;
        } else {
            echo "Sorry, there was an error uploading your destination icon file.";
            exit;
        }
    }

    // Image Upload for Background Image
    $background_image_targetDirectory = "visa/";
    $background_image_targetFile = $background_image_targetDirectory . basename($_FILES["background_image"]["name"]);
    $background_image_uploadOk = 1;
    $background_image_fileType = strtolower(pathinfo($background_image_targetFile, PATHINFO_EXTENSION));

    // Check if a new image is provided
    if ($_FILES["background_image"]["size"] > 0) {
        if (move_uploaded_file($_FILES["background_image"]["tmp_name"], $background_image_targetFile)) {
            $background_image_path = $background_image_targetFile;
        } else {
            echo "Sorry, there was an error uploading your background image file.";
            exit;
        }
    }


    // Visa Types Tab
    $titles = serialize($_POST['titles']);
    $processing_times = serialize($_POST['processing_times']);
    $stay_periods = serialize($_POST['stay_periods']);
    $validities = serialize($_POST['validities']);
    $entry_types = serialize($_POST['entryType']);
    $number_of_entries = serialize($_POST['number_of_entries']);
    $single_fees = serialize($_POST['single_fees']);

    // Others Tab
    $visa_price_includes = serialize($_POST['visa_price_includes']);
    $documents_required = serialize($_POST['documents_required']);
    $visa_faqs = serialize($_POST['visa_faqs']);
    $steps_to_get_visa = serialize($_POST['steps_to_get_visa']);
    $visa_requirements = serialize($_POST['visa_requirements']);
    $travel_checklist = serialize($_POST['travel_checklist']);
    $what_to_do_when_arrive = serialize($_POST['what_to_do_when_arrive']);
    $travel_guide = serialize($_POST['travel_guide']);
    $reasons_for_rejection = serialize($_POST['reasons_for_rejection']);
    $services_terms_conditions = serialize($_POST['services_terms_conditions']);

    $sql = "UPDATE visa SET
    destination = ?, 
    processing_time = ?, 
    starting_from = ?, 
    destination_icon_path = ?, 
    background_image_path = ?, 
    titles = ?, 
    processing_times = ?, 
    stay_periods = ?, 
    validities = ?, 
    entry_types = ?, 
    number_of_entries = ?, 
    single_fees = ?, 
    visa_price_includes = ?, 
    documents_required = ?, 
    visa_faqs = ?, 
    steps_to_get_visa = ?, 
    visa_requirements = ?, 
    travel_checklist = ?, 
    what_to_do_when_arrive = ?, 
    travel_guide = ?, 
    reasons_for_rejection = ?, 
    services_terms_conditions = ?
    WHERE id = ?";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param(
        "ssssssssssssssssssssssi",
        $destination,
        $processing_time,
        $starting_from,
        $destination_icon_path,
        $background_image_path,
        $titles,
        $processing_times,
        $stay_periods,
        $validities,
        $entry_types,
        $number_of_entries,
        $single_fees,
        $visa_price_includes,
        $documents_required,
        $visa_faqs,
        $steps_to_get_visa,
        $visa_requirements,
        $travel_checklist,
        $what_to_do_when_arrive,
        $travel_guide,
        $reasons_for_rejection,
        $services_terms_conditions,
        $visaId
    );

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: viewvisa.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Application</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="button"] {
            background-color: #4caf50;
        }

        hr {
            border: 1px solid #ccc;
            margin-top: 20px;
        }

        .tab {
            display: none;
        }

        #addVisaTypeBtn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include "dashboard.php"; ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <h2>Edit Visa Application Form</h2>


        <!-- Tabs -->
        <button type="button" onclick="showTab('general')">General</button>
        <button type="button" onclick="showTab('visaTypes')">Visa Types</button>
        <button type="button" onclick="showTab('others')">Other Information</button>

        <!-- General Tab -->
        <div id="general" class="tab">
            <label for="destination">Destination:</label>
            <input type="text" name="destination" value="<?php echo $destination; ?>" required><br>

            <label for="processing_time">Processing Time:</label>
            <input type="text" name="processing_time" value="<?php echo $processing_time; ?>" required><br>

            <label for="starting_from">Starting From:</label>
            <input type="text" name="starting_from" value="<?php echo $starting_from; ?>" required><br>

            <label for="destination_icon">Destination Icon:</label>
            <input type="file" name="destination_icon" accept="image/*">
            <img src="<?php echo $destination_icon_path; ?>" alt="Destination Icon" style="max-width: 100px;"><br>

            <label for="background_image">Background Image:</label>
            <input type="file" name="background_image" accept="image/*">
            <img src="<?php echo $background_image_path; ?>" alt="Background Image" style="max-width: 100px;"><br>
        </div>

        <!-- Visa Types Tab -->
        <div id="visaTypes" class="tab">
            <?php
            if (!empty($titles)) {
                foreach ($titles as $index => $title) {
                    echo '
                        <div>
                            <h3>Visa Type</h3>
                            <label for="title">Title:</label>
                            <input type="text" name="titles[]" value="' . $title . '" required><br>

                            <label for="processing_time">Processing Time:</label>
                            <input type="text" name="processing_times[]" value="' . $processing_times[$index] . '" required><br>

                            <label for="stay_period">Stay Period:</label>
                            <input type="text" name="stay_periods[]" value="' . $stay_periods[$index] . '" required><br>

                            <label for="validity">Validity:</label>
                            <input type="text" name="validities[]" value="' . $validities[$index] . '" required><br>

                            <label for="entry_type">Entry Type (single/multiple):</label>
                            <input type="text" name="entryType[]" value="' . $entry_types[$index] . '" required><br>

                            <label for="number_of_entries">Number of Entries:</label>
                            <input type="number" name="number_of_entries[]" value="' . $number_of_entries[$index] . '"><br>

                            <label for="single_fee">Single Fee:</label>
                            <input type="text" name="single_fees[]" value="' . $single_fees[$index] . '" required><br>

                            <button type="button" onclick="removeVisaType(this)">Remove Visa Type</button>

                            <hr>
                        </div>
                    ';
                }
            }
            ?>
        </div>

        <!-- Others Tab -->
        <div id="others" class="tab">
            <label for="visa_price_includes">Visa Price Includes:</label>
            <textarea name="visa_price_includes[]" required><?php echo implode("\n", $visa_price_includes); ?></textarea><br>

            <label for="documents_required">Documents Required:</label>
            <textarea name="documents_required[]" required><?php echo implode("\n", $documents_required); ?></textarea><br>

            <label for="visa_faqs">Visa FAQs:</label>
            <textarea name="visa_faqs[]" required><?php echo implode("\n", $visa_faqs); ?></textarea><br>

            <label for="steps_to_get_visa">Steps to Get Visa:</label>
            <textarea name="steps_to_get_visa[]" required><?php echo implode("\n", $steps_to_get_visa); ?></textarea><br>

            <label for="visa_requirements">Visa Requirements:</label>
            <textarea name="visa_requirements[]" required><?php echo implode("\n", $visa_requirements); ?></textarea><br>

            <label for="travel_checklist">Travel Checklist:</label>
            <textarea name="travel_checklist[]" required><?php echo implode("\n", $travel_checklist); ?></textarea><br>

            <label for="what_to_do_when_arrive">What to Do When You Arrive:</label>
            <textarea name="what_to_do_when_arrive[]" required><?php echo implode("\n", $what_to_do_when_arrive); ?></textarea><br>

            <label for="travel_guide">Travel Guide:</label>
            <textarea name="travel_guide[]" required><?php echo implode("\n", $travel_guide); ?></textarea><br>

            <label for="reasons_for_rejection">Reasons for Visa Rejection:</label>
            <textarea name="reasons_for_rejection[]" required><?php echo implode("\n", $reasons_for_rejection); ?></textarea><br>

            <label for="services_terms_conditions">Services - Terms & Conditions:</label>
            <textarea name="services_terms_conditions[]" required><?php echo implode("\n", $services_terms_conditions); ?></textarea><br>

            <button type="submit" name="submit" style="margin-top: 10px;">Update Visa</button>
        </div>
    </form>

    <script>
        function addVisaType() {
            const visaTypesContainer = document.getElementById('visaTypesContainer');
            const visaTypeDiv = document.createElement('div');
            visaTypeDiv.innerHTML = `
        <h3>Visa Type</h3>
        <label for="title">Title:</label>
        <input type="text" name="titles[]" required><br>

        <label for="processing_time">Processing Time:</label>
        <input type="text" name="processing_times[]" required><br>

        <label for="stay_period">Stay Period:</label>
        <input type="text" name="stay_periods[]" required><br>

        <label for="validity">Validity:</label>
        <input type="text" name="validities[]" required><br>

        <label for="entry_type">Entry Type (single/multiple):</label>
        <input type="text" name="entryType[]" required><br>

        <label for="number_of_entries">Number of Entries:</label>
        <input type="number" name="number_of_entries[]"><br>

        <label for="single_fee">Single Fee:</label>
        <input type="text" name="single_fees[]" required><br>

        <button type="button" onclick="removeVisaType(this)">Remove Visa Type</button>

        <hr>
    `;
            visaTypesContainer.appendChild(visaTypeDiv);
        }


        function removeVisaType(button) {
            const visaTypeDiv = button.parentElement;
            visaTypeDiv.remove();
        }

        function removeVisaType(button) {
            const visaTypeDiv = button.parentElement;
            visaTypeDiv.remove();
        }

        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.style.display = 'none');
            document.getElementById(tabName).style.display = 'block';
        }
    </script>
</body>

</html>