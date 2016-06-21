<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class IndexController extends Controller {
    
    private $menuModel;
    public function __construct(){
        parent::__construct();
        $this->menuModel = new Model("menu");
    }
    public function index(){
        
//         echo $name."--------------".$pwd;
//         echo $_GET["name"]."----".$_GET["pwd"];
//         $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    
        //演示模板中使用函数
        
        $data = $this->menuModel->select();
        $this->assign("data",$data);
        $this->assign("j",9);
        $this->assign("da",count($data));
        $this->assign("msg","<b style='color:red'>没有数据</b>");
        
        $this->display();
    
    }
}