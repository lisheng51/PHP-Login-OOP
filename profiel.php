<?php
require_once 'global.php';

$obj_profiel = new LIS_Profiel();
if (isset($_POST['submit']) === true) {
    $obj_profiel->edit_profiel();
}
$obj_profiel->execute();

?>

