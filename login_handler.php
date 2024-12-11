<?php
include 'db_connect.php';

// استلام البيانات من النموذج
$email = $_POST['email'];
$password = $_POST['password'];

// استعلام لجلب بيانات المستخدم
$result = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

if ($result->num_rows > 0) {
    // إذا تم العثور على المستخدم
    $user = $result->fetch_assoc();
    if ($password == $user['password']) {
        // بدء جلسة وتخزين بيانات المستخدم
        session_start();
        $_SESSION['user'] = $user;
    
        // إعادة توجيه إلى index.php
        header("Location: index.php");
        exit();
    } else {
        // إذا كانت كلمة المرور غير صحيحة
        echo "كلمة المرور غير صحيحة!";
    }
} else {
    // إذا كانت بيانات الدخول غير صحيحة
    echo "بيانات الدخول غير صحيحة!";
}

$conn->close();