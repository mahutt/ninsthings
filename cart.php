<?php
// CURRENTLY ON THIS PAGE, MUST FIGURE OUT WHY QUANITY ISN'T UPDATING WHEN RESUBMIT OR UPDATE!! section ~ 9.5
// IF USER CLICKED "ADD TO CART":
if (isset($_POST['product-id'], $_POST['quantity']) && is_numeric($_POST['product-id']) && is_numeric($_POST['quantity'])) {
    
    $id = (int)$_POST['product-id'];
    $quantity = (int)$_POST['quantity'];

    $query = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute([$_POST['product-id']]);
    
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0) {

        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            
            // UPDATING QUANTITY IF PRODUCT ALREADY EXISTS IN CART:
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$id] += $quantity; 
            } else {
                $_SESSION['cart'][$id] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // PREVENTING FORM RESUBMISSION:
    header('location: index.php?page=cart');
    exit;
}

// IF USER CLICKED "REMOVE":
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// UPDATING PRODUCT QUANTITIES FROM CART.PHP:
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity') !== false && is_numeric($value)) {
            $id = str_replace('quantity-', '', $key);
            $quantity = (int)$value;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}

// CHECKING WHETHER CART IS EMPTY BEFORE PLACING ORDER
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// SELECTING PRODUCTS IN CART FROM DB IF THERE ARE ANY
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $query = $pdo->prepare('SELECT * FROM products WHERE id IN ('.$array_to_question_marks.')');
    $query->execute(array_keys($products_in_cart));
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    // CALCULATING SUBTOTAL
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] + (int)$products_in_cart[$product['id']];
    }
}
?>
<?=template_header('cart')?>
<!-- BUILD CART PAGE HERE (9.6)  -->
<div class="cart-wrapper">
    <?php if (empty($products)): ?>
    <h1>Your cart is empty!</h1>
    <?php else: ?>
    <h1>Shopping Cart</h1>
    <?php foreach($products as $product): ?>



    
    
    
    <div class="cart-item">
        <img id="<?=$product['id']?>-image-1" src="products/<?=$product['img']?>/1.jpg" alt="" class="product-image">
        <div class="product-name"><?=$product['name']?></div>
        

    </div>





    <!-- <form action="index.php?page=cart" method="post">   
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td>Your cart is empty!</td>
                </tr>
                <?php else: ?>
                <?php foreach($products as $product): ?>
                <tr>
                    <td>
                    <img id="<?=$product['id']?>-image-1" src="products/<?=$product['img']?>/1.jpg" alt="" class="product-image">
                    </td>
                    <td>
                        <div class="product-name"><?=$product['name']?></div>

                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                    </td>
                    <td><div class="product-price">&dollar;<?=$product['price']?> CAD</div></td>
                    <td><input class="quantity-number" type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" required></td>
                    <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="cart-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-value">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form> -->
</div>
<?=template_footer()?>