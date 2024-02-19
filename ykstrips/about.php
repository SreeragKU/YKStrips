<?php
include "conn.php";

// Fetch all categories for navigation
$categorySqlNav = "SELECT * FROM categories";
$categoryResultNav = $conn->query($categorySqlNav);

// Fetch categories with at least one package
$categorySqlPackages = "SELECT DISTINCT c.* FROM categories c
                        JOIN packagedetails pd ON c.id = pd.category_id";
$categoryResultPackages = $conn->query($categorySqlPackages);

// Fetch packages with category information
$sqlPackages = "SELECT pd.*, c.category_name FROM packagedetails pd
                JOIN categories c ON pd.category_id = c.id";
$resultPackages = $conn->query($sqlPackages);

// Fetch the categories into an array for navigation
$categoriesNav = [];
while ($row = $categoryResultNav->fetch_assoc()) {
    $categoriesNav[] = $row;
}

// Fetch the categories into an array for packages
$categoriesPackages = [];
while ($row = $categoryResultPackages->fetch_assoc()) {
    $categoriesPackages[] = $row;
}
?>

<?php
include "conn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["fullName"];
    $email = $_POST["email"];

    $targetDir = "CV/";
    $targetFile = $targetDir . basename($_FILES["resume"]["name"]);

    move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile);

    $insertSql = "INSERT INTO job_applications (full_name, email, resume_path) 
                  VALUES ('$full_name', '$email', '$targetFile')";

    if ($conn->query($insertSql) === TRUE) {
        header("Location: thank_you.php");
        exit();
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YKSTRIPS ABOUT US</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <style>
        .logo-img {
            max-width: 250px;
            border-radius: 50%;
            padding: 5px;
            transition: max-width 0.5s ease-in-out;
        }

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
            /* Add padding for better spacing */
        }

        .category-slider {
            max-width: 100%;
            overflow: hidden;
        }

        .category-card {
            max-width: 100%;
            text-align: center;
        }

        .category-card img {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
        }

        .slider-val-container {
            overflow: hidden;
            position: relative;
        }

        .slider-val-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-val-item2 {
            flex: 0 0 100%;
        }

        .slider-val-item2 img {
            width: 100%;
            height: auto;
        }

        .slider-val-item {
            flex: 0 0 100%;
        }

        .slider-val-item img {
            width: 100%;
            height: auto;
        }

        .slider-val-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-val-control {
            cursor: pointer;
            padding: 10px;
            background-color: #333;
            color: #fff;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #357bae;
            font-size: 1.8em;
        }
    </style>
    <style>
        @media only screen and (max-width: 767px) {
            .d-flex .btn span {
                display: none;
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

            .category-card img {
                max-width: 30px;
                max-height: 30px;
            }

            .logo-img {
                max-width: 250px;
                border-radius: 50%;
                padding: 5px;
                transition: max-width 0.5s ease-in-out;
            }

            .slider-cat-container {
                width: 100%;
                overflow: hidden;
                position: relative;
                margin-left: auto;
                margin-right: auto;
            }

            .slider-item {
                width: 100%;
                margin-right: 0;
            }

            .category-slider {
                display: none;
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
            background-image: url('img/background-2.png');
            background-repeat: repeat;
            background-size: 300px 300px;
            background-position: center center;
        }

        .owl-prev,
        .owl-next {
            display: none !important;
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


    <!-- Navbar & Hero Start -->
    <div><?php include "header.php"; ?></div>
    <div class="container-fluid py-5 mb-5 hero-header" style="background-image: url('img/pexels-saifcom-7086906.jpg'); background-size: cover; width: 100%;">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown" style="font-size: 2.5em;">OUR MISSION</h1>
                    <p class="display-3  mb-3 animated slideInDown" style="font-size: 3.5em; color: #357bae;  text-shadow: 2px 2px 0px white, -2px -2px 0px white, 2px -2px 0px white, -2px 2px 0px white;">Make your travel</p>
                    <p class="display-3  mb-3 animated slideInDown" style="font-size: 3.5em; color: #357bae;  text-shadow: 2px 2px 0px white, -2px -2px 0px white, 2px -2px 0px white, -2px 2px 0px white;">more seamless.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="container text-center mb-4">
                <img class="img-fluid" src="img/about.png" alt="Logo" style="max-width: 200px;">
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-3 text-center mb-4">
                    <h2 class="display-4 text-primary mb-2">500+</h2>
                    <p class="lead mb-0">Happy Customers</p>
                </div>
                <div class="col-lg-3 text-center mb-4">
                    <h2 class="display-4 text-primary mb-2">70+</h2>
                    <p class="lead mb-0">Destinations</p>
                </div>
                <div class="col-lg-3 text-center mb-4">
                    <h2 class="display-4 text-primary mb-2">30+</h2>
                    <p class="lead mb-0">Activities</p>
                </div>
                <div class="col-lg-3 text-center mb-4">
                    <h2 class="display-4 text-primary mb-2">40,000+</h2>
                    <p class="lead mb-0">YKS FAMILY</p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Value Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="slider-val-container">
                <div class="slider-val-wrapper">
                    <!-- Replace these paths with your image paths -->
                    <div class="slider-val-item">
                        <img src="img/v1.png" alt="Value 1">
                    </div>
                    <div class="slider-val-item">
                        <img src="img/v2.png" alt="Value 2">
                    </div>
                    <div class="slider-val-item">
                        <img src="img/v3.png" alt="Value 3">
                    </div>
                    <div class="slider-val-item">
                        <img src="img/v4.png" alt="Value 4">
                    </div>
                    <div class="slider-val-item">
                        <img src="img/v5.png" alt="Value 5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Value End -->
    <script>
        let currentIndex = 0;

        function nextSlide() {
            currentIndex = (currentIndex + 1) % document.querySelectorAll('.slider-val-item').length;
            updateSlider();
        }

        function updateSlider() {
            const sliderWrapper = document.querySelector('.slider-val-wrapper');
            const itemWidth = document.querySelector('.slider-val-item').offsetWidth;

            sliderWrapper.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
        }

        // Automatically slide every 3 seconds (adjust as needed)
        setInterval(nextSlide, 3000);
    </script>


    <!-- Our Journey Start -->
    <div class="text-center py-5" style="margin-left: 20px; margin-right: 20px;">
        <h1 class="display-3 mb-4" style="font-size: 2.5em; border-bottom: 2px solid #007bff;">Our Journey</h1>
        <p class="lead" style="font-size: 1.5em; color: #555;">
            In the heart of our travel haven, we started by exploring with loved ones and sharing the joy on social media.
            When we hit 10,000 followers in 2023, we realized our duty was to make travel effortless and magical.
            So, we built a charming space dedicated to crafting seamless and unforgettable journeys.
            The best part? Our travelers, enchanted by our first adventure, now choose only us for their next escapade.
            We carefully pick destinations and assemble a friendly team, ensuring each trip is a simple yet beautiful memory.
        </p>W
    </div>
    <!-- Our Journey End -->
    <div class="slider-val-item2">
        <img src="img/employ.png" alt="Value 4">
    </div>

    <!-- Apply Now Button -->
    <div class="text-center py-4">
        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#applyNowModal">Apply Now</button>
    </div>

   <!-- Apply Now Modal -->
<div class="modal fade" id="applyNowModal" tabindex="-1" aria-labelledby="applyNowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyNowModalLabel">Apply Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your application form here -->
                <form action="#" method="post" enctype="multipart/form-data">
                    <!-- Basic details inputs -->
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" pattern="[A-Za-z ]{1,}" title="Please enter a valid name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" title="Please enter a valid email address" required>
                    </div>

                    <!-- CV/Resume upload -->
                    <div class="mb-3">
                        <label for="resume" class="form-label">Upload CV/Resume (PDF or DOCX only)</label>
                        <input type="file" class="form-control" id="resume" name="resume" accept=".pdf, .doc, .docx" required>
                        <small id="fileHelp" class="form-text text-muted">Supported formats: PDF, DOC, DOCX</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>




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