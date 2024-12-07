<?php
require 'auth.php';
$productId = isset($_GET['id']) ? intval($_GET['id']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/product.css">
    <title>Shop.com | Your Favourites</title>
</head>
<body>
    <div class="loader-container" id="loader">
        <div class="loader"></div>
    </div>
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg py-3" aria-label="Thirteenth navbar example">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                    <a class="navbar-brand col-lg-3 me-0 fw-medium" href="index.php">Shop.com</a>
                    <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Earbuds</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Wireless Stereo Earbuds</a></li>
                                <li><a class="dropdown-item" href="#">Wireless Over-ear Headphones</a></li>
                                <li><a class="dropdown-item" href="#">Open-ear Headphones</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Smart & Office</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Smart Watches</a></li>
                                <li><a class="dropdown-item" href="#">Smart Scales</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Support</a>
                        </li>
                    </ul>
    
                    <div class="d-lg-flex col-lg-3 justify-content-lg-end gap-1">
                        <div class="search-container d-flex align-items-center">
                            <button class="search-btn btn btn-light rounded-circle" id="searchButton">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <input type="text" class="form-control search-input ms-2" id="searchInput" placeholder="Search...">
                        </div>
                        <div class="position-relative">
                            <button class="favourite btn btn-light rounded-circle" id="favButton">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                            <div class="fav-box bg-white rounded-3 border border-1 border-dark mt-3 p-2 position-absolute z-3" id="favBox">
                                <div class="row align-items-center my-2 px-2">
                                    <div class="col-6">
                                        <h5 class="mb-0">Favourites</h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a href="fav.php" class="text-decoration-none text-secondary">Show All</a>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <div class="fav-products row row-cols-1">                                    
                                    <?php
                                    if (isset($user_id)) {
                                        $stmt = $conn->prepare("SELECT items.title, items.main_photo
                                        FROM favorite
                                        JOIN items ON favorite.item_id = items.id
                                        WHERE favorite.user_id = ?");
                                        $stmt->bind_param("i", $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $title = $row['title'];
                                                $photo = $row['main_photo'];
                                                ?>
                                                <div class="fav-product col px-3">
                                                    <div class="row g-1">
                                                        <div class="col-4 p-2 overflow-hidden">
                                                            <img src="assets/img/<?php echo htmlspecialchars($photo); ?>" alt="" width="80px" height="80px" style="object-fit: cover;">
                                                        </div>
                                                        <div class="col p-2">
                                                            <h6 class="title"><?php echo htmlspecialchars($title); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo '<h6 class="text-center w-100">No favourites yet</h6>';
                                        }
                                    } else {
                                        echo '<h6 class="text-center w-100">Sign in first to see your favourites</h6>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <button class="cart btn btn-light rounded-circle" id="cartButton">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </button>
                            <div class="cart-box bg-white rounded-3 border border-1 border-dark mt-3 p-2 position-absolute z-3" id="cartBox">
                                <h5 class="text-center my-2">Cart</h5>
                                <hr class="mb-2">
                                <div class="cart-products row row-cols-1">
                                    <?php
                                    if (isset($user_id)) {
                                        $stmt = $conn->prepare("SELECT cart.amount, items.title, items.main_photo, items.price
                                        FROM cart
                                        JOIN items ON cart.item_id = items.id
                                        WHERE cart.user_id = ?");
                                        $stmt->bind_param("i", $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
    
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $amount = $row['amount'];
                                                $title = $row['title'];
                                                $photo = $row['main_photo'];
                                                $price = $row['price'];
                                                ?>
                                                <div class="cart-product col px-3">
                                                    <div class="row g-1">
                                                        <div class="col-4 p-2 overflow-hidden">
                                                            <img src="assets/img/<?php echo htmlspecialchars($photo); ?>" alt="" width="80px" height="80px" style="object-fit: cover;">
                                                        </div>
                                                        <div class="col p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-12">
                                                                    <h6 class="title"><?php echo htmlspecialchars($title); ?></h6>
                                                                </div>
                                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                                    <small class="text-secondary">Quantity: <?php echo htmlspecialchars($amount); ?></small>
                                                                    <small class="text-secondary">$<?php echo htmlspecialchars($price); ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo '<h6 class="text-center w-100">Cart is empty</h6>';
                                        }
                                    } else {
                                        echo '<h6 class="text-center w-100">Sign in first to see your cart</h6>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <?php
                            if (isset($user_id)) {
                                ?>
                                <a href="account.php" class="profile btn btn-light rounded-circle" id="profileButton">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <div class="profile-popover bg-white rounded-3 border border-1 border-dark mt-2 p-3 position-absolute z-3" id="profilePopover">
                                    <h5>Hi, <?php echo $user['firstname']; ?></h5>
                                    <form action="logout.php" method="post">
                                        <button type="submit" class="btn d-flex justify-content-start align-items-center w-100"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
                                    </form>
                                </div>
                                <?php
                            } else {
                                ?>
                                <a href="login.php" class="profile btn btn-light rounded-circle" id="profileButton">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <div class="profile-popover bg-white rounded-3 border border-1 border-dark mt-2 p-2 position-absolute z-3" id="profilePopover">
                                    <span>Login</span>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <hr class="mb-5 mt-0">
        <div class="container">
            <?php
            $stmt = $conn->prepare("SELECT i.title, i.description, i.price, i.main_photo, i.photos, (i.amount - i.sold) AS available,
                COUNT(c.id) AS comment_count,
                COALESCE(AVG(c.rating), 0) AS average_rating
                FROM items AS i
                LEFT JOIN comments AS c ON c.item_id = i.id
                WHERE i.id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $title = htmlspecialchars($row['title']);
                $description = htmlspecialchars($row['description']);
                $price = htmlspecialchars($row['price']);
                $main_photo = htmlspecialchars($row['main_photo']);
                $photos = htmlspecialchars($row['photos']);
                $available = htmlspecialchars($row['available']);
                $comments = htmlspecialchars($row['comment_count']);
                $rating = (int)$row['average_rating'];
            ?>
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="products.html">Products</a></li>
                    <li class="breadcrumb-item active text-truncate" aria-current="page"><?php echo htmlspecialchars($title); ?></li>
                </ol>
            </nav>
            <div class="row g-4 mb-5">
                <div class="col-6">
                    <div class="row g-4">
                        <div class="col-2 d-flex flex-column align-items-center justify-content-start gap-3">
                            <button class="btn p-0 m-0 rounded-0 border-0">
                                <img src="assets/img/product3.jpg" alt="" class="object-fit-cover" width="80px" height="80px">
                            </button>
                            <button class="btn p-0 m-0 rounded-0 border-0">
                                <img src="assets/img/img2.jpg" alt="" class="object-fit-cover" width="80px" height="80px">
                            </button>
                            <button class="btn p-0 m-0 rounded-0 border-0">
                                <img src="assets/img/product4.jpg" alt="" class="object-fit-cover" width="80px" height="80px">
                            </button>
                        </div>
                        <div class="col-10">
                            <img src="assets/img/product3.jpg" alt="" class="object-fit-cover" width="100%" height="400px">
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-between">
                    <small class="text-secondary fw-medium">Category</small>
                    <h2 class="mb-3"><?php echo htmlspecialchars($title); ?></h2>
                    <h6 class="mb-4">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            $starClass = ($i <= $rating) ? 'fa-solid' : 'fa-regular';
                            echo '<i class="' . $starClass . ' fa-star"></i>';
                        }
                        ?>
                        <small class="text-secondary">(<?php echo htmlspecialchars($comments); ?> Reviews)</small>
                    </h6>
                    <h3 class="fw-bold mb-4">$<?php echo htmlspecialchars($price); ?></h3>
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6>Available: <small class="text-secondary"><?php echo htmlspecialchars($available); ?></small></h6>
                        </div>
                        <div class="col-6">
                            <h6>Shipping: <small class="text-secondary"><?php echo htmlspecialchars(($price >= 100)? 'This Product is Free Shipping' : "$20 Including VAT."); ?></small></h6>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <div class="quantity rounded-pill">
                                <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">−</button>
                                <input type="number" class="input-box" value="1" min="1" max="99">
                                <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-default w-100 py-3">Add to Cart</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center gap-2">
                        <span class="fw-bold">SHARE ON:</span>
                        <a href="https://facebook.com" class="text-decoration-none text-dark">
                            <i class="fa-brands fa-facebook fs-5" target="_blank" aria-hidden="true"></i>
                        </a>
                        <a href="https://instagram.com" class="text-decoration-none text-dark">
                            <i class="fa-brands fa-instagram fs-5" target="_blank" aria-hidden="true"></i>
                        </a>
                        <a href="https://twitter.com" class="text-decoration-none text-dark">
                            <i class="fa-brands fa-x-twitter fs-5" target="_blank" aria-hidden="true"></i>
                        </a>
                        <a href="https://whatsapp.com" class="text-decoration-none text-dark">
                            <i class="fa-brands fa-whatsapp fs-5" target="_blank" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5 my-5 ms-5 ps-4">
                <div class="col-9">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <button class="product-nav-btn nav-link text-dark active" data-content="description">Description</button>
                        </li>
                        <li class="nav-item">
                            <button class="product-nav-btn nav-link text-dark" data-content="comments">Reviews (<?php echo htmlspecialchars($comments); ?>)</button>
                        </li>
                    </ul>
                    <div class="mt-4 lh-base" id="productInfoContainer">
                        <div id="descriptionContent" class="active-content"><?php echo $description; ?></div>
                        <div id="commentsContent" style="display: none;">
                            <?php
                            $stmt = $conn->prepare("SELECT comments.*, users.firstname, users.lastname, users.profilephoto
                            FROM comments
                            JOIN users ON users.id = comments.user_id
                            WHERE comments.item_id = ?
                            ORDER BY comments.created_at");
                            $stmt->bind_param("i", $productId);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $comment = htmlspecialchars($row['comment']);
                                    $rating = htmlspecialchars($row['rating']);
                                    $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
                                    $updated_at = DateTime::createFromFormat('Y-m-d H:i:s', $row['updated_at']);
                                    $dateString = ($created_at->getTimestamp() === $updated_at->getTimestamp()) ? "Published at " : "Updated at ";
                                    $formattedDate = $updated_at->format("M d, Y"); //Use updated_at if different
                                    $name = htmlspecialchars($row['firstname'] . " " . $row['lastname']);
                                    $profile = (!empty($row['profilephoto'])) ? htmlspecialchars($row['profilephoto']) : 'default.png';
                                    ?>
                                    <div class="container">
                                        <div class="d-flex jsutify-content-start align-items-center gap-2 mb-2">
                                            <div class="rounded-circle d-flex justify-content-center align-items-center overflow-hidden">
                                                <img src="assets/img/profiles/<?php echo $profile; ?>" alt="" style="width: 3rem;">
                                            </div>
                                            <h5 class="mb-0"><?php echo $name; ?></h5>
                                        </div>
                                        <div class="mb-2">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                $starClass = ($i <= $rating) ? 'fa-solid' : 'fa-regular';
                                                echo '<i class="' . $starClass . ' fa-star"></i>';
                                            }
                                            ?>
                                        </div>
                                        <p class="mb-2"><?php echo $comment; ?></p>
                                        <small class="text-secondary fw-medium"><?php echo "$dateString $formattedDate"; ?></small>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <h5 class="mb-3">Additional Information</h5>
                    <small class="fw-bold">DIMENSIONS</small>
                    <h6 class="mb-3 text-secondary">25.7×37.5×1.2</h6>
                    <small class="fw-bold">WEIGHT</small>
                    <h6 class="text-secondary">0.75 lbs</h6>
                </div>
            </div>
            <?php
            } else {
                echo '<h5 class="w-100 text-center text-secondary">Sorry! We are working on this trouble right now or the page is not exist.</h5>';
            }
            ?>
            <h2>You may also like</h2>
            <div class="products row row-cols-2 row-cols-sm-3 row-cols-md-5 g-4 mt-5">
                <a class="col btn m-0 border-0 rounded-0 text-start">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/product1.jpg" alt="" class="card-img-top">
                            <span class="badge position-absolute m-2 top-0 start-0 bg-warning">New</span>
                        </div>
                        <div class="card-body">
                            <h6>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <small class="text-secondary">(357 Reviews)</small>
                            </h6>
                            <h5 class="card-title">Wireless Noise-Canceling Earbuds with Mic From Apple</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold"><del class="text-secondary fw-normal">$9.11</del>&nbsp;$7.99</h6>
                                <button href="#" class="btn" role="button"><i class="fa-solid fa-heart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col btn m-0 border-0 rounded-0 text-start">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/product2.jpg" alt="" class="card-img-top">
                            <span class="badge position-absolute m-2 top-0 end-0 bg-danger text-white">Most Popular</span>
                        </div>
                        <div class="card-body">
                            <h6>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <small class="text-secondary">(214 Reviews)</small>
                            </h6>
                            <h5 class="card-title">Sweatproof Sports Headphones with Secure Fit</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold">$14.80</h6>
                                <button href="#" class="btn" role="button"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col btn m-0 border-0 rounded-0 text-start">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/product3.jpg" alt="" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h6>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <small class="text-secondary">(1238 Reviews)</small>
                            </h6>
                            <h5 class="card-title">Ultra-Slim Lightweight Laptop with Powerful Processor</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold">$350</h6>
                                <button href="#" class="btn" role="button"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col btn m-0 border-0 rounded-0 text-start">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/product4.jpg" alt="" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h6>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <small class="text-secondary">(214 Reviews)</small>
                            </h6>
                            <h5 class="card-title">Touchscreen Laptop with High Resolution Display and Stylus</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold">$430</h6>
                                <button href="#" class="btn" role="button"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col btn m-0 border-0 rounded-0 text-start">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/product2.jpg" alt="" class="card-img-top">
                            <span class="badge position-absolute m-2 top-0 end-0 bg-danger text-white">Most Popular</span>
                        </div>
                        <div class="card-body">
                            <h6>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <small class="text-secondary">(214 Reviews)</small>
                            </h6>
                            <h5 class="card-title">Sweatproof Sports Headphones with Secure Fit</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold">$14.80</h6>
                                <button href="#" class="btn" role="button"><i class="fa-solid fa-heart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
                <div class="col mb-3">
                    <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none fs-4 fw-medium text-dark">Shop.com</a>
                    <p class="text-body-secondary">© 2024</p>
                </div>
            
                <div class="col mb-3">
            
                </div>
            
                <div class="col mb-3">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/35b8a1f8f5.js" crossorigin="anonymous"></script>
    <script src="assets/script/product.js"></script>
</body>
</html>