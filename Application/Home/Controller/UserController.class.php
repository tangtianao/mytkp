<?php
namespace Home\controller;
use  Home\Model\UserModel;
use Think\Controller;
use Home\Model\MenuModel;
class UserController extends Controller{
    
    private $userModel;
    private $menuModel;
    public function __construct(){
        parent::__construct();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
    }
 
    public function login(){
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $i = $this->userModel->login($userName, $userPass);
        if ($i == 1){
            //登录成功
            
            $user = $this->userModel->loadUserByName($userName);
            $_SESSION["loginUser"]=$user;
            
            
            
            $uid = $user[0];
            $data =$this->menuModel->loadTreeMenu($uid);
            $_SESSION["secondMenu"]=$data;
            header("location:http://localhost:8080/mytkp/welcome.php");
        }elseif ($i == 3){
            //用户名不存在
            $_SESSION["loginError"]= "密码错误";
            header("location:../index.php");
        }
        else{
            //密码错误
            $_SESSION["loginError"]= "用户名不存在";
            header("location:../index.php");
        }
    }
}

?>