<?php
include 'db_connect.php';

// استلام البيانات من النموذج
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

// التحقق من أن البريد الإلكتروني غير مستخدم مسبقًا
$sql_check = "SELECT * FROM users WHERE email = '$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // إذا كان البريد الإلكتروني موجودًا بالفعل
    echo "البريد الإلكتروني مستخدم مسبقًا!";
} else {
    // إدخال بيانات المستخدم الجديد إلى قاعدة البيانات
    $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // إذا تم التسجيل بنجاح، التوجيه إلى صفحة تسجيل الدخول
        header("Location: login.php");
        exit();
    } else {
        // إذا حدث خطأ أثناء الإدخال
        echo "حدث خطأ أثناء التسجيل: " . $conn->error;
    }
}

$conn->close();