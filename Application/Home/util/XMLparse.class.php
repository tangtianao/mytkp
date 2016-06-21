<?php
namespace Home\util;
/**
 * siXML解析
 * @author 数据库 用户名  密码组成的数组
 *
 */
class XMLparse{
    
    public static function parseDBXML(){

        $sx = simplexml_load_file(dirname(__DIR__)."/config/NewFile.xml");
        //获取某个节点下所有子节点， 返回数组
        $children = $sx->children();
        $mima = array((string)$children[0]->dsn,(string)$children[0]->username,(string)$children[0]->userpass);
        
        return $mima;
        
    }
    
    
}

?>