<?php
require 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
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
            <h1 class="text-center text-dark mb-5">Your Cart</h1>
            <div class="row gx-4">
                <div class="col-8 products-table overflow-y-scroll">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="product-preveiw float-start w-100">
                                    <img src="assets/img/product1.jpg" alt="#">
                                    <div>
                                        <h5 class="mb-0 text-truncate">Product Name</h5>
                                        <h6 class="text-secondary text-truncate">Product Description</h6>
                                    </div>
                                </th>
                                <td>$281</td>
                                <td>
                                    <div class="quantity rounded-pill">
                                        <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">&minus;</button>
                                        <input type="number" class="input-box" value="1" min="1" max="99">
                                        <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">&plus;</button>
                                    </div>
                                </td>
                                <td>$281</td>
                            </tr>
                            <tr>
                                <th scope="row" class="product-preveiw float-start w-100">
                                    <img src="assets/img/product1.jpg" alt="#">
                                    <div>
                                        <h5 class="mb-0 text-truncate">Product Name</h5>
                                        <h6 class="text-secondary text-truncate">Product Description</h6>
                                    </div>
                                </th>
                                <td>$280</td>
                                <td>
                                    <div class="quantity rounded-pill">
                                        <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">&minus;</button>
                                        <input type="number" class="input-box" value="1" min="1" max="99">
                                        <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">&plus;</button>
                                    </div>
                                </td>
                                <td>$280</td>
                            </tr>
                            <tr>
                                <th scope="row" class="product-preveiw float-start w-100">
                                    <img src="assets/img/product1.jpg" alt="#">
                                    <div>
                                        <h5 class="mb-0 text-truncate">Product Name</h5>
                                        <h6 class="text-secondary text-truncate">Product Description</h6>
                                    </div>
                                </th>
                                <td>$280</td>
                                <td>
                                    <div class="quantity rounded-pill">
                                        <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">&minus;</button>
                                        <input type="number" class="input-box" value="1" min="1" max="99">
                                        <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">&plus;</button>
                                    </div>
                                </td>
                                <td>$280</td>
                            </tr>
                            <tr>
                                <th scope="row" class="product-preveiw float-start w-100">
                                    <img src="assets/img/product1.jpg" alt="#">
                                    <div>
                                        <h5 class="mb-0 text-truncate">Product Name</h5>
                                        <h6 class="text-secondary text-truncate">Product Description</h6>
                                    </div>
                                </th>
                                <td>$280</td>
                                <td>
                                    <div class="quantity rounded-pill">
                                        <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">&minus;</button>
                                        <input type="number" class="input-box" value="1" min="1" max="99">
                                        <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">&plus;</button>
                                    </div>
                                </td>
                                <td>$280</td>
                            </tr>
                            <tr>
                                <th scope="row" class="product-preveiw float-start w-100">
                                    <img src="assets/img/product1.jpg" alt="#">
                                    <div>
                                        <h5 class="mb-0 text-truncate">Product Name</h5>
                                        <h6 class="text-secondary text-truncate">Product Description</h6>
                                    </div>
                                </th>
                                <td>$280</td>
                                <td>
                                    <div class="quantity rounded-pill">
                                        <button class="minus btn btn-light border-0 rounded-0" aria-label="Decrease">&minus;</button>
                                        <input type="number" class="input-box" value="1" min="1" max="99">
                                        <button class="plus btn btn-light border-0 rounded-0" aria-label="Increase">&plus;</button>
                                    </div>
                                </td>
                                <td>$280</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="bg-light col-12 p-2">
                            <div class="price-box p-4">
                                <h4>Order Summary</h4>
                                <hr>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <h6 class="text-secondary">Subtotal</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h6 id="subtotal"></h6>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <h6 class="text-secondary">Shipping</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h6>Free</h6>
                                    </div>
                                </div>
                                <button class="btn text-success p-0 border-0" type="button" id="couponBtn" data-bs-toggle="collapse" data-bs-target="#collapseCoupon" aria-expanded="false" aria-controls="collapseCoupon">Add Coupon Code <i class="fa-solid fa-arrow-right" id="couponArrow"></i></button>
                                <div class="collapse" id="collapseCoupon">
                                    <input type="text" name="coupon" id="coupon" class="form-control focus-ring focus-ring-dark py-2 mt-2" id="coupon">
                                </div>
                            </div>
                            <div class="row my-4 mx-3">
                                <div class="col-6">
                                    <h3 class="mb-0">Total</h3>
                                </div>
                                <div class="col-6 text-end">
                                    <h4 id="total" class="mb-0"></h4>
                                </div>
                            </div>
                            <button class="col-12 btn btn-default py-3 rounded-0">CHECKOUT</button>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/35b8a1f8f5.js" crossorigin="anonymous"></script>
    <script src="assets/script/checkout.js"></script>
</body>
</html>