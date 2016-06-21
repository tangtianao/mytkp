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
     * 鎵撳紑瑙嗗浘
     */
    public function classManage(){
        $this->display();
    }
    /**
     * //鏌ヨ鐝骇鍒楄〃 骞朵笖杩樺彲浠ユ寜鐝骇 椤圭洰缁忕悊 鐝富浠� 鏃堕棿 鎼滅储
     * @param number $pageNo 缁戝畾鍙傛暟
     * @param number $pageSize  缁戝畾鍙傛暟
     * @param unknown $className 缁戝畾鍙傛暟
     * @param unknown $headerName 缁戝畾鍙傛暟
     * @param unknown $manageName 缁戝畾鍙傛暟  
     * @param unknown $createtime1 缁戝畾鍙傛暟
     * @param unknown $createtime2 缁戝畾鍙傛暟
     * @param unknown $begintime1 缁戝畾鍙傛暟
     * @param unknown $begintime2 缁戝畾鍙傛暟
     * @param unknown $endtime1 缁戝畾鍙傛暟
     * @param unknown $endtime2 缁戝畾鍙傛暟
     * @param unknown $status 缁戝畾鍙傛暟
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
     * 娣诲姞鐝骇 
     * @param unknown $cid 缁戝畾鍙傛暟
     * @param unknown $headerid 缁戝畾鍙傛暟
     * @param unknown $managerid 缁戝畾鍙傛暟
     * @param unknown $managerid 缁戝畾鍙傛暟
     * @param unknown $classType 缁戝畾鍙傛暟
     * @param unknown $remark 缁戝畾鍙傛暟
     * @param unknown $createTime 缁戝畾鍙傛暟
     */
    public function saveOrUpClass($cid, $headerid, $managerid, $managerid, $classType,$remark,$createTime){
        $status = 1;
        $endTime =  date("Y-m-d H:i:s");
        
        //鏍规嵁鐝骇绫诲瀷 璁惧畾鐝骇鍚嶅瓧  缁撲笟鏃堕棿
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
     * 鏌ヨ鐝富浠伙紝鍥炲～椤圭洰缁忕悊涓嬫媺鍒楄〃妗�
     */
    public function headerid(){
        $data = array(array("uid"=>-1,"truename"=>"璇锋寚瀹氱彮涓讳换鍚嶅瓧"));
        $row = $this->GLclassModel->field("uid,truename")->table("euser")->where("userType = 2")->select();
        foreach ($row as $d){
            array_push($data, $d);
        }
        echo json_encode($data);
        
    }
    /**
     * 鏌ヨ椤圭洰缁忕悊锛屽洖濉」鐩粡鐞嗕笅鎷夊垪琛ㄦ
     */
    public function manageid(){
        $data = array(array("uid"=>-1,"truename"=>"璇锋寚瀹氶」鐩粡鐞嗗悕瀛�"));
        $row = $this->GLclassModel->field("uid,truename")->table("euser")->where("userType = 3")->select();
        foreach ($row as $d){
            array_push($data, $d);
        }
        echo json_encode($data);
    
    }
    
   
    /**
     * 妫�鏌ユ墍鏈夌彮绾т粖澶╂槸鍚︽湁鑰冭瘯
     * @param unknown $cids 鍙傛暟缁戝畾 鏈�灏戜袱涓猚id锛�1,2,3锛�
     */
    public function checkExamToday($cids = null){
        $d = date("Y-m-d");
        $db = $d." 00:00:00";
        $de = $d." 23:59:59";
       //鍦ㄨ�冭瘯瀹夋帓鍙樻煡璇㈡槸鍚︽湁鐝骇鍦ㄨ�冭瘯
        $data = $this->GLclassModel->table("exam")->where("classid in($cids) and beginTime between '$db' and '$de'")->select();
        if (count($data)>0){
            $classids = array();
            //鍙栧埌鏈夎�冭瘯鐝骇鐨刬d
            foreach ($data as $exam){
                array_push($classids, $exam["classid"]);
            }
            $str = implode(",", $classids);
            //鏌ヨ鏈夎�冭瘯鐝骇鐨勫悕瀛�
            $r = $this->GLclassModel->field("name")->where("cid in ($str)")->select();
            $names = array();
            foreach ($r as $n){
                array_push($names,$n["name"]);
            }
            $this->ajaxReturn("瀵逛笉璧�".implode(",", $names)."浠婂ぉ鏈夎�冭瘯锛佷笉鑳藉悎骞�","EVAL");
        }else {
            $this->ajaxReturn("ok","EVAL");            
        }
    }
    /**
     * 鍚堝苟鐝骇
     * @param unknown $cids 瑕佸悎骞剁殑鐝骇涓�
     * @param unknown $combinedHeaderid  鍚堝苟鍚庣殑鐝富浠籭d
     * @param unknown $combinedManagerid 鍚堝苟鍚庨」鐩粡鐞唅d
     * @param unknown $combinedClassid 鍚堝苟鍚庝繚鐣欑彮绾d
     */
    public function combineClass($cids=null, $combinedHeaderid=-1, $combinedManagerid=-1, $combinedClassid=-1){
        try {
            $this->GLclassModel->setProperty(\PDO::ATTR_AUTOCOMMIT, FALSE);
            $this->GLclassModel->startTrans();//寮�鍚簨鐗�
            //鏌ヨ瑕佸悎骞剁殑鐝骇
            $classes = $this->GLclassModel->where("cid in ($cids)")->select();
            $coun = 0;
            foreach ($classes as $c){
                if ($c["cid"] == $combinedClassid){
                }else {
                    $coun += $c["stucount"];
                    $c["stucount"]=0;
                    $c["status"]=3;
                    //淇敼鏈悎骞剁殑鐝骇浜烘暟璺熺姸鎬�
                    $this->GLclassModel->save($c);
                    //淇敼鐢ㄦ埛琛ㄥ睘浜庤鍚堝苟鐝骇鐨勫鐢� 鏀逛负鍚堝苟鍚庣殑鐝骇鐨刬d
                    $sql = "update euser set classid=%d where classid =%d";
                    $this->GLclassModel->execute($sql, $combinedClassid, $c["cid"]);
                }
            }
            //鏌ヨ瑕佷繚鐣欑殑鐝骇
            $c = $this->GLclassModel->table("class")->where("cid=%d", $combinedClassid)->find();
            $c["headerid"]=$combinedHeaderid;
            $c["managerid"]=$combinedManagerid;
            $c["stucount"] += $coun;
            //淇敼瑕佷繚鐣欑彮绾х殑 椤圭洰缁忕悊 鐝富浠� 浜烘暟
            $w =  $this->GLclassModel->save($c);
            
            $this->GLclassModel->commit();//鎻愪氦浜嬬墿
        }catch (\PDOException $e){
            $this->GLclassModel->rollback();//浜嬪姟鍥炴粴鍒颁笂涓�娆℃彁浜ゅ悗鐨勬暟鎹姸鎬�
        }
        //璋冪敤鍒锋柊椤甸潰鏂规硶 鏄痡son鏍煎紡杩斿洖
        $this->loginClass();
    }
    
    
    
    
    
    
}

?>