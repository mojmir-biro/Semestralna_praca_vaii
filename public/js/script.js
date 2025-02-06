class ProductGetter {

    async #getProducts() {
        document.getElementById("searchButton").onclick=this.filterProducts.bind(this);
        let response = await fetch(
            "?c=product&a=getJson",
            {
                method: "POST",
                headers: { // Set headers for JSON communication
                    "Content-type": "application/json", // Send JSON
                    "Accept" : "application/json", // Accept only JSON as response
                }
            });
        return await response.json();
    }

    async #getProductSizes(id) {
        let response = await fetch(
            `?c=product&a=getSizesJson&id=${id}`,
            {
                method: "POST",
                headers: { // Set headers for JSON communication
                    "Content-type": "application/json", // Send JSON
                    "Accept" : "application/json", // Accept only JSON as response
                }
            });
        return await response.json();
    }

    async filterProducts() {
        let products = await this.#getProducts();

        let checkboxesSize = document.querySelectorAll('input[name="sizes"]:checked');
        let checkboxesColour = document.querySelectorAll('input[name="colours"]:checked');
        let textfield = document.getElementById("searchTextfield");
        
        let sizes = [];
        let colours = [];
        checkboxesSize.forEach(size => {
            sizes.push(size);
        });
        checkboxesColour.forEach(colour => {
            colours.push(colour);
        });

        let filterBySize = sizes.length > 0;
        let filterByColour = colours.length > 0;
        let filterByName = textfield.value !== "";

        let result = [];
        if (filterByName) {
            products.forEach(product => {
                let name = product.name.toUpperCase();
                let substr = textfield.value.toUpperCase();
                if (name.includes(substr)) result.push(product);
            });
            products = result;
            result = [];
        }

        if (filterByColour) {
            products.forEach(product => {
                let isOfSelectedColour = false;
                colours.forEach(colour => {
                    isOfSelectedColour = isOfSelectedColour || product.colour === colour.value;
                });
                if (isOfSelectedColour) result.push(product);
            });
            products = result;
            result = [];
        }

        if (filterBySize) {
            for (let i = 0; i < products.length; i++) {
                const product = products[i];
                let productSizes = await this.#getProductSizes(product.id);
                let isAvailableInSize = false;
                for (let j = 0; j < sizes.length; j++) {
                    const selectedSize = sizes[j];
                    for (let k = 0; k < productSizes.length; k++) {
                        const availableSize = productSizes[k];
                        isAvailableInSize = isAvailableInSize || (availableSize.quantity > 0 && availableSize.size === selectedSize.value);
                        
                    }
                }
                if (isAvailableInSize) {
                    result.push(product);
                }
            }
            products = result;
            result = [];
        }

        let grid = document.getElementById("productGrid");
        let stringHTML = "";
        let counter = 0;
        products.forEach(product => {
            stringHTML += `
            <a href="./?c=product&a=display&id=${product.id}">
                <div class="gridItem">
                    <img src="public/images/${product.thumbnail}" alt="${product.name}">
                    <p><span class="productName">${product.name}</span></p>
                    <p><span class="productPrice">${product.price}</span></p>
                </div>
            </a>
            `;
            counter++;
        });
        if (counter === 0) {
            stringHTML = 
            `
            <div class="noFilteredProducts">
                Filtrom nevyhovujú žiadne produkty
            </div>
            `;
        }
        grid.innerHTML = stringHTML;
    }
}

window.onload = function () {
    let productGetter = new ProductGetter();
    productGetter.filterProducts();
}