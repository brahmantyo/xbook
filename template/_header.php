<?php
$objCatalogue = new Catalogue();
$cats = $objCatalogue->getCategories();

$objBusiness = new Business();
$business = $objBusiness->getBusiness();
?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo SITE_URL;?>/css/Core.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="container">
        <div id="header">test
            <div id="header_in">
                <h5 >Welcome to <a href="<?php echo SITE_URL;?>/" ><?php echo $business['name'];?></a></h5>
            </div>
        </div>
        <div id="outer">
            <div id="wrapper">
                <div id="left">
                    <h2>Categories</h2>
                    <ul id="navigation">
                        <?php
                            if(!empty($cats)){
                                foreach ($cats as $cat){
                                    echo "<li><a href=\"".SITE_URL."/?page=catalogue&amp;category=".$cat['id']."\"";
                                    echo Helper::getActive(array('category'=>$cat['id']));
                                    echo ">";
                                    echo Helper::encodeHTML($cat['name']);
                                    echo "</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>