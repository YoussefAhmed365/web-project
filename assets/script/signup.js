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

const form = document.getElementById("form");
const alertContainer = document.getElementById("alert-container");
const disablePage = document.getElementById("disable-page");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    fetch("signup_handler.php", {
        method: "POST",
        body: new FormData(form),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        alertContainer.innerHTML = `
            <div class="alert alert-${data.type}" role="alert">${data.message}</div>`;
        
        if (data.type === "success") {
            disablePage.style.opacity = "0.2";
            disablePage.style.pointerEvents = "all";
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        }
    })
    .catch(error => {
        console.error("Error submitting form:", error);
        alertContainer.innerHTML = `
            <div class="alert alert-danger" role="alert">Error, Try Again Later.</div>`;
    });
});