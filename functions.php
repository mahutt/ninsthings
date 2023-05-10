<?php
// LOGGING TO CONSOLE WITH PHP
function console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// STREAMLINING PDO OBJECT CREATION
function pdo_connect_mysql() {
    // Below SQL details need to be specified (currently should work for a local XAMP server):
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingcart';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!');
    }
}

// RETURNS AVAILABLE SIZES
function getsizes($str) {
    $sizes_quantities = explode(",", $str);
    $sizes = array();
    foreach ($sizes_quantities as $size_quantity) {
        $sizes[] = explode(":", $size_quantity)[0];
    }
    return $sizes;
}

// VERIFIES WHETHER GIVEN ITEM'S STOCK ROW IS EMPTY
function isEmpty($stock) {
    foreach ($stock as $size => $quantity) {
        if ($size != 'id' && $quantity > 0) {
            return false;
        }
    }
    return true;
}

// FETCHING TO CHECK WETHER THERE IS ENOUGH STOCK
function getStock($stock_id) {
    global $pdo;
    $statement = $pdo->prepare('SELECT * FROM stock WHERE id = ?');
    $statement->execute([$stock_id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// TEMPLATE HEADER
function template_header($title) {
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$bubble = "";
if ($num_items_in_cart > 0) {
    $bubble = "<span class=\"cart-counter\">$num_items_in_cart</span>";
}
echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <div class="header-wrapper">
        <div class="header">
            <a class="redirect" href="index.php?page=home"><h1 class="logo">N</h1></a>
            <h1 class="heading">nin's things</h1>
            <div class="shopping-bag">
                <a class="redirect" href="index.php?page=cart">
                    <img src="img/bag.png">
                    $bubble
                </a>
            </div>
            <nav class="nav">
                <ul>
                    <li><a class="nav-item redirect" href="index.php?page=gallery">GALLERY</a></li>
                    <li><a class="nav-item redirect" href="index.php?page=home">HOME</a></li>
                    <li><a class="nav-item redirect" href="index.php?page=contact">CONTACT</a></li>
                </ul>
            </nav>
        </div>
        </div>
    </header>
    <main>
        <div class="spinner-wrapper">
            <div class="spinner"></div>
        </div>
EOT;
}
// TEMPLATE FOOTER
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            <div class="footer-wrapper">
                <div class="footer">
                    <p class="footing">&copy; $year, nin's things</p>
                </div>
            </div>
        </footer>
    </body>
    <script type="text/javascript" src="script.js"></script>
</html>
EOT;
}
?>