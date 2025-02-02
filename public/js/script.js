class ProductGetter {

    async #getProducts() {
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

    async showProducts() {
        document.getElementById("searchButton").onclick=this.filterProducts.bind(this);
        let products = await this.#getProducts();
        let grid = document.getElementById("productGrid");
        let stringHTML = "";
        products.forEach(product => {
            stringHTML += `
            <a href="./?c=product&a=display&id=${product.id}">
                <div class="gridItem">
                    <img src="public/images/${product.thumbnail}" alt="${product.name}">
                    <p><span class="productName">${product.name}</span></p>
                    <p><span class="productPrice">${product.price}</span></p>
                </div>
            </a>
            `
        });
        grid.innerHTML = stringHTML;
    }

    async filterProducts() {
        let products = await this.#getProducts();
        let checkboxesSize = document.querySelectorAll('input[name="sizes"]:checked');
        let checkboxesColour = document.querySelectorAll('input[name="colours"]:checked');
        let sizes = [];
        let colours = [];
        let result = [];
        checkboxesSize.forEach(size => {
            sizes.push(size);
        });
        checkboxesColour.forEach(colour => {
            colours.push(colour);
        });

        products.forEach(product => {
            if (colours.length > 0) {
                let isOfSelectedColour = false;
                colours.forEach(colour => {
                    isOfSelectedColour = isOfSelectedColour || product.colour === colour.value;
                });
                if (isOfSelectedColour) result.push(product);
            } else {
                result.push(product);
            }
        });

        let grid = document.getElementById("productGrid");
        let stringHTML = "";
        result.forEach(product => {
            stringHTML += `
            <a href="./?c=product&a=display&id=${product.id}">
                <div class="gridItem">
                    <img src="public/images/${product.thumbnail}" alt="${product.name}">
                    <p><span class="productName">${product.name}</span></p>
                    <p><span class="productPrice">${product.price}</span></p>
                </div>
            </a>
            `
        });
        grid.innerHTML = stringHTML;
    }
}

window.onload = function () {
    let productGetter = new ProductGetter();
    productGetter.showProducts();
}