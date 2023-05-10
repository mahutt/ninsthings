<?php
// IF USER CLICKED "ADD TO CART":
if (isset($_POST['product-id'], $_POST['quantity'], $_POST['size']) && is_numeric($_POST['product-id']) && is_numeric($_POST['quantity'])) {
    $id = (int)$_POST['product-id'];
    $quantity = (int)$_POST['quantity'];
    $size = $_POST['size'];

    // FETCHING TO CHECK WHETHER THE PRODUCT EXISTS
    $statement = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $statement->execute([$_POST['product-id']]);
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    // FETCHING TO CHECK WETHER THERE IS ENOUGH STOCK
    $statement = $pdo->prepare('SELECT * FROM stock WHERE id = ?');
    $statement->execute([$product['stock_id']]);
    $stock = $statement->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            
            // UPDATING QUANTITY IF PRODUCT ALREADY EXISTS IN CART:
            if (array_key_exists($id.",".$size, $_SESSION['cart'])) {
                if ($_SESSION['cart'][$id.",".$size] + $quantity <= $stock[$size]) {
                    $_SESSION['cart'][$id.",".$size] += $quantity;
                } else {
                    echo "Cannot add more";// HANDLE THE CASE WHERE WE CANNOT ADD THIS ITEM AGAIN TO CART DUE TO INSUFFICIENT STOCK
                }
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
            $newQuantity = (int)$value;
            list($id, $size) = explode(",", $id_size);
            $stock = getStock($id);
            if (isset($_SESSION['cart'][$id_size]) && $newQuantity > 0) {
                if ($newQuantity <= $stock[$id]) {
                    $_SESSION['cart'][$id_size] = $newQuantity;
                } else {
                    echo "Cannot add more";// HANDLE THE CASE WHERE WE CANNOT ADD QUANTITY DUE TO INSUFFICIENT STOCK --> use modal?
                }
                
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}

// SELECTING PRODUCTS IN CART FROM DB IF THERE ARE ANY
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
if ($products_in_cart) {
    // OBTAINING ASSOCIATIVE ARRAY OF PRODUCTS IN CART ID => PRODUCT DATA
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $statement = $pdo->prepare('SELECT * FROM products WHERE id IN ('.$array_to_question_marks.')');
    $ids_sizes = array_keys($products_in_cart);
    $ids = array();
    foreach ($ids_sizes as $id_size) {
        $ids[] = (int)explode(",", $id_size)[0];
    }
    $statement->execute($ids);
    $unlisted_products = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($unlisted_products as $product) {
        $products[$product['id']] = $product;
    }

    // CALCULATING SUBTOTAL
    foreach ($products_in_cart as $id_size => $quantity) {
        $id = (int)explode(",", $id_size)[0];
        $subtotal += (float)$products[$id]['price'] * (int)$quantity;
    }
}

// CHECKING WHETHER CART IS EMPTY BEFORE CHECKING OUT
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // SETTING UP STRIPE ENV
    require_once 'stripe-php-10.12.1/init.php';
    require_once 'secrets.php';
    \Stripe\Stripe::setApiKey($stripeSecretKey); # Defined in secrets.php
    $DOMAIN = 'http://localhost/nins/';

    // SAVING ORIGINAL QUANTITIES DATA IN SESSION VARIABLE
    $_SESSION['quantity_backup'] = array();
    foreach ($products as $product) {
        $_SESSION['quantity_backup'][$product['id']] = $product['size_quantity'];
    }

    // UPDATING DB (PRIOR TO ATTEMPTING CHECKOUT)
    foreach ($products_in_cart as $id_size => $requestedQuantity) {
        list($id, $size) = explode(",", $id_size);
        $stock = getStock($id);
        if ($stock[$size] >= $requestedQuantity) { // update 
            $newQuantity = $stock[$size] - $requestedQuantity;
            $statement = $pdo->prepare("UPDATE stock SET $size = :new_quantity WHERE id = :id");
            $statement->bindParam(':new_quantity', $newQuantity, PDO::PARAM_INT);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } else {
            $_SESSION['stock-error'] = $products[$id]['name'];
            $_SESSION['cart'][$id_size] = $stock[$size];
            header('location: index.php?page=cancel'); // explain that we had too many of a specific product, use modal?
            exit;
        }
    }

    // CREATING LINE ITEMS
    $line_items = array();
    foreach ($products_in_cart as $id_size => $quantity) {
        $id = (int)explode(",", $id_size)[0]; 
        $size = explode(",", $id_size)[1];

        // CREATING LINE ITEM
        $line_item = array(
            'price_data' => array(
                'currency' => 'cad',
                'unit_amount' => $products[$id]['price'] * 100,
                'product_data' => array(
                    'name' => $products[$id]['name'],
                    'description' => $size,
                    'images' => array($DOMAIN.'products/'.$products[$id]['img'].'/3.jpg'),
                ),
            ),
            'quantity' => $quantity,
        );
        array_push($line_items, $line_item);
    }

    // DEFINING SHIPPING OPTIONS BASED ON LOCATION
    function getShipping($address) {
        if ($address->city == 'Montreal') {
            return [[
                'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => ['amount' => 0, 'currency' => 'cad'],
                    'display_name' => 'Free Shipping to Montreal',
                    'delivery_estimate' => [
                        'minimum' => ['unit' => 'week', 'value' => 1],
                        'maximum' => ['unit' => 'week', 'value' => 2],
                    ],
                ],
            ]];
        } else {
            return [[
                'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => ['amount' => 800, 'currency' => 'cad'],
                    'display_name' => 'Standard Shipping (Outside Montreal)',
                    'delivery_estimate' => [
                        'minimum' => ['unit' => 'week', 'value' => 1],
                        'maximum' => ['unit' => 'week', 'value' => 2],
                    ],
                ],
            ]];
        }
    }

    // CREATING CHECKOUT SESSION
    $checkout_session = \Stripe\Checkout\Session::create(array(
        'shipping_address_collection' => ['allowed_countries' => ['US', 'CA']],
        
        'shipping_options' => 
        [
            [
              'shipping_rate_data' => [
                'type' => 'fixed_amount',
                'fixed_amount' => ['amount' => 800, 'currency' => 'cad'],
                'display_name' => 'Standard Shipping',
                'delivery_estimate' => [
                  'minimum' => ['unit' => 'week', 'value' => 1],
                  'maximum' => ['unit' => 'week', 'value' => 2],
                ],
              ],
            ],
            [
              'shipping_rate_data' => [
                'type' => 'fixed_amount',
                'fixed_amount' => ['amount' => 0, 'currency' => 'cad'],
                'display_name' => 'Free Shipping to Montreal',
                'delivery_estimate' => [
                  'minimum' => ['unit' => 'week', 'value' => 1],
                  'maximum' => ['unit' => 'week', 'value' => 2],
                ],
              ],
            ],
        ],

        'payment_method_types' => array('card'),
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => $DOMAIN.'index.php?page=success', // redirect through index?
        'cancel_url' => $DOMAIN.'index.php?page=cancel',
    ));
    
    // REDIRECT TO CHECKOUT
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    exit;
}

?>
<?=template_header('cart')?>
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
                    <?php $stock = getStock($id); ?>
                    <input class="quantity-number" type="number" name="quantity-<?=$id_size?>" value="<?=$quantity?>" min="1" max="<?=$stock[$size]?>" required>
                    <a onclick="step(this, -1)" class="decrement-button"><div class="decrement-symbol">&#8722</div></a><a onclick="step(this, 1)" class="increment-button"><div class="increment-symbol">&#43</div></a>         
                </div>
                <a href="index.php?page=cart&remove=<?=$id_size?>" class="remove redirect">Remove</a>
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
        <input class="update-button redirect" type="submit" value="update quantities" name="update">
        <div class="buttons">
            <div class="subtotal">
                <div class="subtotal-label">Subtotal:&nbsp</div>
                <div class="subtotal-value">&dollar;<?=$subtotal?></div>
            </div>
            <input class="order-submit redirect" type="submit" value="checkout" name="placeorder">
        </div>
    </div>
    <?php endif; ?>
</form>

<?=template_footer()?>