<?php

namespace Home\util;
/**
 * 封装增删改查四种操作为两个普通方法
 * @author j
 *
 */
class DBUtil{
    //解析xml获得数据库密码用户名
    private $mima;
    
    //pdo对象
    private $pdo;
    
    public  function __construct(){
        $this->mima = XMLparse::parseDBXML();
        $this->pdo =new \PDO(C("DB_TYPE").":host=".C("DB_HOST").";dbname=".C("DB_NAME"), C("DB_USER"), C("DB_PWD"), C("DB_PARAMS"));
    }
    public function  getPdo(){
       return  $this->pdo;
    }
    /**
     * 通用的dml语句执行方法
     * @param unknown $sql 将要执行的dml语句  可以带有问号占位符
     * @param array $params 可选参数  当$sql中有问号，此参数必填  $sql没问号可以不填或者null  array()
     * @throws Exception
     * @return true 表示执行成功  fales表示失败
     */
    public function executeDML($sql, array $params=null){
        try{
            $ps = $this->pdo->prepare($sql);
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            return true;
        }catch(\PDOException $e){
            return false;
        }
    }
    
    
    
    /**
     * 通用的查询语句的方法
     * @param unknown $sql  将要执行的查询语句
     * @param array $params  可选参数  当$sql中有问号，此参数必填  $sql没问号此参数可以不填或者null  array()
     * @param unknown $fetchStyle  可选参数  提取数据的方式  默认为PDO::FETCH_NUM 或者PDO::FETCH_OBJ或者PDO::FETCH_ASSOC
     * @param unknown $className   可选参数 当 $fetchStyle为PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名字）
     * @throws Exception
     * @return array 当查询到数据 则返回查询到数据组成的数组 ， 无数据返回array；
     */
    public function executeQuery($sql, array $params=null, $fetchStyle=\PDO::FETCH_NUM,$className=null){
        try {
            $ps = $this->pdo->prepare($sql);
            if ($params!=null && count($params) >0) {
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            if ($fetchStyle == \PDO::FETCH_OBJ){
                $objs=array();
                while ($obj=$ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                return $objs;
            }else{
//                 $objs=array();
//                 while ($obj=$ps->fetchAll($fetchStyle)){
//                     array_push($objs, $obj);
//                 }
                return  $ps->fetchAll($fetchStyle);
            }
        }catch(\Exception $e){
            return false;
        }
        return array();
     }
     
     
     /**
      * 通用的分页语句的方法
      * @param int $pageNO 当前页面最小为1
      * @param int $paramSize  当前显示多少行 
      * @param unknown $sql  将要执行的查询语句
      * @param array $params  可选参数  当$sql中有问号，此参数必填  $sql没问号此参数可以不填或者null  array()
      * @param unknown $fetchStyle  可选参数  提取数据的方式  默认为PDO::FETCH_NUM 或者PDO::FETCH_OBJ或者PDO::FETCH_ASSOC
      * @param unknown $className   可选参数 当 $fetchStyle为PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名字）
      * @throws Exception
      * @return array 当查询到数据 则返回查询到数据组成的数组 ， 无数据返回array；
      */
     public function executePageQuery($sql,$pageNO,$pageSize, array $params=null, $fetchStyle=\PDO::FETCH_NUM,$className=null){
         $page = array();
         try {
             //查询多少行
             $index1 = strpos($sql, "from");
             $index2 = strpos($sql, "limit");
             $sql2 = "select count(*) ".substr($sql, $index1, $index2-$index1);
             $ps = $this->pdo->prepare($sql2);
             if ($params!=null && count($params) > 0) {
                 $ps->execute($params);
             }else {
                 $ps->execute();
             }
             $page["total"]=$ps->fetch(\PDO::FETCH_NUM)[0];
              
              
             $ps = $this->pdo->prepare($sql);
              
//                           echo $sql2;
//                           echo $page["total"];
//                           print_r($page["total"]);
//              $value =  ($pageNO-1)*$pageSize;
             //              统计包含多少个问号
             $countWenhao = 0;
             str_replace("?", "?", $sql,$countWenhao);
             if ($countWenhao>0){
                 $ps->bindParam($countWenhao-1, $value,\PDO::PARAM_INT);
                 $ps->bindParam($countWenhao, $pageSize,\PDO::PARAM_INT);
             }
             if ($params != null && count($params) > 0) {
                 $ps->execute($params);
             }else {
                 $ps->execute();
             }
             if ($fetchStyle == \PDO::FETCH_OBJ){
                 $objs=array();
                 while ($obj=$ps->fetchObject($className)){
                     array_push($objs, $obj);
                 }
                 $page["rows"] = $objs;
             }
             else{
                 $page["rows"]=$ps->fetchAll($fetchStyle);
             }
         }catch(\Exception $e){
         }
         return $page;
     }
     /**
      * 通用的分页语句的方法
      * @param int $pageNO 当前页面最小为1
      * @param int $paramSize  当前显示多少行
      * @param unknown $sql  将要执行的查询语句
      * @param array $params  可选参数  当$sql中有问号，此参数必填  $sql没问号此参数可以不填或者null  array()
      * @param unknown $fetchStyle  可选参数  提取数据的方式  默认为PDO::FETCH_NUM 或者PDO::FETCH_OBJ或者PDO::FETCH_ASSOC
      * @param unknown $className   可选参数 当 $fetchStyle为PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名字）
      * @throws Exception
      * @return array 当查询到数据 则返回查询到数据组成的数组 ， 无数据返回array；
      */
public function executePageSubQuery($datasql,$countsql2,$pageNo,$pageSize,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        //total rows
        $page = array();
    
        try {
            //参数数组补位空 并且元素个数大于0 需要绑定该参数
            $ps = $this->pdo->prepare($datasql);
            $begin = ($pageNo-1)*$pageSize;
            $count = 0;
            str_replace("?", "?", $datasql, $count);
            if($count>0){
                $ps->bindParam($count-1, $begin, \PDO::PARAM_INT);
                $ps->bindParam($count, $pageSize, \PDO::PARAM_INT);
            }
            if ($params != null && count($params) > 0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            if ($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page["rows"] = $objs;
            }else {
                $page["rows"] = $ps->fetchAll($fetchStyle);
            }
            $ps2 = $this->pdo->prepare($countsql2);
            $ps2->execute();
            $page["total"] = $ps2->fetch(\PDO::FETCH_NUM)[0];
        } catch (\PDOException $e) {
        }
        return $page;
    }
     
     public function  amendEuserRloe($sql, array $params=null){
         
         //关闭自动提交
         $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
         //开启事务
         $pdo->beginTransaction();
         
         $sql ="update rolemenu set where rid =?,";
         $b = $this->dbUtil->executeDML($sql,$rid);
         
         $sql1 = "insert into rolemenu(rid,muneid) values(?,?)";
         
         $pdo->commit();
         $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
         $pdo->rollBack();
         
         
         
         
         
     }
     
     
     
     
     
     
        
}
?>