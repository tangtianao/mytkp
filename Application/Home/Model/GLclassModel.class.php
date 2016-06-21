<?php
namespace Home\Model;
use Home\util\DBUtil;
class GLclassModel{
    
        private  $dbUtil;
        public  function __construct(){
            $this->dbUtil =new DBUtil();
        }
        public function loginClass($pageNo, $pageSize){
            $sql = "select * from class  limit ?,?";
            $page = $this->dbUtil->executePageQuery($sql, $pageNo, $pageSize, array(), \PDO::FETCH_OBJ, 'entity\GLclass');
            return $page;
        }
        public function classType($classType){
            $sql = "select * from class where classType = ?";
            $page = $this->dbUtil->executeQuery($sql,array($classType));
            if ($page == null){
                return null;
            }else {
                return $page[0];
            }
        }
        public function headerid(){
            $sql = "select * from euser where userType=2";
            $page = $this->dbUtil->executeQuery($sql);
            return $page;
        }
        public function manageid(){
            $sql = "select * from euser where userType=3";
            $page = $this->dbUtil->executeQuery($sql);
            return $page;
        }
        public function saveOrUpClass($cid, $name, $classType, $status, $createTime, $beginTime, $endTime, $headerid, $managerid,$remark){
            if ($cid == ""){            
                $sql = "insert into class(name, classType, status, createTime, beginTime, endTime, headerid, managerid,remark) values(?,?,?,?,?,?,?,?,?)";
                $b = $this->dbUtil->executeDML($sql, array($name, $classType, $status, $createTime, $beginTime, $endTime, $headerid, $managerid,$remark));
                return $b;
            }
            
        }
        public function cancelClass($cid){
            $sql = "delete from class where cid in ($cid)";
            $b = $this->dbUtil->executeDML($sql);
            return $b;
        }
        public function combineClass($cids, $combinedHeaderid, $combinedManagerid, $combinedClassName){
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
            }catch (\PDOException $e){
                $pdo->rollBack();
            }
            return true;
        }



















}

?>