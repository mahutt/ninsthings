<?php
foreach ($_POST as $key => $value) {
    console($key." => ".$value);
}

// IF USER CLICKED "ADD TO CART":
if (isset($_POST['product-id'], $_POST['quantity'], $_POST['size']) && is_numeric($_POST['product-id']) && is_numeric($_POST['quantity'])) {
    $id = (int)$_POST['product-id'];
    $quantity = (int)$_POST['quantity'];
    $size = $_POST['size'];

    $query = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute([$_POST['product-id']]);
    
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0) {

        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            
            // UPDATING QUANTITY IF PRODUCT ALREADY EXISTS IN CART:
            if (array_key_exists($id.",".$size, $_SESSION['cart'])) {
                $_SESSION['cart'][$id.",".$size] += $quantity; 
            } else {
                $_SESSION['cart'][$id.",".$size] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($id.",".$size => $quantity);
        }
    }
    // PREVENTING FORM RESUBMISSION:
    header('location: index.php?page=cart');
    exit;
}

// IF USER CLICKED "REMOVE":
if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// UPDATING PRODUCT QUANTITIES FROM CART.PHP:
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity') !== false && is_numeric($value)) {
            $id_size = str_replace('quantity-', '', $key);
            $quantity = (int)$value;
            if (isset($_SESSION['cart'][$id_size]) && $quantity > 0) {
                $_SESSION['cart'][$id_size] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}

// CHECKING WHETHER CART IS EMPTY BEFORE CHECKING OUT
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=checkout');
    exit;
}

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// SELECTING PRODUCTS IN CART FROM DB IF THERE ARE ANY
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $query = $pdo->prepare('SELECT * FROM products WHERE id IN ('.$array_to_question_marks.')');
    
    $ids_sizes = array_keys($products_in_cart);
    $ids = array();
    foreach ($ids_sizes as $id_size) {
        $ids[] = (int)explode(",", $id_size)[0];
    }

    $query->execute($ids);
    $unlisted_products = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($unlisted_products as $product) {
        $products[$product['id']] = $product;
    }

    // 
    // console(sizeof($products_in_cart));
    // console(sizeof($products));

    // CALCULATING SUBTOTAL
    foreach ($products_in_cart as $id_size => $quantity) {
        
        $id = (int)explode(",", $id_size)[0];

        $subtotal += (float)$products[$id]['price'] * (int)$quantity;

        // foreach ($products as $product) {
        //     if ($product['id'] = $id) {
                
        //     }
        // }
    }


    // foreach ($products as $product) {
    //     echo $product['id'];
    //     $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    // }
}
?>
<?=template_header('cart')?>
<!-- BUILD CART PAGE HERE (9.6)  -->
<form action="index.php?page=cart" method="post">
    <div class="cart-wrapper">
        <?php if (empty($products)): ?>
        <div class="cart-title">Your cart is empty!</div>
        <?php else: ?>
        <div class="cart-title">Shopping Cart</div>
        <div class="cart-items-wrapper">
            <?php foreach($products_in_cart as $id_size => $quantity): ?>
            <?php $id = (int)explode(",", $id_size)[0]; $size = explode(",", $id_size)[1]; ?>
            <div class="cart-item">
                <img id="<?=$id_size?>-image-1" src="products/<?=$products[$id]['img']?>/1.jpg" alt="" class="product-image">
                <div class="product-name">
                    <div><?=$products[$id]['name']?></div>
                    <span class="size">(<?=$size?>)</span>
                </div>
                <div class="product-price">&dollar;<?=$products[$id]['price']?> CAD</div>
                <div class="product-quantity">
                    <?php $getMax = getQuantityPerSize($products[$id]['size_quantity']); ?>
                    <input class="quantity-number" type="number" name="quantity-<?=$id_size?>" value="<?=$quantity?>" min="1" max="<?=$getMax[$size]?>" required>
                    <a onclick="step(this, -1)" class="decrement-button">&#10094</a><a onclick="step(this, 1)" class="increment-button">&#10095</a>         
                </div>
                <a href="index.php?page=cart&remove=<?=$id_size?>" class="remove">Remove</a>
                <div class="product-total">
                    <div class="label">Subtotal</div>
                    <div class="price">&dollar;<?=$products[$id]['price'] * $quantity?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($products)): ?>
    <div class="cart-place-order">
        <input class="update-button" type="submit" value="update quantities" name="update">
        <div class="buttons">
            <div class="subtotal">
                <div class="subtotal-label">Subtotal:&nbsp</div>
                <div class="subtotal-value">&dollar;<?=$subtotal?></div>
            </div>
            <input class="order-submit" type="submit" value="checkout" name="placeorder">
        </div>
    </div>
    <?php endif; ?>
</form>

<script type="text/javascript" src="script.js"></script>
<?=template_footer()?>