<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php';

header('Content-Type: application/json');

// تعديل موقع session_set_cookie_params ليكون قبل session_start
session_set_cookie_params([
    'lifetime' => isset($_POST['rememberMe']) ? 2592000 : 0, // 30 يوم أو مدة الجلسة الافتراضية
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(["type" => "danger", "message" => "Invalid CSRF Token"], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $email = trim($_POST['email']);
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email)) {
        echo json_encode(["type" => "warning", "message" => "Please provide a valid email address"], JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (empty($password)) {
        echo json_encode(["type" => "warning", "message" => "Please enter your password"], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (!empty($user['password']) && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];

            if (isset($_POST['rememberMe'])) {
                setcookie(session_name(), session_id(), time() + 2592000, "/", "", isset($_SERVER['HTTPS']), true);
            }

            echo json_encode(["type" => "success", "redirect" => "index.php"]);
        } else {
            echo json_encode(["type" => "danger", "message" => "Email or password is incorrect"], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode(["type" => "info", "message" => "This account does not exist. Sign up if you don't have an account"], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
}