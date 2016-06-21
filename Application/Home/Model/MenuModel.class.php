<?php 
namespace  Home\Model;
use Home\util\DBUtil;
/**
 * 
 * @author 
 *
 */
class MenuModel{
   private  $dbUtil;
   public  function __construct(){
       $this->dbUtil =new DBUtil();
   }
   
   
   /**首页侧边树形菜单紧挨着数据
    * @return 返回所有二级菜单,且每个二级菜单下面都包含自己的子菜单
    * 
    */
 public function loadTreeMenu($uid){
        $menu2 = array();
        $m2s = array();
        $sql = "select m.* from userrole ur,rolemenu rm,menu m where ur.rid=rm.rid and rm.menuid=m.menuid and m.isshow=1 and ur.uid=? and m.parentid=?";
        //查询一级菜单 只有一个
        $menus = $this->dbUtil->executeQuery($sql,array($uid,-1));
//         if (count($menu2)>0){
            $menu1 = $menus[0];
            //查询二级菜单，通过一级菜单主键ID区查询
            $menu2 = $this->dbUtil->executeQuery($sql,array($uid,$menu1[0]));
            //循环每一个二级菜单，通过每一个二级菜单的主键ID去查询他下面的子菜单
            foreach ($menu2 as $second){
                $m2 = array();
                array_push($m2, $second[0],$second[1],$second[2],$second[3],$second[4]);
                $menu3 = $this->dbUtil->executeQuery($sql,array($uid,$second[0]));
//                 $second->setChildren($menu3);
                array_push($m2, $menu3);
                array_push($m2s, $m2);
            }
//         }
        return $m2s;
    }
    
    
    /**
     * 分页查询菜单列表
     * @param unknown $pageNo
     * @param unknown $pageSize
     */
     public function loadMenuByPage($pageNo,$pageSize){
         $value = ($pageNo-1)*$pageSize;
        $sql = "select m.menuid,m.name,m.url, m2.name as parentName,m.isshow from menu m,menu m2 where m.parentid = m2.menuid limit $value,$pageSize";
        $sql2 = "select count(*) from menu";
        $page = $this->dbUtil->executePageSubQuery($sql, $sql2 ,$pageNo, $pageSize, array(), \PDO::FETCH_OBJ, 'Home\entity\Menu');
        return $page;

    }
    
    
    public function addMenu( $name, $url, $parentid,$isshow,$menuid){
        if($menuid == ""){
            $sql = "insert into menu(name,url,parentid,isshow) values(?,?,?,?)";
            $b = $this->dbUtil->executeDML($sql,array( $name, $url, $parentid,$isshow));
            if ($b){
                return "ok";
            }
        }else {
            $sql = "update menu set name=?, url=?, parentid=?, isshow=? where menuid=?";
            $b = $this->dbUtil->executeDML($sql,array($name, $url, $parentid,$isshow,$menuid));
            if ($b){
                return "ok";
            }
        }
    }
    public function loadMenuByID($menuid){ 
        $sql = "select *  from menu where menuid= ?";
        $menus = $this->dbUtil->executeQuery($sql,array($menuid),\PDO::FETCH_OBJ, 'Home\entity\Menu');
        return $menus[0];
    }
    
    
    public function cancelMenu($menuid){
        $sql = "delete from menu where menuid in ($menuid)";
        $b = $this->dbUtil->executeDML($sql);
        return $b;
        
    }
        
    public function load12Menu(){
        $sql = "select * from menu where parentid=?";
        //存放数组
        
        $fsmenu = array();
        $menus = $this->dbUtil->executeQuery($sql,array(-1),\PDO::FETCH_OBJ,'Home\entity\Menu');
        $menu1 = $menus[0];
        $menu1->setName("一级->".$menu1->getName());
        //一级菜单放入数组
        array_push($fsmenu, $menu1);
        $menu2 = $this->dbUtil->executeQuery($sql,array($menu1->getMenuid()),\PDO::FETCH_OBJ,'Home\entity\Menu');
        foreach ($menu2 as $second){
            $second->setName("二级->".$second->getName());
            array_push($fsmenu, $second);
        }
        return $fsmenu;
    }    
    public function loadMenuBy($rid){
    
        $sql = "select m.menuid,m.name,(select 1 from rolemenu rm where rm.menuid = m.menuid and rm.rid = ?) from menu m;";
        //存放数组
        $menus = $this->dbUtil->executeQuery($sql,array($rid));
        return $menus;
    }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
}

?>