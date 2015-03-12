<?php
require_once 'global.php';

if (isset($_POST['submit']) === true) {
    LIS_Register::do_register();
}else{
    LIS_Register::show_form();
}
