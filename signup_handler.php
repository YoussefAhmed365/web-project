<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['type' => 'danger', 'message' => 'Invalid CSRF token.'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        echo json_encode(['type' => 'danger', 'message' => 'Please fill all fields'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (isEmailExists($conn, $email)) {
        echo json_encode(['type' => 'warning', 'message' => 'Email already exists, please choose another email address'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        $id = $conn->insert_id; // استرجاع ID المستخدم
        
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        echo json_encode(['type' => 'success', 'message' => 'Your account has been successfully registered.', 'redirect' => 'index.php'], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['type' => 'danger', 'message' => 'There was an error registering your account.'], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
    $conn->close();
}

function isEmailExists($conn, $email) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['count'] > 0;
}