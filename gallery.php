<?php 
$query = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 6');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
$IMGS_PER_PRODUCT = 8;
$imgfolders = array();
foreach ($products as $product) {
    $imgfolders[] = $product['img'];
}
$imgcount = 1;
?>
<?=template_header("nin's")?>
<div class="gallery-wrapper">
    <?php for ($i = 1; $i <= $IMGS_PER_PRODUCT; $i++) { ?>
        <?php foreach ($imgfolders as $imgfolder): ?>
        <?php $imgsource = "products/$imgfolder/$i.jpg"; ?>
        <?php if (file_exists($imgsource)): ?>
            <img src="<?=$imgsource?>" alt="" class="img<?=$imgcount++?>">
        <?php endif; ?>
        <?php endforeach; ?>
    <?php } ?>
</div>
<?=template_footer()?>