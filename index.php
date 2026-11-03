
<?php
include("db.php");

// Get products from database
$sql = "SELECT * FROM fruitsandvegs ORDER BY Productid ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Palengke Kiosk | Fresh Market</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        :root {
            --green: #198754;
            --dark-green: #14532d;
            --light-green: #e9f7ef;
            --mint: #f4fbf6;
            --text-dark: #26382d;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7faf7;
            color: var(--text-dark);
            margin: 0;
        }

        /* NAVBAR */

        .navbar {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .navbar-brand img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 10px;
        }

        .navbar-brand span {
            color: var(--dark-green);
            font-weight: 800;
        }

        .navbar-nav .nav-link {
            color: #52665a;
            font-weight: 500;
            margin-left: 20px;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--green);
        }

        /* HERO SECTION */

        .hero {
            background: linear-gradient(
                120deg,
                #14532d,
                #198754,
                #4caf75
            );
            color: white;
            padding: 75px 20px;
            border-radius: 0 0 35px 35px;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.2;
        }

        .hero p {
            color: #e3f5e9;
            font-size: 15px;
            max-width: 550px;
            line-height: 1.8;
        }

        .hero-btn {
            background: white;
            color: var(--dark-green);
            border: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .hero-btn:hover {
            background: #e6f4eb;
            color: var(--dark-green);
            transform: translateY(-3px);
        }

        .hero-image {
            width: 100%;
            max-width: 390px;
            height: 280px;
            object-fit: contain;
        }

        /* SECTION HEADINGS */

        .section-label {
            color: var(--green);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .section-title {
            color: var(--dark-green);
            font-weight: 800;
            font-size: 30px;
        }

        .section-description {
            color: #78877d;
            font-size: 14px;
        }

        /* SEARCH BAR */

        .search-box {
            background: white;
            border: 1px solid #dce9df;
            border-radius: 30px;
            padding: 5px 18px;
            display: flex;
            align-items: center;
            max-width: 400px;
            width: 100%;
        }

        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            padding: 10px;
            font-family: inherit;
            font-size: 13px;
        }

        .search-box span {
            color: var(--green);
            font-size: 20px;
        }

        /* PRODUCT CARDS */

        .product-card {
            background: white;
            border: 1px solid #e4eee6;
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            transition: 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 12px 25px rgba(25, 135, 84, 0.12);
            border-color: #b7dfc4;
        }

        .product-image-wrapper {
            background: var(--mint);
            margin: 12px;
            border-radius: 15px;
            height: 185px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 15px;
            transition: 0.3s;
        }

        .product-card:hover .product-image {
            transform: scale(1.06);
        }

        .product-info {
            padding: 10px 18px 18px;
        }

        .product-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 16px;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .product-unit {
            color: #87958b;
            font-size: 12px;
        }

        .product-price {
            color: var(--green);
            font-size: 19px;
            font-weight: 800;
        }

        .btn-order {
            background: var(--green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 11px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-order:hover {
            background: var(--dark-green);
            color: white;
            transform: translateY(-2px);
        }

        /* MODAL */

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            background: var(--dark-green);
            color: white;
            padding: 18px 22px;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-body {
            background: #f7fbf8;
            padding: 25px;
        }

        .modal-product-image {
            height: 190px;
            width: 100%;
            object-fit: contain;
            background: var(--light-green);
            border-radius: 15px;
            padding: 15px;
        }

        .form-label {
            color: #43584a;
            font-weight: 600;
            font-size: 13px;
        }

        .form-control {
            border: 1px solid #d8e7dc;
            border-radius: 10px;
            padding: 11px;
            font-size: 13px;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 0.2rem rgba(25,135,84,0.12);
        }

        /* ABOUT SECTION */

        .about-section {
            background: white;
            padding: 60px 20px;
            border-radius: 25px;
        }

        .about-icon {
            background: var(--light-green);
            color: var(--green);
            width: 55px;
            height: 55px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin: 0 auto 15px;
        }

        .about-card h5 {
            color: var(--dark-green);
            font-weight: 700;
            font-size: 16px;
        }

        .about-card p {
            color: #78877d;
            font-size: 13px;
            line-height: 1.8;
        }

        /* CONTACT */

        .contact-section {
            background: var(--light-green);
            padding: 45px 20px;
            border-radius: 25px;
        }

        .contact-section a {
            color: var(--dark-green);
            text-decoration: none;
            font-weight: 600;
        }

        /* FOOTER */

        footer {
            background: #123d26;
            color: #d8e9dd;
            padding: 30px 15px;
            margin-top: 70px;
            text-align: center;
        }

        footer a {
            color: #b7e4c7;
            text-decoration: none;
            font-size: 12px;
        }

        footer a:hover {
            color: white;
        }

        /* SUCCESS MESSAGE */

        .success-alert {
            border: none;
            background: #d9f3e2;
            color: #14532d;
            border-radius: 12px;
            padding: 15px;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .hero {
                padding: 50px 20px;
                text-align: center;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-image {
                height: 200px;
                margin-top: 25px;
            }

            .section-title {
                font-size: 24px;
            }

            .search-box {
                max-width: 100%;
            }

        }

    </style>

</head>

<body>

<!-- NAVIGATION BAR -->

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/logo.png" alt="Palengke Kiosk Logo">
            <span class="fs-4">Palengke Kiosk</span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse justify-content-end"
            id="navbarNav">

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#products">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- HERO SECTION -->

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <span class="badge bg-light text-success rounded-pill px-3 py-2 mb-3">
                    FRESH • LOCAL • AFFORDABLE
                </span>

                <h1>
                    Fresh Picks,<br>
                    Happy Living!
                </h1>

                <p class="mt-3">
                    Discover fresh fruits and vegetables at affordable
                    prices. Your favorite market essentials are just
                    a few clicks away!
                </p>

                <a href="#products" class="hero-btn mt-3">
                    Explore Products →
                </a>

            </div>

            <div class="col-lg-5 text-center">

                <img src="images/logo.png"
                    alt="Palengke Kiosk"
                    class="hero-image">

            </div>

        </div>

    </div>

</section>


<!-- PRODUCTS SECTION -->

<section id="products" class="container mt-5 pt-4">

    <div class="text-center mb-4">

        <span class="section-label">OUR MARKET</span>

        <h2 class="section-title mt-2">
            Fresh Fruits & Vegetables
        </h2>

        <p class="section-description">
            Choose your favorite fresh produce from our collection.
        </p>

    </div>


    <!-- SUCCESS MESSAGE -->

    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>

        <div class="alert success-alert text-center mb-4">
            <strong>✓ Order placed successfully!</strong>
            Thank you for shopping with Palengke Kiosk.
        </div>

    <?php } ?>


    <!-- SEARCH BAR -->

    <div class="d-flex justify-content-center mb-4">

        <div class="search-box">

            <span>⌕</span>

            <input type="text"
                id="searchProduct"
                placeholder="Search fruits and vegetables...">

        </div>

    </div>


    <!-- PRODUCT DISPLAY -->

    <div class="row g-4" id="productContainer">

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="col-6 col-md-4 col-lg-3 product-item"
                    data-name="<?php echo htmlspecialchars(strtolower($row['Fruit'])); ?>">

                    <div class="product-card">

                        <!-- PRODUCT IMAGE -->

                        <div class="product-image-wrapper">

                            <img
                                src="images/<?php echo htmlspecialchars($row['Image']); ?>.png"
                                alt="<?php echo htmlspecialchars($row['Fruit']); ?>"
                                class="product-image"
                                onerror="this.onerror=null; this.src='images/logo.png';">

                        </div>


                        <!-- PRODUCT DETAILS -->

                        <div class="product-info">

                            <div class="product-name">
                                <?php echo htmlspecialchars($row['Fruit']); ?>
                            </div>

                            <div class="product-unit mb-2">
                                Per <?php echo htmlspecialchars($row['Unit']); ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <span class="product-price">
                                    ₱<?php echo number_format((float)$row['Price'], 2); ?>
                                </span>

                            </div>


                            <!-- ADD TO CART BUTTON -->

                            <button
                                type="button"
                                class="btn btn-order w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#product-id-<?php echo (int)$row['Productid']; ?>">

                                + Add to Cart

                            </button>

                        </div>

                    </div>


                    <!-- ORDER MODAL -->

                    <div class="modal fade"
                        id="product-id-<?php echo (int)$row['Productid']; ?>"
                        tabindex="-1"
                        aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title fw-bold">
                                        Place Your Order
                                    </h5>

                                    <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>

                                </div>


                                <div class="modal-body">

                                    <div class="text-center mb-4">

                                        <img
                                            src="images/<?php echo htmlspecialchars($row['Image']); ?>.png"
                                            alt="<?php echo htmlspecialchars($row['Fruit']); ?>"
                                            class="modal-product-image"
                                            onerror="this.onerror=null; this.src='images/logo.png';">

                                        <h5 class="fw-bold mt-3">
                                            <?php echo htmlspecialchars($row['Fruit']); ?>
                                        </h5>

                                        <h4 class="product-price">
                                            ₱<?php echo number_format((float)$row['Price'], 2); ?>
                                        </h4>

                                    </div>


                                    <!-- ORDER FORM -->

                                    <form action="insert.php" method="POST">

                                        <input type="hidden"
                                            name="product_id"
                                            value="<?php echo (int)$row['Productid']; ?>">


                                        <div class="mb-3">

                                            <label class="form-label">
                                                Price
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                value="₱<?php echo number_format((float)$row['Price'], 2); ?>"
                                                readonly>

                                        </div>


                                        <div class="mb-3">

                                            <label class="form-label">
                                                Quantity (<?php echo htmlspecialchars($row['Unit']); ?>)
                                            </label>

                                            <input type="number"
                                                class="form-control"
                                                name="Qty"
                                                min="1"
                                                step="1"
                                                placeholder="Enter quantity"
                                                required>

                                        </div>


                                        <div class="mb-3">

                                            <label class="form-label">
                                                Buyer's Name
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                name="User"
                                                placeholder="Enter your full name"
                                                maxlength="225"
                                                required>

                                        </div>


                                        <div class="mb-3">

                                            <label class="form-label">
                                                Mobile Number
                                            </label>

                                            <input type="tel"
                                                class="form-control"
                                                name="Contact"
                                                placeholder="09XXXXXXXXX"
                                                maxlength="20"
                                                required>

                                        </div>


                                        <button type="submit"
                                            class="btn btn-order w-100 mt-2">

                                            Confirm Order

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="col-12">

                <div class="alert alert-warning text-center">
                    No products available at the moment.
                </div>

            </div>

        <?php } ?>

        <div class="col-12 text-center d-none" id="noProducts">
            <p class="text-muted mt-4">
                No matching products found.
            </p>
        </div>

    </div>

</section>


<!-- ABOUT US SECTION -->

<section id="about" class="container mt-5 pt-4">

    <div class="about-section shadow-sm">

        <div class="text-center mb-5">

            <span class="section-label">GET TO KNOW US</span>

            <h2 class="section-title mt-2">
                About Palengke Kiosk
            </h2>

            <p class="section-description mx-auto"
                style="max-width: 650px;">

                Palengke Kiosk is your local marketplace where
                convenience meets community. We bring fresh and
                affordable goods straight from the market to
                your fingertips.

            </p>

        </div>


        <div class="row text-center g-4">

            <div class="col-md-4">

                <div class="about-card">

                    <div class="about-icon">
                        🌱
                    </div>

                    <h5>Fresh Products</h5>

                    <p>
                        Enjoy a selection of fruits and vegetables
                        for your everyday needs.
                    </p>

                </div>

            </div>


            <div class="col-md-4">

                <div class="about-card">

                    <div class="about-icon">
                        💚
                    </div>

                    <h5>Affordable Prices</h5>

                    <p>
                        Shop conveniently with products offered
                        at reasonable prices.
                    </p>

                </div>

            </div>


            <div class="col-md-4">

                <div class="about-card">

                    <div class="about-icon">
                        🛒
                    </div>

                    <h5>Easy Shopping</h5>

                    <p>
                        Browse our products and place your orders
                        through our simple online kiosk.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- CONTACT SECTION -->

<section id="contact" class="container mt-5 pt-4">

    <div class="contact-section text-center">

        <span class="section-label">WE'RE HERE TO HELP</span>

        <h2 class="section-title mt-2">
            Get in Touch
        </h2>

        <p class="section-description mb-4">
            Have questions or feedback? We'd love to hear from you!
        </p>

        <div class="row justify-content-center g-3">

            <div class="col-md-4">

                <div class="bg-white rounded-4 p-3">

                    <div class="fs-3 mb-2">✉</div>

                    <h6 class="fw-bold">Email Us</h6>

                    <a href="mailto:contact@palengkekiosk.com">
                        contact@palengkekiosk.com
                    </a>

                </div>

            </div>


            <div class="col-md-4">

                <div class="bg-white rounded-4 p-3">

                    <div class="fs-3 mb-2">☎</div>

                    <h6 class="fw-bold">Call Us</h6>

                    <a href="tel:+639123456789">
                        +63 912 345 6789
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- FOOTER -->

<footer>

    <div class="container">

        <h4 class="fw-bold text-white">
            Palengke Kiosk
        </h4>

        <p class="small">
            Freshness and convenience at your fingertips.
        </p>

        <hr class="border-light opacity-25">

        <p class="small mb-2">
            &copy; <?php echo date("Y"); ?>
            Palengke Kiosk. All Rights Reserved.
        </p>

        <div>

            <a href="#">Privacy Policy</a>
            &nbsp; | &nbsp;

            <a href="#">Terms of Service</a>
            &nbsp; | &nbsp;

            <a href="#contact">Contact Us</a>

        </div>

    </div>

</footer>


<!-- SEARCH FUNCTION -->

<script>

    const searchInput = document.getElementById("searchProduct");
    const products = document.querySelectorAll(".product-item");
    const noProducts = document.getElementById("noProducts");

    searchInput.addEventListener("input", function() {

        const searchValue = this.value.toLowerCase().trim();

        let visibleCount = 0;

        products.forEach(function(product) {

            const productName = product.dataset.name;

            if (productName.includes(searchValue)) {

                product.classList.remove("d-none");
                visibleCount++;

            } else {

                product.classList.add("d-none");

            }

        });

        if (visibleCount === 0) {
            noProducts.classList.remove("d-none");
        } else {
            noProducts.classList.add("d-none");
        }

    });

</script>


<!-- BOOTSTRAP JAVASCRIPT -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
