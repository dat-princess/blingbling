<?php
include("db.php");

// Get products from database
$sql = "SELECT * FROM fruitsandvegs";
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

    <title>Palengke Kiosk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8d7da;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white !important;
        }

        .navbar-brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            margin-right: 10px;
        }

        .card {
            height: 100%;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 180px;
            width: 100%;
            object-fit: contain;
            padding: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-price {
            color: #dc3545;
            font-weight: bold;
        }

        .btn-order {
            background-color: #dc3545;
            color: white;
        }

        .btn-order:hover {
            background-color: #bb2d3b;
            color: white;
        }

        .modal-product-img {
            height: 200px;
            width: 100%;
            object-fit: contain;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg border border-dark">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="images/logo.png" alt="Logo">
                <span class="h4 mb-0">Palengke Kiosk</span>
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>


    <!-- Products Section -->
    <div class="container mt-4">

        <h2 class="text-center mb-4">
            Fresh Fruits and Vegetables
        </h2>

        <!-- Success Message -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>

            <div class="alert alert-success text-center">
                Your order has been placed successfully!
            </div>

        <?php } ?>

        <!-- Products -->
        <div class="row">

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-12 col-md-6 col-lg-3 mt-4">

                        <div class="card border-dark rounded-4 shadow-sm">

                            <!-- Product Image -->
                            <img
                                src="images/<?php echo htmlspecialchars($row['Image']); ?>.png"
                                alt="<?php echo htmlspecialchars($row['Fruit']); ?>"
                                class="card-img-top"
                                onerror="this.onerror=null; this.src='images/logo.png';"
                            >

                            <div class="card-body d-flex justify-content-between align-items-center">

                                <span class="fs-5 product-price">
                                    ₱<?php echo number_format((float)$row['Price'], 2); ?>
                                </span>

                                <span class="fs-5 product-name">
                                    <?php echo htmlspecialchars($row['Fruit']); ?>
                                </span>

                            </div>

                            <div class="container mb-3">

                                <button
                                    type="button"
                                    class="btn btn-order w-100 rounded-5"
                                    data-bs-toggle="modal"
                                    data-bs-target="#product-id-<?php echo (int)$row['Productid']; ?>">

                                    Add to Cart

                                </button>

                            </div>

                        </div>


                        <!-- Product Order Modal -->
                        <div class="modal fade"
                            id="product-id-<?php echo (int)$row['Productid']; ?>"
                            tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header bg-danger-subtle">

                                        <h5 class="modal-title">
                                            Order Product
                                        </h5>

                                        <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>

                                    </div>


                                    <div class="modal-body bg-danger-subtle">

                                        <div class="card border-dark rounded-4">

                                            <img
                                                src="images/<?php echo htmlspecialchars($row['Image']); ?>.png"
                                                alt="<?php echo htmlspecialchars($row['Fruit']); ?>"
                                                class="modal-product-img"
                                                onerror="this.onerror=null; this.src='images/logo.png';"
                                            >

                                            <div class="card-body">

                                                <div class="d-flex justify-content-between mb-3">

                                                    <span class="fs-5 product-price">
                                                        ₱<?php echo number_format((float)$row['Price'], 2); ?>
                                                    </span>

                                                    <span class="fs-5 product-name">
                                                        <?php echo htmlspecialchars($row['Fruit']); ?>
                                                    </span>

                                                </div>


                                                <!-- Order Form -->
                                                <form action="insert.php" method="POST">

                                                    <!-- Product ID -->
                                                    <input
                                                        type="hidden"
                                                        name="product_id"
                                                        value="<?php echo (int)$row['Productid']; ?>"
                                                    >


                                                    <!-- Price -->
                                                    <div class="input-group mb-3">

                                                        <span class="input-group-text">
                                                            Price
                                                        </span>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="₱<?php echo number_format((float)$row['Price'], 2); ?>"
                                                            readonly
                                                        >

                                                    </div>


                                                    <!-- Quantity -->
                                                    <div class="input-group mb-3">

                                                        <span class="input-group-text">
                                                            Quantity
                                                        </span>

                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            name="Qty"
                                                            min="1"
                                                            step="1"
                                                            placeholder="Enter quantity"
                                                            required
                                                        >

                                                    </div>


                                                    <!-- Unit -->
                                                    <div class="input-group mb-3">

                                                        <span class="input-group-text">
                                                            Unit
                                                        </span>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="<?php echo htmlspecialchars($row['Unit']); ?>"
                                                            readonly
                                                        >

                                                    </div>


                                                    <!-- Buyer's Name -->
                                                    <div class="input-group mb-3">

                                                        <span class="input-group-text">
                                                            Buyer's Name
                                                        </span>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="User"
                                                            placeholder="Enter your name"
                                                            maxlength="225"
                                                            required
                                                        >

                                                    </div>


                                                    <!-- Mobile Number -->
                                                    <div class="input-group mb-3">

                                                        <span class="input-group-text">
                                                            Mobile Number
                                                        </span>

                                                        <input
                                                            type="tel"
                                                            class="form-control"
                                                            name="Contact"
                                                            placeholder="09XXXXXXXXX"
                                                            maxlength="20"
                                                            required
                                                        >

                                                    </div>


                                                    <!-- Submit -->
                                                    <button
                                                        type="submit"
                                                        name="submit"
                                                        class="btn btn-order w-100 mt-2 rounded-5">

                                                        Place Order

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No products available.
                    </div>
                </div>

            <?php } ?>

        </div>

    </div>


    <!-- About Us Section -->
    <section id="about" class="container mt-5">

        <h2 class="text-center mb-3">About Us</h2>

        <p class="text-center">
            Palengke Kiosk is your local marketplace where convenience
            meets community. We bring fresh and affordable goods straight
            from the market to your fingertips.
        </p>

    </section>


    <!-- Contact Us Section -->
    <section id="contact" class="container mt-5 mb-5">

        <h2 class="text-center mb-3">Contact Us</h2>

        <p class="text-center">
            Have questions or feedback? We'd love to hear from you!
        </p>

        <div class="text-center">

            <p>
                Email:
                <a href="mailto:contact@palengkekiosk.com">
                    contact@palengkekiosk.com
                </a>
            </p>

            <p>
                Phone:
                <a href="tel:+639123456789">
                    +63 912 345 6789
                </a>
            </p>

        </div>

    </section>


    <!-- Footer -->
    <footer>

        <div class="container">

            <p class="mb-1">
                &copy; <?php echo date("Y"); ?>
                Palengke Kiosk. All Rights Reserved.
            </p>

            <p class="mb-0">

                <a href="#">Privacy Policy</a> |

                <a href="#">Terms of Service</a> |

                <a href="mailto:contact@palengkekiosk.com">
                    Contact Us
                </a>

            </p>

        </div>

    </footer>


    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>