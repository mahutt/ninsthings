<?php
// STREAMLINING PDO OBJECT CREATION
function pdo_connect_mysql() {
    // Update the details below with your MySQL details***
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
// TEMPLATE HEADER
function template_header($title) {
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
            <h1 class="logo">N</h1>
            <h1 class="heading">nin's things</h1>
            <img class="shopping-bag" src="img/bag.png">
            <nav class="nav">
                <ul>
                    <li><a href="index.php?page=products">PRODUCTS</a></li>
                    <li><a href="index.php?page=home">HOME</a></li>
                    <li><a href="index.php?page=contact">CONTACT</a></li>
                </ul>
            </nav>
        </div>
        </div>
    </header>
    <main>
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
</html>
EOT;
}
?>