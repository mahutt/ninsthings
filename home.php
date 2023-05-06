<?php
// GETTING 6 MOST RECENT PRODUCTS
$query = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 6');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC); // FETCHING AS AN ASSOCIATIVE ARRAY
?>
<?=template_header("nin's")?>
<div class="products-wrapper">
    <?php foreach ($products as $product): ?>
    <div class="product">
        <div class="product-image-box">
            <div class="slider">    
                <img id="<?=$product['id']?>-image-1" src="products/<?=$product['img']?>/1.jpg" alt="" class="product-image">
                <img id="<?=$product['id']?>-image-2" src="products/<?=$product['img']?>/2.jpg" alt="" class="product-image">
                <img id="<?=$product['id']?>-image-3" src="products/<?=$product['img']?>/3.jpg" alt="" class="product-image">
            </div>
            <div class="slider-buttons">
                <a href="#<?=$product['id']?>-image-1"></a>
                <a href="#<?=$product['id']?>-image-2"></a>
                <a href="#<?=$product['id']?>-image-3"></a>
            </div>
        </div>  
        <div class="product-name"><?=$product['name']?></div>
        <div class="product-price">&dollar;<?=$product['price']?> CAD</div>
        <?php if ($product['size_quantity'] == "OUT OF STOCK"): ?>
            <br><div class="out-of-stock">OUT OF STOCK</div>
        <?php else: ?>
        <form id="form-<?=$product['id']?>" class="cart-form" action="index.php?page=cart" method="post" onsubmit="return validateCartForm(this)">
            <input name="product-id" type="hidden" value="<?=$product['id']?>">
            <div class="product-quantity">
                <input name="quantity" class="quantity-number" type="number" value="1" min="1" max="100" required>
                <a onclick="step(this, -1)" class="decrement-button"><div class="decrement-symbol">&#8722</div></a><a onclick="step(this, 1)" class="increment-button"><div class="increment-symbol">&#43</div></a>         
            </div>
            <div class="product-size">
                <?php foreach (getQuantityPerSize($product['size_quantity']) as $size => $quantity): ?>
                <input name="size" class="size-radio" type="radio" value="<?=$size?>" id="<?=$product['id'].'-'.$size?>-radio">
                <label id="<?=$quantity?>" class="size-label" for="<?=$product['id'].'-'.$size?>-radio"><?=$size?></label>   
                <?php endforeach; ?>
            </div>  
            <div class="quantity-notice">Select a size</div>
            <input class="cart-submit" type="submit" value="ADD TO CART">
        </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>    
</div>
<?=template_footer()?>