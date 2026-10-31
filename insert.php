
<?php
include("db.php");

// Check if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get submitted form values
    $productid = isset($_POST["product_id"]) ? (int)$_POST["product_id"] : 0;
    $qty = isset($_POST["Qty"]) ? (int)$_POST["Qty"] : 0;
    $user = trim($_POST["User"] ?? "");
    $contact = trim($_POST["Contact"] ?? "");

    // Validate inputs
    if ($productid <= 0 || $qty <= 0 || $user === "" || $contact === "") {
        die("Invalid order. Please complete all required fields.");
    }

    // Get product details from fruitsandvegs table
    $sql = "SELECT Fruit, Unit, Price
            FROM fruitsandvegs
            WHERE Productid = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Database error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $productid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // Check if product exists
    if (!$product) {
        die("Product not found.");
    }

    // Get product information
    $fruit = $product["Fruit"];
    $unit = $product["Unit"];
    $price = (float)$product["Price"];

    // Calculate total price
    $total = $price * $qty;

    // Insert order into orders table
    $sql = "INSERT INTO orders
            (ProductID, Fruit, Qty, Unit, Price, Total, `User`, Contact)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Database error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isisddss",
        $productid,
        $fruit,
        $qty,
        $unit,
        $price,
        $total,
        $user,
        $contact
    );

    // Save order
    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Redirect after successful order
        header("Location: index.php?success=1");
        exit();

    } else {

        echo "Error placing order: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
    }

} else {

    // Prevent direct access
    header("Location: index.php");
    exit();
}

?>
