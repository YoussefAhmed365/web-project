document.addEventListener("DOMContentLoaded", () => {
    // إظهار اللودر حتى انتهاء تحميل جميع الأجزاء
    const loader = document.getElementById("loader");
    const content = document.getElementById("content");
    
    window.onload = () => {
        // إخفاء اللودر بعد تحميل الصفحة بالكامل
        loader.style.display = "none";
    
        // عرض المحتوى بعد انتهاء التحميل
        content.style.display = "block";

        // const elements = {
        //     cookiesCard: document.getElementById("cookie"),
        //     acceptButton: document.getElementById("acceptCookies"),
        //     rejectButton: document.getElementById("rejectCookies"),
        //     rememberMe: document.getElementById("rememberMe"),
        // };
    
        // const cookieUtils = {
        //     set(name, value, days) {
        //         let expires = "";
        //         if (days) {
        //             const date = new Date();
        //             date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        //             expires = "; expires=" + date.toUTCString();
        //         }
        //         document.cookie = `${name}=${value || ""}${expires}; path=/; Secure; HttpOnly; SameSite=Strict`;
        //     },
        //     get(name) {
        //         const nameEQ = name + "=";
        //         return document.cookie
        //             .split(";")
        //             .map(c => c.trim())
        //             .find(c => c.startsWith(nameEQ))
        //             ?.substring(nameEQ.length) || null;
        //     },
        // };
    
        // if (!cookieUtils.get("cookieConsent")) {
        //     elements.cookiesCard.style.display = "block";
        // }
    
        // const handleConsent = (consent) => {
        //     cookieUtils.set("cookieConsent", consent, 365);
        //     elements.cookiesCard.style.display = "none";
        //     console.log(`User ${consent === "true" ? "accepted" : "rejected"} cookies`);
        // };
    
        // elements.acceptButton?.addEventListener("click", () => handleConsent("true"));
        // elements.rejectButton?.addEventListener("click", () => handleConsent("false"));
    
        // elements.rememberMe?.addEventListener("click", () => {
        //     if (cookieUtils.get("cookieConsent") !== "true") {
        //         elements.cookiesCard.style.display = "block";
        //     }
        // });
    
        // elements.rejectButton?.addEventListener("click", () => {
        //     elements.rememberMe.checked = false;
        // });
    };
});

const form = document.getElementById("form");
const alertContainer = document.getElementById("alert-container");
const disablePage = document.getElementById("disable-page");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    
    fetch("login_handler.php", {
        method: "POST",
        body: new FormData(form),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("HTTP error! status: " + response.status);
        }
        return response.json();
    })
    .then((data) => {
        if (data.type === "success") {
            disablePage.style.opacity = "0.2";
            disablePage.style.pointerEvents = "all";
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } else {
            alertContainer.innerHTML = `
            <div class="alert alert-${data.type}" role="alert">${data.message}</div>`;
        }
    })
    .catch((error) => {
        console.error("Error submitting form:", error);
        alertContainer.innerHTML = `
        <div class="alert alert-danger" role="alert">Error, Try Again Later.</div>`;
    });
});