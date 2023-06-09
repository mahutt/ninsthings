<?php
// FETCHING PRODUCTS AS AN ASSOCIATIVE ARRAY
$statement = $pdo->prepare('SELECT * FROM products ORDER BY id DESC LIMIT 6');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC); 

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
                <button>&#10094</button>
                <button>&#10095</button>
            </div>
        </div>  
        <div class="product-name"><?=$product['name']?></div>
        <div class="product-price">&dollar;<?=$product['price']?> CAD</div>
        <?php 
            $statement = $pdo->prepare('SELECT * FROM stock WHERE id = :id');
            $statement->execute([':id' => $product['id']]);
            $stock = $statement->fetch(PDO::FETCH_ASSOC); 
        ?>
        <?php if (isEmpty($stock)): ?>
            <br><div class="out-of-stock">OUT OF STOCK</div>
        <?php else: ?>
            <form id="form-<?=$product['id']?>" class="cart-form" action="index.php?page=cart" method="post" onsubmit="return validateCartForm(this)">
                <input name="product-id" type="hidden" value="<?=$product['id']?>">
                <div class="product-quantity">
                    <input name="quantity" class="quantity-number" type="number" value="1" min="1" max="100" required>
                    <a onclick="step(this, -1)" class="decrement-button"><div class="decrement-symbol">&#8722</div></a><a onclick="step(this, 1)" class="increment-button"><div class="increment-symbol">&#43</div></a>         
                </div>
                <div class="product-size">
                <?php foreach ($stock as $size => $quantity): ?>
                    <?php if ($size != 'id' && $quantity > 0): ?>
                        <input name="size" class="size-radio" type="radio" value="<?=$size?>" id="<?=$product['id'].'-'.$size?>-radio">
                        <label id="<?=$quantity?>" class="size-label" for="<?=$product['id'].'-'.$size?>-radio"><?=$size?></label>
                    <?php elseif ($size != 'id' && $quantity == 0): ?>
                        <label class="empty-size-label"><?=$size?><div class="strike"></div></label>
                    <?php endif; ?>
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