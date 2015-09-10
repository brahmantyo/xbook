<?php
Login::restrictFront();

$cat = Url::getParam('category');

if(empty($cat)) {
    require_once('error.php');
} else {
    $objCatalogue = new Catalogue();
    $category = $objCatalogue->getCategory($cat);
    
    if(empty($category)){
        require_once("error.php");
    } else {
        $rows = $objCatalogue->getProducts($cat);
        
        require_once('_header.php');
    }
}
?>

<h1>Catalogue :: <?php echo $category['name'];?></h1>

<?php
    if(!empty($rows)){
        foreach($rows as $row){
?>
<div class="catalogue_wrapper">
    <div class="catalogue_wrapper_left">
        <?php
            $image = !empty($row['image'])?
                $objCatalogue->_path.$row['image']:
                $objCatalogue->_path."unavailable.png";
            $width = Helper::getImgSize($image,0);
            $width = $width > 120? 120 : $width;
        ?>
        <a href="<?php echo SITE_URL;?>/?page=catalogue-item&amp;category=<?php echo $category['id']; ?>&amp;id=<?php echo $row['id'];?>">
            <img src="<?php echo $image;?>" alt="<?php echo Helper::encodeHTML($row['name'],1);?>" width="<?php echo $width;?>" />
        </a>
    </div>
    <div class="catalogue_wrapper_right">
        
    </div>
</div>
<?php
        }
    }

?>
<?php
require_once('_footer.php');
?>
