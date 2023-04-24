<?php 
session_start();

// CONNECTING TO DB USING PDO MYSQL
include 'functions.php';
$pdo = pdo_connect_mysql();

// TERNARY DECIDES WHETHER TO ROUTE TO A SPECIFIC PAGE, OR TO HOME.PHP (DEFAULT)
$page = (isset($_GET['page']) && file_exists($_GET['page'].'.php')) ? $_GET['page'] : 'home';
include $page.'.php';





?>