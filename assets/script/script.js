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
const showProducts = (() => {
    const productsContainer = document.getElementById("productsContainer");
    const productBtns = document.querySelectorAll(".products-btn");

    const sqlQueries = {
        latestProducts: `SELECT i.id, i.title, i.price, i.main_photo,
            COUNT(c.id) AS comment_count,
            COALESCE(AVG(c.rating), 0) AS average_rating,
            EXISTS (
                SELECT 1
                FROM favorite AS f
                WHERE f.item_id = i.id AND f.user_id = ?
            ) AS is_favorite
        FROM items AS i
        LEFT JOIN comments AS c ON i.id = c.item_id
        GROUP BY i.id, i.title, i.price, i.main_photo
        ORDER BY i.created_at DESC
        LIMIT 8`,
        topRating: `SELECT i.id, i.title, i.price, i.main_photo,
            COUNT(c.id) AS comment_count,
            COALESCE(AVG(c.rating), 0) AS average_rating,
            EXISTS (
                SELECT 1
                FROM favorite AS f
                WHERE f.item_id = i.id AND f.user_id = ?
            ) AS is_favorite
        FROM items AS i
        LEFT JOIN comments AS c ON i.id = c.item_id
        GROUP BY i.id, i.title, i.price, i.main_photo
        ORDER BY average_rating DESC
        LIMIT 8`,
        bestSelling: `SELECT i.id, i.title, i.price, i.main_photo,
            COUNT(c.id) AS comment_count,
            COALESCE(AVG(c.rating), 0) AS average_rating,
            EXISTS (
                SELECT 1
                FROM favorite AS f
                WHERE f.item_id = i.id AND f.user_id = ?
            ) AS is_favorite
        FROM items AS i
        LEFT JOIN comments AS c ON i.id = c.item_id
        GROUP BY i.id, i.title, i.price, i.main_photo
        ORDER BY i.sold DESC
        LIMIT 8`
    };

    const fetchProducts = async (queryKey = 'latestProducts') => {
        const query = sqlQueries[queryKey];
        if (!query) {
            console.error("Invalid filter selected.");
            return;
        }

        try {
            const response = await fetch("show-products.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ sql: query })
            });

            if (!response.ok) {
                const errorData = await response.json(); // Get error details from server
                throw new Error(`${response.status} ${response.statusText}: ${errorData.message}`);
            }

            productsContainer.innerHTML = await response.text();

        } catch (error) {
            console.error("Error loading products:", error);
            productsContainer.innerHTML = '<h5 class="text-center text-secondary w-100">Error loading products. Please try again later.</h5>';
        }
    };

    productBtns.forEach((button) => {
        button.addEventListener("click", () => {
            const queryKey = button.dataset.query;
            fetchProducts(queryKey);
            productBtns.forEach(btn => btn.classList.remove('active-btn'));
            button.classList.add('active-btn');
        });
    });

    fetchProducts();
})();

document.addEventListener('click', function (event) {  // Event delegation
    if (event.target.closest('.add-fav-btn')) {   // Use closest() to handle clicks on the icon within the button as well.
        const button = event.target.closest('.add-fav-btn');
        const itemId = button.dataset.id;
        const icon = button.querySelector("i");
        let state = '';

        if (icon.classList.contains("fa-regular")) {
            state = 'add';
        } else {
            state = 'remove';
        }
        
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");

        fetch("fav_handler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ item_id: itemId, state: state })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                icon.classList.toggle("fa-regular");
                icon.classList.toggle("fa-solid");
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error("Error adding/removing favorite:", error);
        });
    }
});