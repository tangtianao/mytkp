<?php
require_once '../autoload.php';
session_start();
$controller=null;
$menthodName=null;
if (isset($_GET["controller"] )&& isset($_GET["methodName"])){
    $controller = $_GET["controller"];
    $menthodName = $_GET["methodName"];
    
}else {
    $controller = $_POST["controller"];
    $menthodName = $_POST["methodName"];
}
$controller = "controller\\".$controller;
//动态创建控制器类的对象 要求控制器的类必须放在项目根目录下的controller 
$con = new $controller();
//动态调用对象的某个无参数的构造方法
$con->$menthodName();
