<?php

require_once 'global.php';
if (isset($_POST['submit']) === true) {
    LIS_Login::do_login();
}else{
    LIS_Login::show_form();
}

?>
