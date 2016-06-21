<?php
namespace Model;
use util\DBUtil;

class AllocationModel{
   
    
        private  $dbUtil;
    
        public  function __construct(){
            $this->dbUtil =new DBUtil();
        }
        public function loadMenuByPage(){
            $sql = "select * from  role";
            $page = $this->dbUtil->executeQuery($sql);
            //         $json = json_encode($page);
            return $page;
        }
        public function load12Menu(){
            $sql = "select * from menu";
            //存放数组
            $menus = $this->dbUtil->executeQuery($sql,array(-1),\PDO::FETCH_OBJ,'entity\Menu');
            return $menus;
        }
        
        public function amendEuserRloe($rid,$menuids){
            //关闭自动提交
            $pdo = $this->dbUtil->getPdo();
            
            try {
                $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT,0);
                //开启事务
                $pdo->beginTransaction();
                $sql ="delete from rolemenu where rid = ?";
                $ps =$pdo->prepare($sql);
                $ps->execute(array($rid));
                
                
                
                $sql1 = "insert into rolemenu(rid,menuid) values(?,?)";
                foreach($menuids as $row){
                    $ps = $pdo->prepare($sql1);
                    $ps->execute(array($rid,$row));
                }
                $pdo->commit();
                $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT,1);
            }catch (PDOException $e){
                $pdo->rollBack();
            }
            return true;
        }
        public function loadMenuBy($rid){
        
            $sql = "select m.menuid,m.name,(select 1 from rolemenu rm where rm.menuid = m.menuid and rm.rid = ?) from menu m;";
            //存放数组
            $menus = $this->dbUtil->executeQuery($sql,array($rid));
            return $menus;
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
}
    
?>
