<?php
include "conn.php";

// Fetch all destinations from the database
$query = "SELECT DISTINCT destination FROM visa";
$result = $conn->query($query);

// Fetch destination information based on user selection
if (isset($_GET['selected_destination'])) {
    $selected_destination = $_GET['selected_destination'];
    $select_query = "SELECT * FROM visa WHERE destination = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("s", $selected_destination);
    $stmt->execute();
    $result_selected = $stmt->get_result()->fetch_assoc();

    // Unserialize specific fields
    $fields_to_unserialize = ['titles', 'processing_times', 'stay_periods', 'validities', 'entry_types', 'number_of_entries', 'single_fees', 'visa_price_includes', 'documents_required', 'visa_faqs', 'steps_to_get_visa', 'visa_requirements', 'travel_checklist', 'what_to_do_when_arrive', 'travel_guide', 'reasons_for_rejection', 'services_terms_conditions'];
    foreach ($fields_to_unserialize as $field) {
        if (isset($result_selected[$field])) {
            $result_selected[$field] = unserialize($result_selected[$field]);
        }
    }

    $stmt->close();
}

if (isset($_POST['delete_destination'])) {
    $delete_destination = $_POST['delete_destination'];
    $delete_query = "DELETE FROM visa WHERE destination = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("s", $delete_destination);
    $stmt_delete->execute();
    $stmt_delete->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>View Visa Information</title>
    <style>
        .destination-info {
            flex: 2;
            max-width: 800px;
            margin: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007BFF;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        h2 .edit-delete-icons {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            gap: 10px;
        }

        button {
            width: auto;
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            font-size: 14px;
            color: #007BFF;
        }

        button:hover {
            text-decoration: underline;
        }


        form {
            margin: 0 auto 20px;
            padding: 20px;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin: 10px 0;
        }

        img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <?php include "dashboard.php"; ?>
    </div>

    <div class="destination-info" style="margin-left: 350px;">
        <form action="#" method="get">
            <label for="destination">Select Destination:</label>
            <select name="selected_destination" onchange="this.form.submit()">
                <option value="" disabled selected>Select a destination</option>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['destination'] . "'>" . $row['destination'] . "</option>";
                }
                ?>
            </select>
        </form>

        <?php
        if (isset($result_selected)) {
            echo "<div style='position: relative; border-bottom: 2px solid #007BFF;'>";
            echo "<h2 style='display: inline-block;'>" . $result_selected['destination'] . "</h2>";
            echo "<div class='edit-delete-icons' style='position: absolute; top: 0; right: 0;'>";
            
            echo "<form action='edit_visa.php' method='get' style='display: inline-block;'>";
            echo "<input type='hidden' name='id' value='" . $result_selected['id'] . "'>";
            echo "<button type='submit' style='border: none; cursor: pointer;'>";
            echo "<i class='fas fa-edit'></i> </button>";
            echo "</form>";
        
            echo "<form action='#' method='post' style='display: inline-block;'>";
            echo "<input type='hidden' name='delete_destination' value='" . $result_selected['destination'] . "'>";
            echo "<button type='submit' style='cursor: pointer;' onclick='return confirm(\"Are you sure you want to delete this destination?\");'>";
            echo "<i class='fas fa-trash-alt'></i> </button>";
            echo "</form>";

            echo "</div>"; 
            echo "</div>"; 
            foreach ($result_selected as $key => $value) {
                if ($key != 'destination' && $key != 'destination_icon_path' && $key != 'background_image_path') {
                    echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> ";

                    if (is_array($value)) {
                        echo implode(', ', $value);
                    } else {
                        echo $value;
                    }

                    echo "</p>";
                }
            }

            // Display destination icon and background image if available
            if (!empty($result_selected['destination_icon_path'])) {
                echo "<img src='" . $result_selected['destination_icon_path'] . "' alt='Destination Icon'>";
            }

            if (!empty($result_selected['background_image_path'])) {
                echo "<img src='" . $result_selected['background_image_path'] . "' alt='Background Image'>";
            }
        }
        ?>
    </div>
</body>

</html>