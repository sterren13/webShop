<?php include "cards.php"; ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <!--<link href="css/blue-theme.css" rel="stylesheet">-->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">Webshop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php
                        session_start();
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="./cart.php">Winkel Card</a></li>
                                    <li><a class="dropdown-item" href="./orders.php">Orders</a></li>
                                    <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                                </ul>
                            </div>
                        <?php } else { ?>
                        <a class="nav-link" href="./login.php">
                            <i class="fas fa-user"></i> Login
                        </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <div class="theme-toggle ms-2">
                <button id="themeToggle" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sun"></i>
                </button>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="container mt-4">
        <div class="content-wrapper">
            <h1>Welcome to Our Webshop!</h1>
            <hr>
            <p>Browse our collection and find what you need.</p>
            <div class="d-flex flex-wrap justify-content-center gap-4">
                <?php
                    $servername = "db";
                    $username = "webuser"; // TOD change to env variable (security risk)
                    $password = "webpassword"; // TOD change to env variable (security risk)
                    $database = "webshop";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error); // TODO: remove (security risk)
                    }

                    // get categorie from url parameter if exists
                    if (isset($_GET["category"])) {
                        $category = $_GET["category"];
                        // get all subcategories from main category
                        $sql = "SELECT * FROM Category WHERE id IN (SELECT sub_category_id FROM Categorys WHERE main_category_id = $category)"; // TDO: prevent sql injection
                    } else {
                        $sql = "SELECT * FROM Category WHERE id NOT IN (SELECT sub_category_id FROM Categorys)";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            renderCategoryCard($row["name"], $row["id"]);
                        }
                    } else {
                        echo "No categories found.";
                    }

                    $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 theme">
        <div class="container">
            <span class="text-muted">© 2023 Webshop. All rights reserved.</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script/themeToggle.js"></script>
</body>
</html>
