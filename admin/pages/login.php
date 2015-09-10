<?php

if(Login::isLogged(Login::$_login_admin_id)){
    Helper::redirect(SITE_URL.Login::$_dashboard_admin);
}
$objForm = new Form();
$objValidation = new Validation($objForm);

if($objForm->isPost('login_user')){
    $objAdmin = new Admin();
    
    $objValidation->_required = array(
        'login_user',
        'login_password'
    );

    
    if($objAdmin->isUser($objForm->getPost('login_user'), $objForm->getPost('login_password'))){
        $result = Login::loginAdmin($objAdmin->_user, Url::getReferrerUrl());
    } else {
        $objValidation->add2Errors('login');
    }

    if($objValidation->isValid()){
        
    }
}
?>

<html>
    <head>
        <title>XBook Management System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/Core.css" rel="stylesheet" type="text/css" />
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.min.css">

        
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-select.min.js"></script>
        
    </head>
    <body style="background-color: grey">
        <div id="header" class="col-xs-12 col-sm-12 col-lg-12">
            <div id="header_in" class="" >
                <h5 ><strong><a href="<?php echo SITE_URL;?>">XBOOK CONTROL PANEL</a></strong></h5>
            </div>
        </div>
        <div class="row-fluid">&nbsp;</div>
        <div class="row-fluid">&nbsp;</div>
        <div class="row-fluid">&nbsp;</div>


        <div id="login_forms" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-3 col-sm-2 col-md-1">&nbsp;</div>
            <div class=" col-lg-6 col-sm-8 col-md-10 well">
                <div class="col-lg-4" align="center"><img alt="logo" src="../images/logo.jpg" width="100"/></div>
                <div class="col-lg-8" align="center">
                    <?php
                        $testError = $objValidation->validate('login');
                        if(!empty($testError)){?>
                    <div class="alert alert-danger"><?php echo $objValidation->validate('login');?></div>
                    <?php } ?>
                    <form action="" method="post">
                        <table>
                            <tr>
                                <th>
                                    <label for="login_user">Login:</label>
                                </th>
                                <td>
                                    <input class="col-xs-12 col-lg-12" type="text" name="login_user" id="login_user" value="" />
                                </td>
                                <td>
                                    <?php 
                                        $testUser = $objValidation->validate('login_user');
                                        if(!empty($testUser)){ ?>
                                    <div  style="font-size: 10; color: red;">
                                     <?php echo $objValidation->validate('login_user');?>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="login_password">Password:</label>
                                </th>            
                                <td>
                                    <input class="col-xs-12 col-lg-12" type="password" name="login_password" id="login_password" value="" />
                                </td>
                                
                                <td>
                                    <?php 
                                        $testPassword = $objValidation->validate('login_password');
                                        if(!empty($testPassword)){ ?>
                                    <div style="font-size: 10;color: red;">
                                    <?php echo $objValidation->validate('login_password');?>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span>
                                        <input type="submit" id="btn_login"  class="col-xs-12 col-lg-12 btn btn-warning" value="Login" />
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-sm-2 col-md-1">&nbsp;</div>
        </div>
 
        <script type="text/javascript" >
        $('#login_user').focus();
        
        </script>
<?php require_once('_footer.php');?>