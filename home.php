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
        <!-- THIS FORM HAS YET TO BE CUSTOMIZED PER ITEM! -->
        <form class="cart-form" action="">
        <div class="product-size">
            <input type="hidden" name="product-number" value="p1">
            <input class="size-radio" type="radio" name="size" value="xs" id="size-radio-xs">
            <label class="size-label" for="size-radio-xs">XS</label>
            <input class="size-radio" type="radio" name="size" value="s" id="size-radio-s">
            <label class="size-label" for="size-radio-s">S</label>
        </div>
        <input class="cart-submit" type="submit" value="ADD TO CART">
    </form>
    </div>
        <!-- CURRENTLY HERE  -->
    <?php endforeach; ?>


<!-- 
<div class="product" id="p1">
    <div class="product-image-box">
        <div class="slider">    
            <img id="p1-image-1" src="products/KISSES/1.jpg" alt="" class="product-image">
            <img id="p1-image-2" src="products/KISSES/2.jpg" alt="" class="product-image">
            <img id="p1-image-3" src="products/KISSES/3.jpg" alt="" class="product-image">
        </div>
        <div class="slider-buttons">
            <a href="#p1-image-1"></a>
            <a href="#p1-image-2"></a>
            <a href="#p1-image-3"></a>
        </div>
    </div>
    <div class="product-name">TEST</div>
    <div class="product-price">$15.00 CAD</div>
    <form class="cart-form" action="">
        <div class="product-size">
            <input type="hidden" name="product-number" value="p1">
            <input class="size-radio" type="radio" name="size" value="xs" id="size-radio-xs">
            <label onclick="selected(this)" class="size-label" for="size-radio-xs">XS</label>
            <input class="size-radio" type="radio" name="size" value="s" id="size-radio-s">
            <label onclick="selected(this)" class="size-label" for="size-radio-s">S</label>

            
        </div> -->
        
        <!-- <script>
            function selected(label) {
                const labels = label.parentNode.querySelectorAll('label');
                // alert(labels.length);
                for (var i = 0; i < labels.length; i++) {
                    if (labels[i].classList.contains("selected-size"))
                        labels[i].classList.remove("selected-size");
                }
                label.classList.add("selected-size");     
            }
        </script> -->
<!-- 
        <input class="cart-submit" type="submit" value="ADD TO CART">
    </form> -->
</div>    

<!-- <div class="product" id="p1">
    <div class="product-image-box">
        <div class="slider">    
            <img id="p1-image-1" src="products/KISSES/1.jpg" alt="" class="product-image">
            <img id="p1-image-2" src="products/KISSES/2.jpg" alt="" class="product-image">
            <img id="p1-image-3" src="products/KISSES/3.jpg" alt="" class="product-image">
        </div>
        <div class="slider-buttons">
            <a href="#p1-image-1"></a>
            <a href="#p1-image-2"></a>
            <a href="#p1-image-3"></a>
        </div>
    </div>
    <div class="product-name">HORNY FOR FLOWER&nbspT</div>
    <div class="product-price">$15.00 CAD</div>
    <form class="cart-form" action="">
        <div class="product-size">
            <input type="hidden" name="product-number" value="p1">
            <input class="size-radio" type="radio" name="size" value="xs" id="size-radio-xs">
            <label class="size-label" for="size-radio-xs">XS</label>
            <input class="size-radio" type="radio" name="size" value="s" id="size-radio-s">
            <label class="size-label" for="size-radio-s">S</label>
        </div>
        
        <input class="cart-submit" type="submit" value="ADD TO CART">
    </form>
</div>     -->

<!-- <div class="product" id="p2">
    <div class="product-image-box">
        <div class="slider">    
            <img id="p2-image-1" src="products/KISSES/1.jpg" alt="" class="product-image">
            <img id="p2-image-2" src="products/KISSES/2.jpg" alt="" class="product-image">
            <img id="p2-image-3" src="products/KISSES/3.jpg" alt="" class="product-image">
        </div>
        <div class="slider-buttons">
            <a href="#p2-image-1"></a>
            <a href="#p2-image-2"></a>
            <a href="#p2-image-3"></a>
        </div>
    </div>
    <div class="product-name">HORNY FOR FLOWER&nbspT</div>
    <div class="product-price">$15.00 CAD</div>
    <form class="cart-form" action="">
        <div class="product-size">
        <input type="hidden" name="product-number" value="p2">
            <input class="size-radio" type="radio" name="size" value="xs" id="size-radio-xs">
            <label class="size-label" for="size-radio-xs">XS</label>
            <input class="size-radio" type="radio" name="size" value="s" id="size-radio-s">
            <label class="size-label" for="size-radio-s">S</label>
        </div>
        
        <input class="cart-submit" type="submit" value="ADD TO CART">
    </form>
</div>   

<div class="product" id="p3">
    <div class="product-image-box">
        <div class="slider">    
            <img id="p3-image-1" src="products/KISSES/1.jpg" alt="" class="product-image">
            <img id="p3-image-2" src="products/KISSES/2.jpg" alt="" class="product-image">
            <img id="p3-image-3" src="products/KISSES/3.jpg" alt="" class="product-image">
        </div>
        <div class="slider-buttons">
            <a href="#p3-image-1"></a>
            <a href="#p3-image-2"></a>
            <a href="#p3-image-3"></a>
        </div>
    </div>
    <div class="product-name">HORNY FOR FLOWER&nbspT</div>
    <div class="product-price">$15.00 CAD</div>
    <form class="cart-form" action="">
        <div class="product-size">
        <input type="hidden" name="product-number" value="p3">
            <input class="size-radio" type="radio" name="size" value="xs" id="size-radio-xs">
            <label class="size-label" for="size-radio-xs">XS</label>
            <input class="size-radio" type="radio" name="size" value="s" id="size-radio-s">
            <label class="size-label" for="size-radio-s">S</label>
        </div>
        
        <input class="cart-submit" type="submit" value="ADD TO CART">
    </form>
</div>    -->

</div>
<script type="text/javascript" src="script.js"></script>
<?=template_footer()?>