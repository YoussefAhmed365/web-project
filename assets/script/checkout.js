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

// search button
const searchButton = document.getElementById('searchButton');
const searchContainer = document.querySelector('.search-container');
const searchInput = document.getElementById('searchInput');

searchButton.addEventListener('click', () => {
    searchContainer.classList.toggle('expanded');
    searchInput.focus(); // Focus on the input field
});

// Hide input when clicked outside
document.addEventListener('click', (e) => {
    if (!searchContainer.contains(e.target)) {
        searchContainer.classList.remove('expanded');
    }
});

// favouraite button
const favBtn = document.getElementById("favButton");
const favBox = document.getElementById("favBox");

favBtn.addEventListener("click", (f) => {
    f.stopPropagation();
    toggleFavBox();
    if (cartBox.style.display === "block") {
        toggleCartBox();
    }
});

favBox.addEventListener("click", (f) => {
    f.stopPropagation();
});

document.addEventListener("click", (f) => {
    if (!favBox.contains(f.target) && favBox.style.display === "block") {
        favBox.style.display = "none";
    }
});

function toggleFavBox() {
    if (favBox.style.display === "block") {
        favBox.style.display = "none";
    } else {
        favBox.style.display = "block";
    }
}

// cart button
const cartBox = document.getElementById("cartBox");
const cartBtn = document.getElementById("cartButton");

// إظهار أو إخفاء الصندوق عند الضغط على الزر
cartBtn.addEventListener("click", (e) => {
    e.stopPropagation(); // منع انتشار الحدث إلى العناصر الخارجية
    toggleCartBox();
    if (favBox.style.display === "block") {
        toggleFavBox();
    }
});

// منع إغلاق الصندوق عند النقر داخله
cartBox.addEventListener("click", (e) => {
    e.stopPropagation();
});

// إغلاق الصندوق عند النقر خارج الصندوق
document.addEventListener("click", (e) => {
    if (!cartBox.contains(e.target) && cartBox.style.display === "block") {
        cartBox.style.display = "none";
    }
});

function toggleCartBox() {
    if (cartBox.style.display === "block") {
        cartBox.style.display = "none";
    } else {
        cartBox.style.display = "block";
    }
}

/*Body*/
document.querySelectorAll(".quantity").forEach(quantityContainer => {
    const minusBtn = quantityContainer.querySelector(".minus");
    const plusBtn = quantityContainer.querySelector(".plus");
    const inputBox = quantityContainer.querySelector(".input-box");

    updateButtonStates();
    updateOrderSummary(); // تحديث الإجمالي عند تحميل الصفحة لأول مرة

    quantityContainer.addEventListener("click", handleButtonClick);
    inputBox.addEventListener("input", handleQuantityChange);

    function updateButtonStates() {
        const value = parseInt(inputBox.value);
        minusBtn.disabled = value <= 1;
        plusBtn.disabled = value >= parseInt(inputBox.max);
    }

    function handleButtonClick(event) {
        if (event.target.classList.contains("minus")) {
            decreaseValue();
        } else if (event.target.classList.contains("plus")) {
            increaseValue();
        }
    }

    function decreaseValue() {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : Math.max(value - 1, 1);
        inputBox.value = value;
        updateButtonStates();
        handleQuantityChange();
    }

    function increaseValue() {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
        inputBox.value = value;
        updateButtonStates();
        handleQuantityChange();
    }

    function handleQuantityChange() {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : value;

        // تحديث السعر الإجمالي لكل عنصر
        const price = parseFloat(
            quantityContainer.closest("tr").querySelector("td:nth-child(2)").textContent.replace("$", "")
        );
        const totalCell = quantityContainer.closest("tr").querySelector("td:last-child");
        totalCell.textContent = `$${(price * value).toFixed(2)}`;

        // تحديث ملخص الطلب
        updateOrderSummary();
    }

    function updateOrderSummary() {
        let subtotal = 0;

        // حساب الإجمالي الفرعي (Subtotal) بجمع كل أسعار المنتجات
        document.querySelectorAll("tbody tr").forEach(row => {
            const totalCell = row.querySelector("td:last-child");
            subtotal += parseFloat(totalCell.textContent.replace("$", ""));
        });

        // تحديث القيم في صفحة HTML
        document.getElementById("subtotal").textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById("total").textContent = `$${subtotal.toFixed(2)}`; // إذا لم يكن هناك رسوم شحن إضافية
    }
});

const couponBtn = document.getElementById("couponBtn");
const couponArrow = document.getElementById("couponArrow");

couponBtn.addEventListener("click", () => {
    couponArrow.classList.toggle("rotate");
});