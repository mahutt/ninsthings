<?php
// IF USER CLICKED "ADD TO CART":
if (isset($_POST['product-id']) && is_numeric($_POST['product_id'])) {
    
    $id = (int)$_POST['product-id'];
    $quantity = 1;

    $query = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute([$_POST['product_id']]);
    
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
}