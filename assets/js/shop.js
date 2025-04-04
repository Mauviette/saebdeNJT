document.addEventListener("DOMContentLoaded", function() {
    const quantities = {};
    const cartTotalElement = document.querySelector(".mt-4 .border h4");
    const cartItemsList = document.getElementById("cart-items");
    const membershipInfo = document.getElementById("membership-info");
    let userRole =  "utilisateur";
    let discountRate = 1; 
    if (membershipInfo.textContent == "Adhésion au BDE -10%")
    {
        userRole = "utilisateur_adherent";
        discountRate = 0.9;
    }
    console.log("User role:", userRole);
    console.log("Discount rate:", discountRate);

    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");
    const minPriceValue = document.getElementById("minPriceValue");
    const maxPriceValue = document.getElementById("maxPriceValue");
    const products = document.querySelectorAll(".product");
    const filter = document.getElementsByClassName("filter");
    const filterNames = document.getElementsByClassName("filterName");
    const sliderTrack = document.querySelector(".slider-track");

    function updateQuantityDisplay(itemId) {
        const quantityElement = document.getElementById(`quantity-${itemId}`);
        quantityElement.textContent = quantities[itemId] || 0;
        updateTotal();
        updateCartDisplay();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll(".product").forEach(product => {
            const itemId = product.querySelector("span").id.split("-")[1];
            const price = parseFloat(product.querySelector(".card-text").textContent.replace("€", ""));
            const quantity = quantities[itemId] || 0;
            total += price * quantity;
        });

        total *= discountRate;
        cartTotalElement.textContent = `Total : ${total.toFixed(2)}€`;
    }

    function updateCartDisplay() {
        cartItemsList.innerHTML = "";
    
        Object.keys(quantities).forEach(itemId => {
            if (quantities[itemId] > 0) {
                const product = document.querySelector(`#quantity-${itemId}`).closest(".product");
                const productName = product.querySelector(".card-title").textContent;
                const productPrice = parseFloat(product.querySelector(".card-text").textContent.replace("€", ""));
                const totalPrice = (productPrice * quantities[itemId] * discountRate).toFixed(2);
    
                const listItem = document.createElement("div");
                listItem.classList.add("cart-item");
    
                const nameElement = document.createElement("span");
                nameElement.classList.add("cart-item-name");
                nameElement.textContent = productName;
    
                const priceElement = document.createElement("span");
                priceElement.classList.add("cart-item-price");
                priceElement.textContent = `${totalPrice}€`;
    
                const quantityElement = document.createElement("span");
                quantityElement.classList.add("cart-item-quantity");
                quantityElement.textContent = `${quantities[itemId]}x`;
    
                listItem.appendChild(nameElement);
                listItem.appendChild(priceElement);
                listItem.appendChild(quantityElement);
                cartItemsList.appendChild(listItem);
            }
        });
    }

    window.increaseQuantity = function(itemId, stock) {
        if (!quantities[itemId]) quantities[itemId] = 0;
        if (quantities[itemId] < stock) {
            quantities[itemId]++;
            updateQuantityDisplay(itemId);
        }
    };

    window.decreaseQuantity = function(itemId) {
        if (!quantities[itemId]) quantities[itemId] = 0;
        if (quantities[itemId] > 0) {
            quantities[itemId]--;
            updateQuantityDisplay(itemId);
        }
    };

    function applyFilters() {
        const min = parseInt(minPrice.value);
        const max = parseInt(maxPrice.value);
        let isCategorySelected = false;

        products.forEach(product => {
            const category = product.getAttribute("data-category").toLowerCase();
            const price = parseFloat(product.querySelector(".card-text").textContent.replace("€", ""));

            const inPriceRange = price >= min && price <= max;
            let isInCategory = false;

            for (let i = 0; i < filter.length; i++) {
                if (filter[i].checked) {
                    isCategorySelected = true;
                    if (category === filterNames[i].textContent.toLowerCase()) {
                        isInCategory = true;
                    }
                }
            }

            if ((isCategorySelected ? isInCategory : true) && inPriceRange) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });

        updateTotal();
    }

    function updateSliderTrack() {
        const min = parseInt(minPrice.value);
        const max = parseInt(maxPrice.value);
        const minPos = ((min - minPrice.min) / (minPrice.max - minPrice.min)) * 100;
        const maxPos = ((max - maxPrice.min) / (maxPrice.max - maxPrice.min)) * 100;
        
        sliderTrack.style.left = minPos + "%";
        sliderTrack.style.right = (100 - maxPos) + "%";
    }

    minPrice.addEventListener("input", function() {
        minPriceValue.textContent = minPrice.value + "€";
        updateSliderTrack();
        applyFilters();
    });

    maxPrice.addEventListener("input", function() {
        maxPriceValue.textContent = maxPrice.value + "€";
        updateSliderTrack();
        applyFilters();
    });

    for (let i = 0; i < filter.length; i++) {
        filter[i].addEventListener("change", applyFilters);
    }

    applyFilters();
    updateSliderTrack();
});