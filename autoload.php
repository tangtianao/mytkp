<?php
header("content-type:text/html;charset=utf-8");
spl_autoload_register(function($className){
    require_once $className .'.class.php';
});
?>