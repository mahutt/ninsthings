<?php 
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}
?>
<?=template_header('thank you!')?>
<div class="cart-wrapper"> <div class="cart-title">THANK YOU FOR YOUR PURCHASE ;)</div></div>
<?=template_footer()?> 