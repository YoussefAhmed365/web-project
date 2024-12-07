<?php
require 'db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 30 * 24 * 60 * 60,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

if (isset($_SESSION['user_id']) && isset($_COOKIE['PHPSESSID'])) {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['firstname'] = htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8');
        $_SESSION['lastname'] = htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8');
        $_SESSION['email'] = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
    }
    $stmt->close();
}