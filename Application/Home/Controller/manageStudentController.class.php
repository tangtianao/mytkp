<?php
namespace  controller;
use Model\manageStudentModel;
use Think\Controller;
class manageStudentController extends Controller{
    private $manageStudentModel;
    public function __construct(){
        parent::__construct();
        $this->manageStudentModel = new manageStudentModel();
    }
    
    
    public function loadMenuByTeache(){
        $pageNo = (int)$_GET["pageNo"];
        $pageSize= (int)$_GET["pageSize"];
        $datas = $this->manageStudentModel->loadMenuByTeache($pageNo,$pageSize);
        $json =json_encode($datas);
        echo $json;
    }
    function saveOrUpdateUser(){
        $uid  = $_POST["uid"];
        $userName  = $_POST["userName"];
        $userPass  = $_POST["userPass"];
        $userType  = $_POST["userType"];
        $trueName  = $_POST["trueName"];
        $school  = $_POST["school"];
        $sex  = $_POST["sex"];
        $phone  = $_POST["phone"];
        $pid= $_POST["pid"];
        $cid= $_POST["cid"];
        $status  = $_POST["status"];
        $birthDay  = $_POST["birthDay"];
        $address  = $_POST["address"];
        $education = $_POST["education"];
        $regTime = date("Y-m-d H:i:s");
        $datas = $this->manageStudentModel->addMenu($uid, $userName, $userPass, $userType, $trueName, $school, $sex, $phone, $pid, $cid, $regTime,$status, $birthDay, $address, $education);
        if ($datas){
            echo "ok";
        }
    }
    function province(){
        $datas = $this->manageStudentModel->province();
        $jion = json_encode($datas);
        echo $jion;
    }
    function city (){
        $fid = $_GET["fid"];
        $datas = $this->manageStudentModel->city($fid);
        $jion = json_encode($datas);
        echo $jion;
    }
    public function loadMenuByID(){
        $uid = $_GET["uid"];
        $data = $this->manageStudentModel->loadMenuByID($uid);
        $json = json_encode($data);
        echo $json;
    }
    public function cancelMenu(){
        $uid = $_POST["uid"];
        $b = $this->manageStudentModel->cancelMenu($uid);
        echo  $b;
    }
    
    
}

?>