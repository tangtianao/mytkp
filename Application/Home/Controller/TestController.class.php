<?php
namespace controller;
use Model\testModel;
use Think\Controller;
class TestController extends Controller{
 
    
        private $menuModel;
        public function __construct(){
            parent::__construct();
            $this->menuModel = new testModel();
        }
    
        /**分页查询
         * @param
         * @param
         * @param
         * @return 返回个带total和rows索引的二维数组
         */
        public function loadMenuByPage(){
            $pageNo = (int)$_GET["pageNo"];
            $pageSize= (int)$_GET["pageSize"];
            $datas = $this->menuModel->loadMenuByPage($pageNo,$pageSize);
            $json = json_encode($datas);
            echo $json;
        }
    
        /**
         * 添加用户
         */
        public function addMenu(){
            $name = $_POST["name"];
            $url = $_POST["url"];
            $parentid = $_POST["parentid"];
            $isshow = $_POST["isshow"];
            $menuid = $_POST["menuid"];
            $row = $this->menuModel->addMenu($name, $url, $parentid, $isshow,$menuid);
            if ($row){
                echo $row;
            }
        }
        public function cancelMenu(){
            $menuids = $_POST["menuids"];
            $row = $this->menuModel->cancelMenu($menuids);
            $json = json_encode($row);
            echo  $json;
        }
        public function load12Menu(){
            $row = $this->menuModel->load12Menu();
            $json = json_encode($row);
            echo  $json;
        }
        public function loadMenuByID(){
            $menuid = $_GET["menuid"];
            $row = $this->menuModel->loadMenuByID($menuid);
            $json = json_encode($row);
            echo  $json;
        }
    
    
    
 
    
    
    
}

?>