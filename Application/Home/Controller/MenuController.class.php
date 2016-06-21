<?php

namespace Home\controller;
use Think\Controller;
use Think\Model;
class MenuController extends Controller{
    private $menuModel;
    public function __construct(){
        parent::__construct();
        $this->menuModel = new Model("menu");
    }
    /**
     * 打开视图
     */
    public function menu(){
        $this->display();
    }
    
    /**
     * 分页查询
     * @param number $pageNo  参数绑定
     * @param number $pageSize  参数绑定
     */
    public function loadMenuByPage($pageNo=1, $pageSize=10){
        $datas = $this->menuModel->loadMenuByPage($pageNo,$pageSize);
        $this->ajaxReturn($datas);
    }
    public function loadMenuByPag($pageNo=1, $pageSize=10){
        $rows = $this->menuModel->page($pageNo,$pageSize)->table("menu m,menu m2")->field("m.menuid,m.name mname,m.url, m2.name m2name,m.isshow")->where("m.parentid = m2.menuid")->select();
        $total = $this->menuModel->field("count(*) total")->table("menu m,menu m2")->where("m.parentid = m2.menuid")->select();
        $array = array(
            "rows" => $rows,
            "total" =>$total[0]["total"]
        );
        
        $this->ajaxReturn($array);
    }
    
    /**
     * 添加菜单  修改菜单
     * @param unknown $name 参数绑定
     * @param unknown $url 参数绑定
     * @param unknown $parentid 参数绑定
     * @param unknown $isshow 参数绑定
     * @param unknown $menuid 参数绑定  参数为空时候是添加 有参数时候是修改
     */
    public function addMenu($name, $url, $parentid, $isshow,$menuid){
           $array = array(
                "name"=>$name,
                "url"=>$url,
                "parentid"=>$parentid,
                "isshow"=>$isshow
          );
         if ($menuid == null){
            $this->menuModel->add($array);
            echo "ok";
         }else {
              $this->menuModel->where("menuid = %d",$menuid)->save($array);
             echo "ok";
         }
    }
    /**
     * 删除菜单
     * @param unknown $menuids 删除菜单的id
     */
    public function cancelMenu($menuids=null){
        $row = $this->menuModel->where("menuid in ($menuids)")->delete();
        $this->ajaxReturn("ok");
    }
    /**
     * 查询12级菜单做添加用户的父级菜单的下拉菜单
     */
    public function load12Menu(){
        $array = array();
        $row1 = $this->menuModel->field("menuid,name")->where("parentid=-1")->select();
        array_push($array, $row1[0]);
        $row2 = $this->menuModel->field("menuid,name")->where("parentid=%d",$row1[0]["menuid"])->select();
        foreach ($row2 as $s){
            array_push($array,$s);
        }
        $this->ajaxReturn($array);
    }
    /**
     * 查询到需要修改的菜单 并回填
     * @param unknown $menuid 需要查询的菜单的id
     */
    public function loadMenuByID($menuid=null){
        $row = $this->menuModel->where("menuid = %d",$menuid)->find();
        $this->ajaxReturn($row);
    }
  
    
    
}

?>