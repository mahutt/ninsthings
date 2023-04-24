<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>nin's</title>
</head>
<body>
    
    <?php include 'header.php' ?>

    <div class="products-wrapper">

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
    </div>    

    <div class="product" id="p2">
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
    </div>   

    </div>

    <?php include 'footer.php' ?>

    

    






    <script src="script.js"></script>
</body>
</html>