document.addEventListener("DOMContentLoaded", function() {
    const quantities = {};
    const cartTotalElement = document.querySelector(".mt-4 .border h4");
    const filterClothes = document.getElementById("filterClothes");
    const filterGoodies = document.getElementById("filterGoodies");
    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");
    const minPriceValue = document.getElementById("minPriceValue");
    const maxPriceValue = document.getElementById("maxPriceValue");
    const products = document.querySelectorAll(".product");

    function updateQuantityDisplay(itemId) {
        const quantityElement = document.getElementById(`quantity-${itemId}`);
        quantityElement.textContent = quantities[itemId] || 0;
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll(".product").forEach(product => {
            const itemId = product.querySelector("span").id.split("-")[1];
            const price = parseFloat(product.querySelector(".card-text").textContent.replace("€", ""));
            const quantity = quantities[itemId] || 0;
            total += price * quantity;
        });

        // Mettre à jour le total affiché dans le panier
        if (cartTotalElement) {
            cartTotalElement.textContent = `Total : ${total.toFixed(2)}€`;
        }
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

    // Fonction pour appliquer les filtres
    function applyFilters() {
        const selectedCategoryClothes = filterClothes.checked;
        const selectedCategoryGoodies = filterGoodies.checked;
        const min = parseInt(minPrice.value);
        const max = parseInt(maxPrice.value);

        products.forEach(product => {
            const category = product.getAttribute("data-category").toLowerCase();
            const price = parseFloat(product.querySelector(".card-text").textContent.replace("€", ""));
            const stock = parseInt(product.querySelector(".stock-text").textContent.replace("Stock : ", ""));

            // Vérifier si le produit est dans la fourchette de prix et correspond à la catégorie sélectionnée
            const inPriceRange = price >= min && price <= max;
            const isInCategory = (selectedCategoryClothes && category === "vetements") || 
                                 (selectedCategoryGoodies && category === "goodies") ||
                                 (!selectedCategoryClothes && !selectedCategoryGoodies); // Si aucun filtre n'est sélectionné

            if (isInCategory && inPriceRange) {
                product.style.display = "block";  // Afficher le produit
            } else {
                product.style.display = "none";   // Masquer le produit
            }
        });

        updateTotal();  // Mettre à jour le total après l'application des filtres
    }

    // Écouter les événements de changement des filtres
    filterClothes.addEventListener("change", applyFilters);
    filterGoodies.addEventListener("change", applyFilters);

    // Mise à jour de la fourchette de prix
    minPrice.addEventListener("input", function() {
        minPriceValue.textContent = minPrice.value + "€";
        applyFilters();
    });
    maxPrice.addEventListener("input", function() {
        maxPriceValue.textContent = maxPrice.value + "€";
        applyFilters();
    });

    // Initialiser l'affichage des produits selon les filtres et la fourchette de prix
    applyFilters();
});
