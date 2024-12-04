<form action="<?= $link->url('product.save') ?>" method="post">
    <input type="hidden" name="id" value="<?= @$data['product']?->getId() ?>">
    <label for="productName">Názov produktu:</label>
    <input required type="text" name="productName" id="productName" value="<?= @$data['product']?->getName() ?>">
    <label for="price">Cena:</label>
    <input required type="text" name="price" id="price" value="<?= @$data['product']?->getPrice() ?>">
    <label for="thumbnail">Titulný obrázok:</label>
    <input required type="text" name="thumbnail" id="thumbnail" value="<?= @$data['product']?->getThumbnail() ?>">
    <button type="submit">Pridať</button>
</form>