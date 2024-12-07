<?php
// بدء الجلسة
session_start();

// حذف جميع بيانات الجلسة
$_SESSION = [];

// حذف كوكي الجلسة عن طريق تحديد تاريخ انتهاء قديم
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', '', time() - 3600, '/'); // مسح الكوكي
}

// تدمير الجلسة الحالية
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول أو الصفحة الرئيسية
header('Location: index.php');
exit();