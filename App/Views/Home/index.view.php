<div class="filtersBar">
    <h1>FILTRE</h1>
    <form id="filtersForm">
        <div class="filtersItem">
            <input title="Názov produktu" type="text" id="searchTextfield" placeholder="Názov produktu">
        </div>
        <div class="filtersItem">
            <p>Veľkosti</p>
            <input type="checkbox" id="size_XS" name="sizes" value="XS">
            <label for="size_XS">XS</label><br>
            <input type="checkbox" id="size_S" name="sizes" value="S">
            <label for="size_S">S</label><br>
            <input type="checkbox" id="size_M" name="sizes" value="M">
            <label for="size_M">M</label><br>
            <input type="checkbox" id="size_L" name="sizes" value="L">
            <label for="size_L">L</label><br>
            <input type="checkbox" id="size_XL" name="sizes" value="XL">
            <label for="size_XL">XL</label><br>
        </div>
        
        <div class="filtersItem">
            <p>Farby</p>
            <input type="checkbox" id="colourPurple" name="colours" value="purple">
            <label for="colourPurple">fialová</label><br>
            <input type="checkbox" id="colourPink" name="colours" value="pink">
            <label for="colourPink">ružová</label><br>
            <input type="checkbox" id="colourBlue" name="colours" value="blue">
            <label for="colourBlue">modrá</label><br>
            <input type="checkbox" id="colourGreen" name="colours" value="green">
            <label for="colourGreen">zelená</label><br>
            <input type="checkbox" id="colourYellow" name="colours" value="yellow">
            <label for="colourYellow">žltá</label><br>
            <input type="checkbox" id="colourOrange" name="colours" value="orange">
            <label for="colourOrange">oranžová</label><br>
            <input type="checkbox" id="colourRed" name="colours" value="red">
            <label for="colourRed">červená</label><br>
            <input type="checkbox" id="colourWhite" name="colours" value="white">
            <label for="colourWhite">biela</label><br>
            <input type="checkbox" id="colourBlack" name="colours" value="black">
            <label for="colourBlack">čierna</label><br>
        </div>
        <button id="searchButton" type="submit">Hľadať</button>
    </form>   
</div>

<script src="/public/js/script.js"></script>

<div class="gridContainer" id="productGrid">
    
</div>