<?php 
$totalGalleryImages = 11;
?>
<?=template_header("nin's")?>
<div class="gallery-wrapper">
    <?php for ($i = 1; $i <= $totalGalleryImages; $i++) { ?>
    <?php $imgsource = "gallery/$i.jpg"; ?>
        <img src="<?=$imgsource?>" alt="" class="img<?=$i?>">
    <?php } ?>
</div>
<?=template_footer()?>