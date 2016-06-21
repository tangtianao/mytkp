<?php
namespace Home\controller;
use Think\Controller;
use Think\Model;
class GLclassController extends Controller{
    private $GLclassModel;
    public function __construct(){
        parent::__construct();
        $this->GLclassModel = new Model("class");
    }
    /**
     * 打开视图
     */
    public function classManage(){
        $this->display();
    }
    /**
     * //查询班级列表 并且还可以按班级 项目经理 班主任 时间 搜索
     * @param number $pageNo 绑定参数
     * @param number $pageSize  绑定参数
     * @param unknown $className 绑定参数
     * @param unknown $headerName 绑定参数
     * @param unknown $manageName 绑定参数  
     * @param unknown $createtime1 绑定参数
     * @param unknown $createtime2 绑定参数
     * @param unknown $begintime1 绑定参数
     * @param unknown $begintime2 绑定参数
     * @param unknown $endtime1 绑定参数
     * @param unknown $endtime2 绑定参数
     * @param unknown $status 绑定参数
     */
    public function loginClass($pageNo=1,$pageSize=10,
        $className=null,$headerName=null,$manageName=null,
        $createtime1=null,$createtime2=null,$begintime1=null,$begintime2=null,
        $endtime1=null,$endtime2=null,$status=-1){
        
            $sql = " from class c,euser u1,euser u2 where c.headerid=u1.uid and c.managerid=u2.uid ";
            if ($className != null){
                $sql .=" and c.name like '%$className%'";
            }
            if ($headerName!=null){
                $sql .=" and u1.trueName like '%$headerName%'";
            }
            if ($manageName!=null){
                $sql .=" and u2.trueName like '%$manageName%'";
            }
            if ($createtime1!=null){
                $sql .=" and c.createTime >= '".$createtime1."'";
                $queryConditions["c.createTime"]=array("EGT","'".$createtime1."'");
            }
            if ($createtime2!=null){
                $sql .=" and c.createTime <= '".$createtime2."'";
            }
            if ($begintime1!=null){
                $sql .=" and c.beginTime >= '".$begintime1."'";
            }
            if ($begintime2!=null){
                $sql .=" and c.beginTime <= '".$begintime2."'";
            }
            if ($endtime1!=null){
                $sql .=" and c.endTime >= '".$endtime1."'";
            }
            if ($endtime2!=null){
                $sql .=" and c.endTime <= '".$endtime2."'";
            }
            if ($status != -1){
                $sql .=" and c.status = '".$status."'";
            }
            $count = $this->GLclassModel->query("select count(*) as cc ".$sql)[0]["cc"];
            $page["total"] =$count;
            $begin = ($pageNo-1)*$pageSize;
            $rows =$this->GLclassModel->query("select c.cid,c.name,c.classtype,c.status,c.createtime,c.begintime,c.endtime,u1.truename as headername,
            u2.truename as managename,c.stucount,c.remark".$sql."limit $begin,$pageSize");
            $page["rows"] =$rows;
            $this->ajaxReturn($page);
    
    }
    
    /**
     * 添加班级 
     * @param unknown $cid 绑定参数
     * @param unknown $headerid 绑定参数
     * @param unknown $managerid 绑定参数
     * @param unknown $managerid 绑定参数
     * @param unknown $classType 绑定参数
     * @param unknown $remark 绑定参数
     * @param unknown $createTime 绑定参数
     */
    public function saveOrUpClass($cid, $headerid, $managerid, $managerid, $classType,$remark,$createTime){
        $status = 1;
        $endTime =  date("Y-m-d H:i:s");
        
        //根据班级类型 设定班级名字  结业时间
        if ($classType == 1){
            $row = $this->GLclassModel->where("classType = $classType")->select();
            if($row == null){
                $name = "f1";
            }else{
                $nametou = "f";
                 $result = substr($row[0]["name"],1);
                 $name = $nametou.++$result;
            }
            $beginTime = date('Y-m-d', strtotime ("+8 month", strtotime($createTime)));
        }elseif ($classType==3){
            $row = $this->GLclassModel->where("classType = $classType")->select();
            
            if($row == null){
                $name = "h1";
            }else{
                $nametou = "h";
                 $result = substr($row[0]["name"],1);
                 $name = $nametou.++$result;
            }
            $beginTime = date('Y-m-d', strtotime ("+5 month", strtotime($createTime)));
        }elseif($classType==2){
            $row = $this->GLclassModel->where("classType = $classType")->select();
            
            if($row == null){
                $name = "w1";
            }else{
                $nametou = "w";
                 $result = substr($row[0]["name"],1);
                 $name = $nametou.++$result;
            }
            $beginTime = date('Y-m-d', strtotime ("+4 month", strtotime($createTime)));
        }else {
            $row = $this->GLclassModel->where("classType = $classType")->select();
            
            if($row == null){
                $name = "u1";
            }else{
                $nametou = "u";
                $result = substr($row[0]["name"],1);
                $name = $nametou.++$result;
            }
            $beginTime = date('Y-m-d', strtotime ("+4 month", strtotime($createTime)));
        }
        $data = array(
            "name"=>$name,
            "classType"=>$classType,
            "status"=>$status, 
            "createTime"=>$createTime, 
            "beginTime"=>$beginTime, 
            "endTime"=>$endTime, 
            "headerid"=>$headerid, 
            "managerid"=>$managerid,
            "remark"=>$remark
        );
        $b = $this->GLclassModel->add($data);
        if ($b){
            echo "ok";
        }
    }
    /**
     * 查询班主任，回填项目经理下拉列表框
     */
    public function headerid(){
        $data = array(array("uid"=>-1,"truename"=>"请指定班主任名字"));
        $row = $this->GLclassModel->field("uid,truename")->table("euser")->where("userType = 2")->select();
        foreach ($row as $d){
            array_push($data, $d);
        }
        echo json_encode($data);
        
    }
    /**
     * 查询项目经理，回填项目经理下拉列表框
     */
    public function manageid(){
        $data = array(array("uid"=>-1,"truename"=>"请指定项目经理名字"));
        $row = $this->GLclassModel->field("uid,truename")->table("euser")->where("userType = 3")->select();
        foreach ($row as $d){
            array_push($data, $d);
        }
        echo json_encode($data);
    
    }
    
   
    /**
     * 检查所有班级今天是否有考试
     * @param unknown $cids 参数绑定 最少两个cid（1,2,3）
     */
    public function checkExamToday($cids = null){
        $d = date("Y-m-d");
        $db = $d." 00:00:00";
        $de = $d." 23:59:59";
       //在考试安排变查询是否有班级在考试
        $data = $this->GLclassModel->table("exam")->where("classid in($cids) and beginTime between '$db' and '$de'")->select();
        if (count($data)>0){
            $classids = array();
            //取到有考试班级的id
            foreach ($data as $exam){
                array_push($classids, $exam["classid"]);
            }
            $str = implode(",", $classids);
            //查询有考试班级的名字
            $r = $this->GLclassModel->field("name")->where("cid in ($str)")->select();
            $names = array();
            foreach ($r as $n){
                array_push($names,$n["name"]);
            }
            $this->ajaxReturn("对不起".implode(",", $names)."今天有考试！不能合并","EVAL");
        }else {
            $this->ajaxReturn("ok","EVAL");            
        }
    }
    /**
     * 合并班级
     * @param unknown $cids 要合并的班级为
     * @param unknown $combinedHeaderid  合并后的班主任id
     * @param unknown $combinedManagerid 合并后项目经理id
     * @param unknown $combinedClassid 合并后保留班级id
     */
    public function combineClass($cids=null, $combinedHeaderid=-1, $combinedManagerid=-1, $combinedClassid=-1){
        try {
            $this->GLclassModel->setProperty(\PDO::ATTR_AUTOCOMMIT, FALSE);
            $this->GLclassModel->startTrans();//开启事物
            //查询要合并的班级
            $classes = $this->GLclassModel->where("cid in ($cids)")->select();
            $coun = 0;
            foreach ($classes as $c){
                if ($c["cid"] == $combinedClassid){
                }else {
                    $coun += $c["stucount"];
                    $c["stucount"]=0;
                    $c["status"]=3;
                    //修改本合并的班级人数跟状态
                    $this->GLclassModel->save($c);
                    //修改用户表属于被合并班级的学生 改为合并后的班级的id
                    $sql = "update euser set classid=%d where classid =%d";
                    $this->GLclassModel->execute($sql, $combinedClassid, $c["cid"]);
                }
            }
            //查询要保留的班级
            $c = $this->GLclassModel->table("class")->where("cid=%d", $combinedClassid)->find();
            $c["headerid"]=$combinedHeaderid;
            $c["managerid"]=$combinedManagerid;
            $c["stucount"] += $coun;
            //修改要保留班级的 项目经理 班主任 人数
            $w =  $this->GLclassModel->save($c);
            
            $this->GLclassModel->commit();//提交事物
        }catch (\PDOException $e){
            $this->GLclassModel->rollback();//事务回滚到上一次提交后的数据状态
        }
        //调用刷新页面方法 是json格式返回
        $this->loginClass();
    }
    
    
    
    
    
    
}

?>