<?php

namespace Home\Model;
use Home\util\DBUtil;
class UserModel{
    
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    /**
     * 登录验证
     * @param unknown $userName
     * @param unknown $userPass
     * @return number 1表示登录成功 2表示用户名不存在 3表示密码错误
     */
    public function login($userName,$userPass){
        $sql = "select  *  from euser where userName = ?";
        $datas = $this->dbUtil->executeQuery($sql,array($userName));
        if (count($datas) == 1){
            //用户名存在
            if ($userPass == $datas[0][2]) {
                //用户名正确，密码正确
                return 1;
            }else {
                return 3;
            }
        }else{
            return 2;
        }
    }
    
    /**
     * 用户对象，查到保存对象，反之保存空
     * @param unknown $userName
     */
    public function loadUserByName($userName){
        $sql = "select * from euser where userName = ?";
        $datas = $this->dbUtil->executeQuery($sql,array($userName));
        if (count($datas) == 1) {
            return $datas[0];
        }else{
            //用户名不存在
            return null;
        }
        
    }
    
    
}

?>