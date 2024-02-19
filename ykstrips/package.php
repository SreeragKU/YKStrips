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
            /* Add padding for better spacing */
        }

        .logo-img {
            max-width: 250px;
            border-radius: 50%;
            padding: 5px;
            transition: max-width 0.5s ease-in-out;
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

        nav.navbar {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <style>
        @media only screen and (max-width: 767px) {
            .social-icons {
                display: none;
                /* Hide social media icons on small screens */
            }

            .navbar-brand img {
                max-width: 70px;
                width: 50px;
            }

            .container-xxl {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 50%;
            }

            .container {
                width: 50%;
            }

            .category-slider {
                width: 50%;
                order: 2;
            }

            .category-card img {
                max-width: 30px;
                max-height: 30px;
            }

            .slider-item {
                margin-right: 5px;
            }

            .logo-img {
                max-width: 250px;
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

            .btn-primary {
                color: #ffffff;
                background-color: #007bff;
                font-size: 1.8em;
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



    <div style="background-color: white; width: 100%">
        <?php include "header.php"; ?>
    </div>

    <!-- Package Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <?php foreach ($categoriesPackages as $category) : ?>
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h2 class="section-title bg-white text-center text-primary px-3" style="margin-top: 30px; margin-bottom: 30px;">
                        <?php echo $category['category_name']; ?>
                    </h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php
                    // Loop through the query result for each category
                    while ($row = $resultPackages->fetch_assoc()) {
                        // Check if the package belongs to the current category
                        if ($row['category_id'] == $category['id']) {
                            $discountPercentage = ($row['package_price'] - $row['discount_price']) / $row['package_price'] * 100;
                            $packageID = $row['id'];
                    ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s" style="background-color: white; border-radius: 15px; overflow: hidden;">
                                <div class="package-item">
                                    <div class="overflow-hidden">
                                        <a class="position-relative d-block overflow-hidden" href="package_details.php?id=<?php echo base64_encode($packageID); ?>">
                                            <img class="img-fluid" src="<?php echo $row['package_image']; ?>" alt="" style="width: 100%; height: 300px; object-fit: cover; border-radius: 15px 15px 0 0;">
                                        </a>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>
                                            <?php echo $row['no_of_days']; ?> days
                                        </small>
                                        <small class="flex-fill text-center py-2"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                            <?php echo $row['locations']; ?>
                                        </small>
                                    </div>
                                    <div class="text-center p-4">
                                        <div class="bg-white text-success fw-bold py-1 px-2" style="font-size: 20px;">
                                            <?php echo $row['package_name']; ?>
                                        </div>
                                        <div class="bg-white text-danger fw-bold py-1 px-2">
                                            <?php echo number_format($discountPercentage, 0) . '% OFF'; ?>
                                        </div>
                                        <h3 class="mb-0">₹
                                            <?php echo number_format($row['discount_price'], 2); ?>
                                        </h3>
                                        <h6 class="mb-0"><s>₹
                                                <?php echo number_format($row['package_price'], 2); ?>
                                            </s></h6>
                                        <div class="mb-3">
                                        </div>
                                        <!-- ... -->
                                        <div class="d-flex justify-content-center mb-2">
                                            <!-- &nbspCall Us button with icon for larger screens -->
                                            <a href="tel:+919074460902" class="btn btn-sm btn-primary px-2 border-end d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                                <i class="fas fa-phone me-1" style="font-size: 0.8em; transform: rotate(90deg); margin-right: 30px;"></i>&nbsp;&nbsp;Call
                                                Us
                                            </a>

                                            <!-- WhatsApp button with icon for larger screens -->
                                            <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                                <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em; margin-right: 3px;">Chat on Whatsapp
                                            </a>

                                            <!-- &nbspCall Us icon-only button for smaller screens -->
                                            <a href="tel:+919074460902" class="btn btn-sm btn-primary px-2 border-end d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                                <i class="fas fa-phone" style="font-size: 0.8em; transform: rotate(90deg);"></i>
                                            </a>

                                            <!-- WhatsApp icon-only button for smaller screens -->
                                            <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                                <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em;">
                                            </a>
                                        </div>

                                        <script>
                                            function changeBackgroundColor(element, color) {
                                                element.style.backgroundColor = color;
                                            }
                                        </script>
                                        <!-- ... -->


                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    // Reset the result pointer after each category
                    $resultPackages->data_seek(0);
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Package End -->



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