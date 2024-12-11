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

// جلب الإستعلام حسب نوع الفلتر المطبق من ملف script.js
$data = json_decode(file_get_contents("php://input"), true);

$sql = $data['sql'];

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // إنشاء مصفوفة لتخزين المنتجات التي تم جلبها من قاعدة البيانات لعرضها لاحقاً
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    // التحقق من وجود منتجات في المصفوفة
    if (empty($products)) {
        echo '<h5 class="text-center text-secondary w-100">There are no products right now. Come again later!</h5>';
    } else {
        // عرض المنتجات في الصفحة

        foreach ($products as $row) {

            if ($row['is_favorite'] === "1") {
                $fav = 'fa-solid'; // using this for icon class as add to favorite
            } else {
                $fav = 'fa-regular'; // using this for icon class as not favorite
            }
            
            $rating = (int)$row['average_rating'];

            echo '
            <div class="col">
                <!-- تعيين معرف المنتج في الرابط لإسترجاعه لاحقاً عند الضغط عليه -->
                <a href="product.php?id=' . $row['id'] . '" class="btn m-0 border-0 rounded-0 text-start" data-id="' . $row['id'] . '" style="width: 19rem;">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/' . $row['main_photo'] . '" alt="" class="card-img-top">
                            <span class="badge position-absolute m-2 top-0 start-0 bg-warning">New</span>
                        </div>
                        <div class="card-body">
                            <h6>'; 
                            // applying number of stars for product rating
                            for ($i = 1; $i <= 5; $i++) {
                                $starClass = ($i <= $rating) ? 'fa-solid' : 'fa-regular';
                                echo '<i class="' . $starClass . ' fa-star"></i>';
                            }

                            // continue show the product details in the same card
                            echo '<small class="text-secondary">(' . $row['comment_count'] . ' Reviews)</small>
                            </h6>
                            <h5 class="card-title">' . $row['title'] . '</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold mb-0">$' . $row['price'] . '</h6>
                                <button class="add-fav-btn btn px-0 border-0" data-id="' . $row['id'] . '" role="button">
                                    <i class="' . $fav . ' fa-heart" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            ';
        }
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}