<?php
require 'auth.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['sql'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid input: Missing 'sql' parameter"]);
    exit;
}

$sql = $data['sql'];

try {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Database error: " . $stmt->error);
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    if (empty($products)) {
        echo '<h5 class="text-center text-secondary w-100">There are no products right now. Come again later!</h5>';
    } else {
        foreach ($products as $row) {
            $fav = (htmlspecialchars($row['is_favorite']) === "1") ? 'fa-solid' : 'fa-regular';
            $rating = (int)$row['average_rating'];

            echo '
            <div class="col">
                <a href="product.php?id=' . $row['id'] . '" class="btn m-0 border-0 rounded-0 text-start" data-id="' . $row['id'] . '" style="width: 19rem;">
                    <div class="card border-0 rounded-0">
                        <div class="card-img position-relative d-flex justify-content-center align-items-center overflow-hidden">
                            <img src="assets/img/' . htmlspecialchars($row['main_photo']) . '" alt="" class="card-img-top">
                            <span class="badge position-absolute m-2 top-0 start-0 bg-warning">New</span>
                        </div>
                        <div class="card-body">
                            <h6>'; 
                            for ($i = 1; $i <= 5; $i++) {
                                $starClass = ($i <= $rating) ? 'fa-solid' : 'fa-regular';
                                echo '<i class="' . $starClass . ' fa-star"></i>';
                            }
                            echo '<small class="text-secondary">(' . htmlspecialchars($row['comment_count']) . ' Reviews)</small>
                            </h6>
                            <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-text fw-bold mb-0">$' . htmlspecialchars($row['price']) . '</h6>
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
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}