<?php
namespace Model;
use util\DBUtil;
class manageStudentModel{
    private  $dbUtil;
    
    public  function __construct(){
        $this->dbUtil =new DBUtil();
    }
    
    public function loadMenuByTeache($pageNo,$pageSize){
        $sql = "select * from  euser where userType=4 limit ?,?";
        $sql2 = "select count(*) from euser where userType=4";
        $page = $this->dbUtil->executePageSubQuery($sql, $sql2, $pageNo, $pageSize, null, \PDO::FETCH_OBJ, 'entity\Euser');
        //         $json = json_encode($page);
        return $page;
    }
    public function loadMenuByID($uid){
        $sql = "select * from  euser where uid=?";
        $page = $this->dbUtil->executeQuery($sql,array($uid), \PDO::FETCH_OBJ, 'entity\Euser');
        return $page[0];
    }
    public function addMenu($uid, $userName, $userPass, $userType, $trueName, $school, $sex, $phone, $pid, $cid, $regTime,$status, $birthDay, $address, $education){
        if($uid == ""){
            $sql = "insert into euser(userName, userPass, userType, trueName, sex, birthDay, phone, school,education, regTime,status, pid,cid,address) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $b = $this->dbUtil->executeDML($sql,array($userName, $userPass, $userType, $trueName, $sex, $birthDay, $phone, $school, $education, $regTime,$status, $pid, $cid, $address));
            if ($b){
                return "ok";
            }
        }else {
            $sql = "update euser set userName=?, userPass=?, userType=?, trueName=?, sex=?, birthDay=?, phone=?, school=?, education=?,  status=?, pid=?, cid=?, address=? where uid=?";
            $b = $this->dbUtil->executeDML($sql,array($userName, $userPass, $userType, $trueName, $sex, $birthDay, $phone, $school, $education, $status, $pid, $cid, $address,$uid));
            if ($b){
                return "ok";
            }
        }
    }
    public function province(){
        $sql = "select * from province";
        $b = $this->dbUtil->executeQuery($sql,null,\PDO::FETCH_OBJ, 'entity\Euser');
        if ($b){
            return $b;
        }
    }
    public function city($fid){
        $sql = "select * from city where pid = ?";
        $b = $this->dbUtil->executeQuery($sql,array($fid),\PDO::FETCH_OBJ, 'entity\Euser');
        if ($b){
            return $b;
        }
    }
    public function cancelMenu($uid){
        $sql = "delete from euser where uid in ($uid)";
        $b = $this->dbUtil->executeDML($sql);
        return $b;
    
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>