document.addEventListener("DOMContentLoaded", () => {
    // إظهار اللودر حتى انتهاء تحميل جميع الأجزاء
    const loader = document.getElementById("loader");
    const content = document.getElementById("content");
  
    // الانتظار حتى يتم تحميل الصفحة بالكامل (بما في ذلك الصور والمصادر)
    window.addEventListener("load", () => {
      // إخفاء اللودر بعد تحميل الصفحة بالكامل
      loader.style.display = "none";
  
      // عرض المحتوى بعد انتهاء التحميل
      content.style.display = "block";
    });
});