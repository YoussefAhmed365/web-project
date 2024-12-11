<?php
include 'db_connect.php';

session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// عرض بيانات المستخدم
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Shop.com</title>
</head>
<body>
    <div class="loader-container" id="loader">
        <div class="loader"></div>
    </div>
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <div class="collapse navbar-collapse d-lg-flex">
                    <!-- navbar logo -->
                    <a class="navbar-brand col-lg-3 me-0 fw-medium" href="index.php">Shop.com</a>

                    <!-- navbar links -->
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

                        <!-- search section -->
                        <div class="search-container d-flex align-items-center">
                            <button class="search-btn btn btn-light rounded-circle" id="searchButton">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <input type="text" class="form-control search-input ms-2" id="searchInput" placeholder="Search...">
                        </div>

                        <!-- favourite section -->
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
                                        <a href="#" class="text-decoration-none text-secondary">Show All</a>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <div class="fav-products row row-cols-1">                                    
                                    <div class="fav-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product1.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <h6 class="title">Product 1 Title Goes Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fav-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product2.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <h6 class="title">Product 2 Title Goes Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fav-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product3.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <h6 class="title">Product 3 Title Goes Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fav-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product4.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <h6 class="title">Product 4 Title Goes Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- cart section -->
                        <div class="position-relative">
                            <button class="cart btn btn-light rounded-circle" id="cartButton">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </button>
                            <div class="cart-box bg-white rounded-3 border border-1 border-dark mt-3 p-2 position-absolute z-3" id="cartBox">
                                <h5 class="text-center my-2">Cart</h5>
                                <hr class="mb-2">
                                <div class="cart-products row row-cols-1">
                                    <div class="cart-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product1.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <h6 class="title">Product 1 Title Goes Here</h6>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                                        <small class="text-secondary">Quantity: 1</small>
                                                        <small class="text-secondary">$250</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product2.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <h6 class="title">Product 2 Title Goes Here</h6>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                                        <small class="text-secondary">Quantity: 2</small>
                                                        <small class="text-secondary">$100</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-product col px-3">
                                        <div class="row g-1">
                                            <div class="col-4 p-2 overflow-hidden">
                                                <img src="assets/img/product3.jpg" alt="" width="80px" height="80px" style="object-fit: cover;">
                                            </div>
                                            <div class="col p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <h6 class="title">Product 3 Title Goes Here</h6>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                                        <small class="text-secondary">Quantity: 1</small>
                                                        <small class="text-secondary">$237</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-dark py-3 rounded-1 w-100 h-100">CHECKOUT</button>
                            </div>
                        </div>

                        <!-- user profileButton -->
                        <div class="position-relative">
                            <?php
                            if (isset($_SESSION['user'])) {
                                ?>
                                <a href="#" class="profile btn btn-light rounded-circle" id="profileButton">
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

        <!-- header -->
        <div class="container">
            <header class="d-flex flex-column justify-content-center align-items-center gap-3 p-5 rounded-4 mb-5" style="background-image: url(assets/img/banner-bg.jpg);">
                <h1 class="text-white fs-1 fw-bold">Shop.com</h1>
                <p class="text-white fs-5 text-center mt-4 mx-auto w-75" style="line-height: 1.7rem;" id="banner-text">Explore The Latest Products & Offers With A Wide Varaity Of Categories.</p>
            </header>

            <!-- categories -->
            <div class="row mb-3">
                <div class="col-6">
                    <h3 class="categories-title position-relative">Browse Categories</h3>
                </div>
                <div class="col-6">
                    <a href="#" class="text-decoration-none text-secondary float-end">Show All</a>
                </div>
            </div>
            <section class="categories-cards d-flex justify-content-start align-items-center gap-3 mb-5">
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-person-running fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Sport Assets</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-laptop fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Smart Devices</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-car-side fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Car Accessories</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-tv fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">TV & Home Theater</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-headphones-simple fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Audio & Headphones</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-dumbbell fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Fitness & Gym Equipment</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-tree fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Gardening & Outdoor</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-palette fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Arts & Crafts</h6>
                    </div>
                </button>
                <button class="card bg-light rounded-4 border-0 text-dark">
                    <div class="card-body row gy-3">
                        <i class="fa-solid fa-chess-knight fs-3 col-12 d-flex justify-content-center align-items-center"></i>
                        <h6 class="text-center col-12">Games & Toys</h6>
                    </div>
                </button>
            </section>

            <!-- photos section -->
            <section class="gallery row justify-content-center gap-1 mb-5">
                <!-- الصورة الأولى تأخذ 4 أعمدة -->
                <div class="col-3">
                    <div class="gallery-img h-100 p-0 m-0" style="background-image: url('assets/img/img6.webp');"></div>
                </div>
                <!-- الصور الأربعة الأخرى تأخذ 8 أعمدة -->
                <div class="col-8">
                    <div class="row gap-3 h-100">
                        <!-- الصف الأول -->
                        <div class="col-12">
                            <div class="row gap-3 h-100">
                                <div class="gallery-img col-4 p-0 m-0" style="background-image: url('assets/img/img2.webp');"></div>
                                <div class="gallery-img col-7 p-0 m-0" style="background-image: url('assets/img/img3.webp');"></div>
                            </div>
                        </div>
                        <!-- الصف الثاني -->
                        <div class="col-12">
                            <div class="row gap-3 h-100">
                                <div class="gallery-img col-7 p-0 m-0" style="background-image: url('assets/img/img4.jpg');"></div>
                                <div class="gallery-img col-4 p-0 m-0" style="background-image: url('assets/img/img5.webp');"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Section -->
            <section class="hot mb-5">
                <div class="row mb-3">
                    <div class="col-6">
                        <h3 class="position-relative">Products</h3>
                    </div>
                    <div class="col-6">
                        <a href="#" class="text-decoration-none text-secondary float-end">Show All</a>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                    
                        <!-- Nav for products filter -->
                        <ul class="menu" id="menu">
                            <li>
                                <button class="products-btn btn border-0 active-btn" data-query="latestProducts">Latest Products</button>
                            </li>
                            <li>
                                <button class="products-btn btn border-0" data-query="topRating">Top Rating</button>
                            </li>
                            <li>
                                <button class="products-btn btn border-0" data-query="bestSelling">Best Selling</button>
                            </li>
                        </ul>
                    </div>

                    <!-- products container -->
                    <div class="col-12 d-flex justify-content-start align-items-center">
                        <div class="container">
                            <div class="products row row-cols-1 row-cols-sm-2 row-cols-md-4" id="productsContainer">
                                <!-- Products are shown here -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- subscribe section -->
            <section class="subscribe mx-5 mb-5 p-5" id="subscribe" style="background-image: url(assets/img/subscribe-bg.jpg);">
                <div class="d-flex gap-2 flex-column w-50 m-5">
                    <h5>Shop.com</h5>
                    <h3>Get Weekly Updates</h3>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control p-3" aria-label="Recipient's Email" aria-describedby="button-subscribe">
                        <button class="btn btn-default" type="button" id="button-subscribe">Subscribe</button>
                    </div>
                    <h6>www.online-shop.com</h6>
                </div>
            </section>

            <!-- Advertisements Section -->
            <section class="d-flex flex-column gap-4 g-5 mx-5 mb-5 p-5">
                <div class="row g-3 align-items-center">
                    <div class="col-4 ms-5">
                        <h1>Explore The World</h1>
                    </div>
                    <div class="ads col rounded-pill" style="background-image: url(assets/img/subscribe.jpg);height: 5rem;background-position: top;"></div>
                </div>
                <div class="ads rounded-pill" style="background-image: url(assets/img/subscribe.jpg);height: 5rem;"></div>
                <div class="row g-3 align-items-center">
                    <div class="ads col rounded-pill" style="background-image: url(assets/img/subscribe.jpg);height: 5rem;background-position: bottom;"></div>
                    <div class="col-5 me-5 text-end">
                        <h1>Of Online Shopping</h1>
                    </div>
                </div>
            </section>

            <!-- Footer Section -->
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
                <div class="col mb-3">
                    <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none fs-4 fw-medium text-dark">Shop.com</a>
                    <p class="text-body-secondary">© 2024</p>
                </div>
            
                <div class="col mb-3">
            
                </div>
            
                <div class="col mb-3">
                    <h5>Browse</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="index.php" class="nav-link p-0 text-body-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Earbuds</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Laptops</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Smart & Office</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5>FAQ & Support</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Support</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Contact</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Privacy Policy</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Terms Of Use</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5>Follow</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Facebook</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Instagram</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Twitter</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pinterest</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/35b8a1f8f5.js" crossorigin="anonymous"></script>
    <script src="assets/script/script.js"></script>
</body>
</html>