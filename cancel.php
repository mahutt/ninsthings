<?php
if (isset($_SESSION['quantity_backup']) && !empty($_SESSION['quantity_backup'])) {
    $query = $pdo->prepare('UPDATE products SET size_quantity = :new_size_quantity WHERE id = :id');
    $quantities = $_SESSION['quantity_backup'];
    foreach ($quantities as $id => $size_quantity) {
        $query->bindParam(':new_size_quantity', $size_quantity, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
    unset($_SESSION['quantity_backup']);
}
$msg;
$returntocart = false;
if (isset($_SESSION['stock-error'])) {
    $msg = "INSUFFICIENT STOCK: ".$_SESSION['stock-error'];
    $returntocart = true;
} else {
    $msg = "YOUR ORDER HAS BEEN CANCELLED";
}
?>
<?=template_header('order cancelled')?>
<div class="cart-wrapper">
    <div class="cart-title"><?=$msg?></div>
    <?php if ($returntocart): ?>
    <a href="index.php?page=cart"><div class="error-title">return to cart</div></a>
    <?php endif; ?>
</div>
<?=template_footer()?> 