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

// Body
document.querySelectorAll(".quantity").forEach(quantityContainer => {
    const minusBtn = quantityContainer.querySelector(".minus");
    const plusBtn = quantityContainer.querySelector(".plus");
    const inputBox = quantityContainer.querySelector(".input-box");

    updateButtonStates();

    quantityContainer.addEventListener("click", handleButtonClick);

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
    }

    function increaseValue() {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
        inputBox.value = value;
        updateButtonStates();
    }
});

const productNavBtns = document.querySelectorAll(".product-nav-btn");
const productInfoContainer = document.getElementById("productInfoContainer");
const descriptionContent = document.getElementById("descriptionContent");
const commentsContent = document.getElementById("commentsContent");

productNavBtns.forEach(button => {
    button.addEventListener("click", () => {
        const contentToShow = button.dataset.content;

        // Check if the clicked button is already active
        if (button.classList.contains('active')) {
            return; // Do nothing if already active
        }

        productNavBtns.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Hide all content divs
        descriptionContent.style.display = "none";
        commentsContent.style.display = "none";
        
        // Show the selected content div
        if (contentToShow === 'description') {
            descriptionContent.style.display = "block";
        } else if (contentToShow === 'comments') {

            // If comments haven't been loaded yet, fetch them:
            if (commentsContent.innerHTML.trim() === '') {

                fetch(`get_comments.php?product_id=<?php echo $productId; ?>`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                  }
                  return response.text();
                })
                .then(commentsHtml => {
                  commentsContent.innerHTML = commentsHtml;
                  commentsContent.style.display = "block";
                })
                .catch(error => {
                    console.error("Error fetching comments:", error);
                    commentsContent.innerHTML = "<p>Error loading comments.</p>"; //Error handling and user message
                    commentsContent.style.display = "block";
                });
            } else {
                commentsContent.style.display = "block";
            }
        }
    });
});