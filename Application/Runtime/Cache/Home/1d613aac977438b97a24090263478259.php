<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>菜单管理</title>
        <link type="text/css"  rel="stylesheet" href="http://localhost:8080/mytyk/Public/easyui/themes/bootstrap/easyui.css">
		<link type="text/css"  rel="stylesheet" href="http://localhost:8080/mytyk/Public/easyui/themes/icon.css">
		<script type="text/javascript" src="http://localhost:8080/mytyk/Public/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytyk/Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytyk/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
            #ff tr{
	           height: 40px;
            } 
            #ff1 tr{
	           height: 40px;
            }    

        </style>
		
		
		<script type="text/javascript">
		$(function(){
			$('#win').window('close');  
			
			$('#dg').datagrid({
				striped:true,    
				method:'GET',
			    url:"http://localhost:8080/mytyk/index.php/Home/Allocation/loadMenuByPage/pageNo/1/pageSize/10",
			    rownumbers:true,
			    pagination: true,
			    frozenColumns:[[
                   {field:'aaaa',checkbox:true}
				]],   
			    columns:[[    
			        {field:'rid',title:'主键id',width:200,align:'center'},   
			        {field:'name',title:'角色类型',width:200,align:'center'},     
			    ]],
			    //table内的下拉列表/添加和删除按钮
			    toolbar: [{
					iconCls: 'icon-modify',
					text:'分配角色菜单',
					handler: function(){
						var selectedRows = $("#dg").datagrid("getSelections");
						if(selectedRows.length == 0){
							alert("请选择后再分配");
							return;
						}
						if(selectedRows.length > 1){
							alert("只能选择一类分配");
							return;
						}
						window.top.add("index.php/Home/AllocationMenu/menuAllocation/rid/"+selectedRows[0][0],"分配角色菜单");
					}
				}]
			}); 
		});
		</script>
    </head>
    <body>
        <table id="dg"></table>
    </body>
</html>