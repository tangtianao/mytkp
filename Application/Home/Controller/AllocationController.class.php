<?php
namespace Home\controller;
use Think\Controller;
use Think\Model;
class AllocationController extends Controller{

        private $AllocationModel;
        public function __construct(){
            parent::__construct();
            $this->AllocationModel = new Model();
        }
        public function allocationMenu(){
            $this->display();
        }
        /**分页查询
         * @param 
         * @param
         * @param
         * @return 返回个带total和rows索引的二维数组
         */
        public function loadMenuByPage(){
            
            $page["rows"] = $this->AllocationModel->table("role")->select();
            $page["total"]  = $this->AllocationModel->field("count(*) aa")->table("role")->select();
            $this->ajaxReturn($page);
        }
        public function loadMenuByID(){
            $row = $this->AllocationModel->load12Menu();
            $json = json_encode($row);
           return   $row;
        }
        public function amendEuserRloe(){
            
            $rid = $_POST["rid"];
            if(array_key_exists("menuids", $_POST)){
                $menuids = $_POST["menuids"];
            }else{
                $menuids = array();
            }
            $row = $this->AllocationModel->amendEuserRloe($rid,$menuids);
            if($row){
                   $_SESSION["cuo"] = "角色菜单修改成功";
//                 $this->AllocationModel->loadMenuBy($rid);
                header("location:../view/newfile.php?rid=".$rid);
            }
        }
}
?>
    
