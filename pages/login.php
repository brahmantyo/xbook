<?php
if(Login::isLogged(Login::$_login_front)){
    
}

?>


<?php require_once('_header.php');?>
<h1>Login</h1>
<form action="" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_inser">
        <tr>
            <th>
                <label for="login_email">Login:</label>
            </th>
            <td>
                <input type="text" name="login_name" id="login_name" class="fld" value="" />
            </td>
        </tr>    
        <tr>
            <th>
                <label for="login_password">Password:</label>
            </th>            
            <td>
                <input type="password" name="login_password" id="login_password" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th>&#160;</th>
            <td>
                <label for="btn_login" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn_login" class="btn" value="Login" />
                </label>
            </td>
        </tr>
    </table>
</form>
<?php require_once('_footer.php');?>