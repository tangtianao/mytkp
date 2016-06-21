<?php
session_start();
?>
<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8" />
		<title></title>
		<link type="text/css"  rel="stylesheet" href="Public/easyui/themes/bootstrap/easyui.css">
		<link type="text/css"  rel="stylesheet" href="Public/easyui/themes/icon.css">
		<script type="text/javascript" src="Public/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="Public/easyui/locale/easyui-lang-zh_CN.js"></script>

		<script type="text/javascript">
			
		function add(url, name ){
			if($('#tabs').tabs('exists',name)){
				$('#tabs').tabs('select'.name);
    		}else{
    			$('#tabs').tabs('add',{
    				title: name,
    				selected:true,
    				closable:true,
    				content:"<iframe name='"+name+"' src='"+url+"' frameborder='0' width='100%' height='100%' scrolling='no'></iframe>"
    			});	
			}
    	}
		</script>
		<style type="text/css">
		#topzuo{
	       height: 90px;
		   border: 1px solid red;
		   display: block;
		   float: left; 
		   width: 200px;
		}
	    #topyou	{
	       height: 90px;
		   border: 1px solid red;
		   display: block;
		   float:right; 
	       width: 200px;
	    }
		
		
		</style>
	</head>
	<body class="easyui-layout">   
        <div data-options="region:'north',split:true" style="height:100px;">
		 <div id = "topzuo"></div>        
         <div id = "topyou">
             <div>
                 <?php 
                 echo "欢迎:". $_SESSION["loginUser"][4];
                 ?>
             </div>
         </div> 
        
        </div>   
        <div data-options="region:'west',title:'菜单',split:true" style="width:200px;">
        	<ul id="tt" class="easyui-tree">   
                <?php 
                if (array_key_exists("secondMenu", $_SESSION)){
                    $secondMenu = $_SESSION["secondMenu"];
                    foreach ($secondMenu as $menu2){
                        echo "<li>";
                        echo "<span>{$menu2[1]}</span>";
                        echo "<ul>";
                        foreach ($menu2[5] as $menu3){
                            echo "<li>";
                            echo "<span><a href=\"javascript:add('{$menu3[2]}','{$menu3[1]}')\">{$menu3[1]}</a></span>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</li>";
                    }
                }
                ?> 
            </ul>
        </div>   
        <div data-options="region:'center'," style="padding:5px;background:#eee;">
            <div id="tabs" class="easyui-tabs" data-options="fit:true">   
                <div title="欢迎你" data-options="closable:true">   
                    	欢迎你    
                </div> 
            </div>  
        </div> 
    </body>
</html>