<?php
// GET 6 MOST RECENT PRODUCTS
$query = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 6');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC); // FETCHING AS AN ASSOCIATIVE ARRAY
?>
<?=template_header("nin's")?>

<div class="products-wrapper">

    <!-- TEMPORARY TEMPLATE -->
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
        <form class="cart-form" action="index.php?page=cart" method="post">
            <input name="product-id" type="hidden" value="<?=$product['id']?>">
            <div class="product-quantity">
                <input name="quantity" class="quantity-number" type="number" value="1" min="1" required>
                <a onclick="step(this, -1)" class="decrement-button">&#10094</a><a onclick="step(this, 1)" class="increment-button">&#10095</a>         
            </div>
            <div class="product-size">
                <?php foreach (getsizes($product['size_quantity']) as $size): ?>
                <input name="size" class="size-radio" type="radio" value="<?=$size?>" id="size-radio-<?=$size?>">
                <label class="size-label" for="size-radio-<?=$size?>"><?=$size?></label>   
                <?php endforeach; ?>
            </div>
            <input class="cart-submit" type="submit" value="ADD TO CART">
        </form>
    </div>
        <!-- CURRENTLY HERE  -->
    <?php endforeach; ?>



</div>    
</div>
<script type="text/javascript" src="script.js"></script>
<?=template_footer()?>