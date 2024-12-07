<?php
require 'auth.php';

$data = json_decode(file_get_contents('php://input'), true);
$itemId = isset($data['item_id']) ? $data['item_id'] : null;
$state = isset($data['state']) ? $data['state'] : null;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'You must login first to manage favorites']);
    exit;
}

if (!$itemId) {
    echo json_encode(['success' => false, 'message' => 'Missing Item ID']);
    exit;
}

if (!$state) {
    echo json_encode(['success' => false, 'message' => 'The state of favorite is missing']);
    exit;
}

if ($state === 'add') {
    $checkStmt = $conn->prepare("SELECT 1 FROM favorite WHERE user_id = ? AND item_id = ?");
    $checkStmt->bind_param("ii", $user_id, $itemId);
    $checkStmt->execute();
    $favoriteExists = $checkStmt->fetch();
    $checkStmt->close();

    if ($favoriteExists) {
        echo json_encode(['success' => false, 'message' => 'Item is already in favorites']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO favorite (user_id, item_id) VALUES (?, ?)");
} elseif ($state === 'remove') {
    $stmt = $conn->prepare("DELETE FROM favorite WHERE user_id = ? AND item_id = ?");
}

$stmt->bind_param("ii", $user_id, $itemId);


if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $stmt->error]); // Include DB error
}

$stmt->close();
$conn->close();