<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

define('ROOT_DIR', dirname(__FILE__));

function __autoload($class_name) {
    $folder = array(
        "/class/core/",
        "/class/blog/",
        "/class/user/",
        "/class/interface/",
        "/class/login/"
    );

    foreach ($folder as $path) {
        if (file_exists(ROOT_DIR . $path . $class_name . '.php')) {
            include_once ROOT_DIR . $path . $class_name . '.php';
            return;
        }
    }
}
