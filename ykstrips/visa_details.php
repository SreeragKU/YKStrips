<?php
include "conn.php";

// Check if the destination_id is set in the URL
if (isset($_GET['destination_id'])) {
    $destination_id = isset($_GET['destination_id']) ? base64_decode($_GET['destination_id']) : null;

    // Fetch visa details for the specified destination_id
    $visaSql = "SELECT * FROM visa WHERE id = ?";
    $stmt = $conn->prepare($visaSql);
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $visaDetails = $result->fetch_assoc();
    } else {
        // Redirect or handle when destination_id is not found
        header("Location: error_page.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect or handle when destination_id is not set
    header("Location: error_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YKS TRIP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        .slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .slider-cat-container {
            width: 70%;
            overflow: hidden;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            flex: 0 0 auto;
            margin-right: 2px;
        }


        .destination-card {
            width: 100%;
            margin-right: 2px;
            overflow: hidden;
        }


        .destination-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .destination-info {
            text-align: center;
        }

        .destination-info h3,
        .destination-info h6 {
            margin: 5px 0;
        }

        .destination-info .btn {
            font-size: 1.2em;
            padding: 10px 20px;
            margin-top: 10px;
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            padding: 0 20px;
        }

        .logo-img {
            max-width: 100%;
            border-radius: 50%;
            padding: 5px;
            transition: max-width 0.5s ease-in-out;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #007bff;
            font-size: 1.8em;
        }
    </style>
    <style>
        @media only screen and (max-width: 767px) {

            .slider-cat-container {
                width: 100%;
                overflow: hidden;
                position: relative;
                margin-left: auto;
                margin-right: auto;
            }

            .slider-item {
                margin-right: 0;
            }

            .social-icons {
                display: none;
            }

            .container-xxl {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .container {
                width: 100%;
            }

            .logo-img {
                max-width: 100%;
                border-radius: 50%;
                padding: 5px;
                transition: max-width 0.5s ease-in-out;
            }

            .btn-primary {
                font-size: 0.4em;
            }

            .btn-smaller-font {
                font-size: 0.4em;
            }

            .btn {
                width: 100%;
                height: auto;
            }
        }

        @media only screen and (max-width: 767px) {
            .footer .social-icons {
                display: flex;
                justify-content: center;
            }
        }
    </style>
    <style>
        body {
            background-image: url('img/visabg.png');
            background-repeat: repeat;
            background-size: 300px 300px;
            background-position: center center;
        }

        .owl-prev,
        .owl-next {
            display: none !important;
        }
    </style>
    <style>
        /* Header Styles */
        header {
            background-color: #343a40;
            padding: 10px 0;
            color: #ffffff;
        }

        .logo-img {
            max-width: 70px;
            border-radius: 50%;
            padding: 5px;
            transition: max-width 0.5s ease-in-out;
        }

        /* Hero Section Styles */
        #hero-section {
            background-size: cover;
            height: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .hero-content {
            max-width: 80%;
            margin: 0 auto;
        }

        /* Visa Cards Styles */
        .visa-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px 0;
        }

        .visa-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            margin: 10px;
            background-color: #fff;
            max-width: 300px;
        }

        .visa-card:hover {
            transform: scale(1.05);
        }

        .visa-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            border-radius: 10px 10px 0 0;
        }

        .visa-card h2 {
            padding: 15px;
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .visa-card p {
            padding: 0 15px 15px 15px;
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        #details-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        #details-section {
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            max-width: 75%;
            margin-left: auto;
            margin-right: auto;
        }

        #details-section h3 {
            font-size: 1.8em;
            color: #007bff;
            margin-top: 20px;
        }

        #details-section p {
            font-size: 1.1em;
            color: #333;
            line-height: 1.6;
            padding: 10px;
        }


        /* Footer Styles */
        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        /* Back to Top Button Styles */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 1.5em;
            padding: 10px;
            cursor: pointer;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .faq-answer {
            display: none;
            margin-left: 20px;
        }

        .custom-bullet-list {
            list-style-type: none;
            margin-left: 1.5em;
            padding-left: 0;
        }

        .custom-bullet-list li:before {
            content: "\2022";
            color: #459984;
            font-size: 1.2em;
            margin-right: 0.5em;
        }
    </style>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php include "header.php"; ?>

    <section id="hero-section" style="
            background-image: url('<?php echo $visaDetails['background_image_path']; ?>');
            background-size: cover;
            height: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Vertical centering */
            ">

        <div class="hero-content" style="
                font-family: 'Roboto', sans-serif;
                color: #fff;
                font-weight: bold;
                line-height: 1.5;
                letter-spacing: 1px;
                text-align: center;
                max-width: 80%; /* Optional to limit content width */
            ">

            <h1 style="
                    font-size: 3rem;
                    margin-bottom: 1rem;
                    text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3); /* Subtle drop shadow */
                    ">
                <?php echo $visaDetails['destination']; ?>
            </h1>

            <h3 style="
                    font-size: 1.5rem;
                    margin-bottom: 0.5rem;
                    ">
                Processing Time: <?php echo $visaDetails['processing_time']; ?>
            </h3>

            <p style="
                    font-size: 1.2rem;
                    margin-bottom: 1rem; /* Add some bottom margin for better spacing */
                    ">
                Starting From: ₹ <?php echo $visaDetails['starting_from']; ?> /-
            </p>
        </div>
    </section>

    <section id="visa-types-section">
        <div class="visa-cards-container d-flex justify-content-center" style="margin-left: 10px;">
            <?php
            $titles = unserialize($visaDetails['titles']);
            $processing_times = unserialize($visaDetails['processing_times']);
            $stay_periods = unserialize($visaDetails['stay_periods']);
            $validities = unserialize($visaDetails['validities']);
            $entry_types = unserialize($visaDetails['entry_types']);
            $number_of_entries = unserialize($visaDetails['number_of_entries']);
            $single_fees = unserialize($visaDetails['single_fees']);

            foreach ($titles as $index => $title) :
            ?>
                <div class="visa-card" style="
                border: 2px solid #007bff; 
                border-radius: 15px; 
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); 
                margin: 30px;
                background-color: #ffffff; 
                height: 450px;
                position: relative;
                ">

                    <h2 style="color: #007bff;">
                        <center><?php echo $title; ?></center>
                    </h2>

                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-clock"></i> Processing Time:</strong> <?php echo $processing_times[$index]; ?>
                    </p>
                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-calendar-alt"></i> Stay Period:</strong> <?php echo $stay_periods[$index]; ?>
                    </p>
                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-calendar-check"></i> Validity:</strong> <?php echo $validities[$index]; ?>
                    </p>
                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-plane"></i> Entry Type:</strong> <?php echo $entry_types[$index]; ?>
                    </p>
                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-sort-numeric-up"></i> Number of Entries:</strong> <?php echo $number_of_entries[$index]; ?>
                    </p>
                    <p onmouseover="growAndHighlight(this)" onmouseout="resetStyles(this)" style="margin-left: 10px;">
                        <strong><i class="fas fa-dollar-sign"></i> Single Fees:</strong> <?php echo $single_fees[$index]; ?>
                    </p>
                    <!-- ... -->
                    <div class="d-flex justify-content-center mb-2" style="position: absolute !important; bottom: 0; width: 100%;">
                        <!-- &nbspCall Us button with icon for larger screens -->
                        <a href="tel:+919207041904" class="btn btn-sm btn-primary px-2 border-end d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                            <i class="fas fa-phone me-1" style="font-size: 0.8em; transform: rotate(90deg); margin-right: 30px;"></i>&nbsp;&nbsp;Call Us
                        </a>

                        <!-- WhatsApp button with icon for larger screens -->
                        <a href="https://api.whatsapp.com/send/?phone=%2B919207041904&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                            <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em; margin-right: 3px;">Chat on Whatsapp
                        </a>

                        <!-- &nbspCall Us icon-only button for smaller screens -->
                        <a href="tel:+919207041904" class="btn btn-sm btn-primary px-2 border-end d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                            <i class="fas fa-phone" style="font-size: 0.8em; transform: rotate(90deg);"></i>
                        </a>

                        <!-- WhatsApp icon-only button for smaller screens -->
                        <a href="https://api.whatsapp.com/send/?phone=%2B919207041904&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                            <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em;">
                        </a>

                        <script>
                            function changeBackgroundColor(element, color) {
                                element.style.backgroundColor = color;
                            }
                        </script>
                        <script>
                            function growAndHighlight(element) {
                                element.style.transform = 'scale(1.1)';
                                element.style.transition = 'transform 0.3s ease';
                                element.style.color = 'darkcyan';
                            }

                            function resetStyles(element) {
                                element.style.transform = 'scale(1)';
                                element.style.color = '';
                                element.style.transition = '';
                            }
                        </script>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <section id="details-container">
        <section id="details-section">
            <?php
            function displayDetailSection($title, $data, $iconClass)
            {
                if (is_array($data)) {
                    echo "<h3><i class='bi {$iconClass}'></i> {$title}</h3>";
                    foreach ($data as $detail) {
                        $sentences = explode("<br>", $detail);
                        echo "<ul class='custom-bullet-list'>";
                        foreach ($sentences as $sentence) {
                            echo "<li> {$sentence}</li>";
                        }
                        echo "</ul>";
                    }
                }
            }

            displayDetailSection("Visa Price Includes", unserialize($visaDetails['visa_price_includes']), 'fas fa-ticket-alt');
            displayDetailSection("Documents Required", unserialize($visaDetails['documents_required']), 'bi-file-earmark-text');
            displayDetailSection("Visa FAQs", unserialize($visaDetails['visa_faqs']), 'bi-question-circle');
            displayDetailSection("Steps to Get Visa", unserialize($visaDetails['steps_to_get_visa']), 'bi-check-circle');
            displayDetailSection("Visa Requirements", unserialize($visaDetails['visa_requirements']), 'bi-file-earmark-check');
            displayDetailSection("Travel Checklist", unserialize($visaDetails['travel_checklist']), 'bi-list-check');
            displayDetailSection("What to Do When Arrive", unserialize($visaDetails['what_to_do_when_arrive']), 'bi-info-circle');
            displayDetailSection("Travel Guide", unserialize($visaDetails['travel_guide']), 'bi-book');
            displayDetailSection("Reasons for Rejection", unserialize($visaDetails['reasons_for_rejection']), 'bi-x-circle');
            displayDetailSection("Services Terms Conditions", unserialize($visaDetails['services_terms_conditions']), 'bi-file-earmark-text');
            ?>

        </section>
    </section>
    <?php include "footer.php"; ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>