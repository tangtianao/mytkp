<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class AllocationMenuController extends Controller{
    private $menuModel;
    public function __construct(){
        parent::__construct();
        $this->menuModel = new Model();
    }
    /**
     * 打开视图
     */
    public function menuAllocation($rid=-1){

        //$sql = "select m.menuid,m.name,(select 1 from rolemenu rm where rm.menuid = m.menuid and rm.rid = ?) from menu m;";
        //->fetchSql(true)
        $data1 = $this->menuModel->field("m.menuid,m.name")->table("rolemenu rm, menu m")->where("rm.menuid = m.menuid and rm.rid = %d",$rid)->select();
        
        $data2 = $this->menuModel->field("m.menuid,m.name")->table("rolemenu rm, menu m")->where("rm.menuid = m.menuid and rm not like %d",$rid)->select();
        $data = $data1 + $data2;
        print_r($data1);
        echo "<br />";
        print_r($data);
//         $this->assign("data",$data);
//         $this->display();
    }
}

?>