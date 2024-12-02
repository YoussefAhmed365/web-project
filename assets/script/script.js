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

const productBtn = document.querySelectorAll('.products-btn');

productBtn.forEach(button => {
  button.addEventListener("click", () => {
    productBtn.forEach(btn => {btn.classList.remove("active-btn")});
    button.classList.add("active-btn");
  })
});
