<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>菜单管理</title>
        <link type="text/css"  rel="stylesheet" href="http://localhost:8080/mytkp/Public/easyui/themes/bootstrap/easyui.css">
		<link type="text/css"  rel="stylesheet" href="http://localhost:8080/mytkp/Public/easyui/themes/icon.css">
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
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
			$('#win').window('close');  // close a window  
			$('#dg').datagrid({
				striped:true,    
				method:'GET',
			    url:"http://localhost:8080/mytkp/index.php/Home/Menu/loadMenuByPag/pageNo/1/pageSize/10",
			    rownumbers:true,
			    pagination: true,
			    frozenColumns:[[
                   {field:'aaaa',checkbox:true}
				]],   
			    columns:[[    
			        {field:'menuid',title:'主键id',hidden:true},   
			        {field:'mname',title:'菜单名字',width:100,align:'center'},     
			        {field:'url',title:'菜单地址',width:100,align:'center'},
			        {field:'m2name',title:'父级菜单id',width:100,align:'center'}, 
			        {field:'isshow',title:'是否显示',width:100,align:'center', formatter: function(value){
						if (value==1){
							return "显示";
						} else {
							return "不显示";
						}
					}}
			    ]],
			    toolbar: [{
					iconCls: 'icon-adduser',
					text:'添加',
					handler: function(data){
						$("#ff").form('reset');
						$('#parentid').combobox({    
    					    url:"http://localhost:8080/mytkp/index.php/Home/Menu/load12Menu",    
    					    valueField:'menuid',    
    					    textField:'name'   
    					});
						$('#win').window('open');  // open a window   
					}
				},'-',{
					iconCls: 'icon-delete',
					text:'删除',
					handler: function(){
						var selectedRows = $("#dg").datagrid("getSelections");
						if(selectedRows.length ==0){
							alert("请选择后再删除");
							return;
						}
						if(window.confirm("你真的确定删除这些数据吗？")){
							var menuids = new Array();
							for(var i= 0;i<selectedRows.length;i++){
								menuids.push(selectedRows[i].menuid);
							}
							$.post("http://localhost:8080/mytkp/index.php/Home/Menu/cancelMenu",{
								"menuids":menuids.join(",")
							},function(data){
								if(data){
									refres(1,10);
								}
							},"text");
						}
					}
				},'-',{
					iconCls: 'icon-modify',
					text:'修改',
					handler: function(){
						var selectedRows = $("#dg").datagrid("getSelections");
						if(selectedRows.length == 0){
							alert("请选择后再修改");
							return;
						}
						if(selectedRows.length > 1){
							alert("只能选择一行修改");
							return;
						}
						$('#parentid').combobox({    
    					    url:'http://localhost:8080/mytkp/index.php/Home/Menu/load12Menu',  
    					    valueField:'menuid',    
    					    textField:'name'   
    					});
						var row = selectedRows[0];
						$("#ff").form('reset');
						$.getJSON("http://localhost:8080/mytkp/index.php/Home/Menu/loadMenuByID/menuid/"+row.menuid,{},function(data){
							$("#menuid").val(data.menuid);
							$("#name").val(data.name);
							$("#url").val(data.url);
							$("#parentid").combobox("setValue",data.parentid);
						});
						$('#win').window('open');
					}
				},'-',{
					iconCls: 'icon-refresh',
					text:'刷新',
					handler: function(){
						refres(1,10);
					}
				}]
			}); 
			var pager = $("#dg").datagrid("getPager");
			pager.pagination({
				pageList:[5,10,20],//设置一页的行数
				//翻页函数
				onSelectPage:function(pageNumber, pageSize){
					refres(pageNumber,pageSize);
				}
			});
		});
		//刷新页面调用函数
		function refres(pageNumber,pageSize){
			$("#dg").datagrid('loading');
			$.getJSON("http://localhost:8080/mytkp/index.php/Home/Menu/loadMenuByPag/pageNo/"+pageNumber+"/pageSize/"+pageSize,{

			},function(result){
				$("#dg").datagrid('loadData',{
					rows:result.rows,
					total:result.total
				});
				var pager = $("#dg").datagrid("getPager");
				pager.pagination({
					pageNumber:pageNumber,
					pageSize:pageSize
				});
				$("#dg").datagrid('loaded');
			});
		}
		//添加  修改调用函数
		function upMenu(){
			var name  	 = $("#name").val();
			var url 	 = $("#url").val();
			var parentid = $("#parentid").combo('getValue');
			var isshow 	 = $("#isshow").combo('getValue');
			var menuid   = $("#menuid").val();
			$.post("http://localhost:8080/mytkp/index.php/Home/Menu/addMenu",{
				"name"		:name,
				"url"		:url,
				"parentid"	:parentid,
				"isshow"	:isshow,
				"menuid"     :menuid
			},function(data){
				if(data == "ok"){
					refres(1,10);
					$('#win').window('close');
				}else if(data == "ok"){
					refres(1,10);
					$('#win').window('close');
				}
			},"text");
		}
		</script>
    </head>
    <body>
        <table id="dg"></table>
    	<div id="win" class="easyui-window" title="My Window" style="width:600px;height:400px"   
                data-options="iconCls:'icon-save',modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false">   
            <form id="ff" method="post">
            	<input type="hidden" id ="menuid" name="menuid">
            	<table id="formtable" style="width: 60%;margin:auto;margin-top:20px;">
            		<tr>
            			<td align="right"><label  for="name">菜单名称：</label></td>
            			<td><input class="easyui-validatebox" type="text" id="name" name="name" data-options="required:true" placeholder="请输入菜单名称"/></td>
            		</tr>
            		<tr>
            			<td align="right"><label  for="url">菜单URL：</label></td>
            			<td><input class="easyui-validatebox" type="text" id="url" name="url" data-options="" placeholder="若添加非最低级菜单，此项可不填"/></td>
            		</tr>
            		<tr>
            			<td align="right"><label  for="parentid">父级菜单：</label></td>
            			<td><input id="parentid" name="parentid"  value="请选择父级菜单"></td>
            		</tr>
            		<tr>
            			<td align="right"><label  for="isshow">是否展示：</label></td>
            			<td>
            				<select class="easyui-combobox" id="isshow"  name="isshow" style="width: 150px;" >
            					<option value="1">展示</option>
            					<option value="0">不展示</option>
            				</select>
            			</td>
            		</tr>
            		<tr>
            			<td align="center" colspan="2">
            				<a id="btn" href="javascript:upMenu();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">确定</a>
            			</td>
            		</tr>
            	</table>   
            </form>
        </div>
    </body>
</html>