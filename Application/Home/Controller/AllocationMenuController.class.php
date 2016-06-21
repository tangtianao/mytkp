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
        $data1 = $this->menuModel->field("m.menuid,m.name,1")->table("rolemenu rm, menu m")->where("rm.menuid = m.menuid and rm.rid = %d",$rid)->select();
        $data2 = $this->menuModel->field("m.menuid,m.name")->table("menu m")->select();
        $data = $data1 + $data2;
        $this->display();
    }
}

?>