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
        let products = await this.#getProducts();
        let grid = document.getElementById("productGrid");
        let stringHTML = "";
        products.forEach(element => {
            stringHTML += `
            <div class="gridItem">
                <img src="public/images/${element.thumbnail}" alt="${element.name}">
                <p><span class="productName">${element.name}</span></p>
                <p><span class="productPrice">${element.price}</span></p>
                <button>Pridať do košíka</button>
            </div>
            `
        });
        grid.innerHTML = stringHTML;
    }
}

window.onload = function () {
    let productGetter = new ProductGetter();
    productGetter.showProducts();
}