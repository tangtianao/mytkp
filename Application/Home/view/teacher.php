<?php

session_start();
$manageid = $_GET["fid"];


// echo $manageid;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>菜单管理</title>
        <link type="text/css"  rel="stylesheet" href="../easyui/themes/bootstrap/easyui.css">
		<link type="text/css"  rel="stylesheet" href="../easyui/themes/icon.css">
		<script type="text/javascript" src="../easyui/jquery.min.js"></script>
		<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../easyui/locale/easyui-lang-zh_CN.js"></script>
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
			    url:"../controller/main.php?pageNo=1&pageSize=10&controller=TeacherController&methodName=loadMenuByPage&manageid=<?php echo $manageid;?>",
			    rownumbers:true,
			    pagination: true,
			    frozenColumns:[[
                   {field:'aaaa',checkbox:true}
				]],   
			    columns:[[    
			        {field:'teacherid',title:'主键id',hidden:true},   
			        {field:'teachername',title:'名字',width:100,align:'center'},     
			        {field:'teacherturl',title:'地址',width:100,align:'center'},
			        {field:'manageid',title:'父级id',width:100,align:'center'}
			    ]],
			    //table内的下拉列表/添加和删除按钮
			    
			    toolbar: [{
    				iconCls: 'icon-add2',
    				text:'添加',
    				handler: function(){
    					$("#ff").form('reset');
        				//每次打开窗口前加载一二级菜单作为父级菜单下拉列表的选项
    					$('#parentid').combobox({    
    					    url:"../controller/main.php?controller=CaidanController&methodName=load12Menu",    
    					    valueField:'menuid',    
    					    textField:'name'   
    					});
        				
    					$('#win').window('open');
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
							$.post("../controller/main.php?controller=CaidanController&methodName=cancelMenu",{
								"menuids":menuids.join(",")
							},function(data){
								
								refres(1,10);
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
    					    url:'../controller/main.php?controller=CaidanController&methodName=load12Menu',  
    					    valueField:'menuid',    
    					    textField:'name'   
    					});
						var row = selectedRows[0];
						$("#ff").form('reset');
						$.getJSON("../controller/main.php?controller=CaidanController&methodName=loadMenuByID&menuid="+row.menuid,{},function(data){
							$("#menuid").val(data.menuid);
							$("#name").val(data.name);
							$("#url").val(data.url);
							$("#parentid").combobox("setValue",data.parentid);
							$('#win').window('open');
						});
						
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
		function refres(pageNumber,pageSize){
			$("#dg").datagrid('loading');
			$.getJSON("../controller/main.php?pageNo=1&pageSize=10&controller=CaidanController&methodName=loadMenuByPage&pageNo="+pageNumber+"&pageSize="+pageSize,{

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
		function upMenu(){
			var name  	 = $("#name").val();
			var url 	 = $("#url").val();
			var parentid = $("#parentid").combo('getValue');
			var isshow 	 = $("#isshow").combo('getValue');
			var menuid   = $("#menuid").val();
			$.post("../controller/main.php?controller=CaidanController&methodName=addMenu",{
				"name"		:name,
				"url"		:url,
				"parentid"	:parentid,
				"isshow"	:isshow,
				"menuid"     :menuid
			},function(data){
				if(data == "ok"){
					refres(1,10);
					$('#win').window('close');
				}else if(data == "okk"){
					refres(1,10);
					
					$('#win').window('close');
				}
				  // close a window  
			},"text");
		}
		</script>
    </head>
    <body>
        <table id="dg"></table>
    	<div id="win" class="easyui-window" title="My Window" style="width:600px;height:400px ;margin-top: 200px;"   
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
            		<tr>
        				<td align="right"><label for="parentid">父级菜单:</label></td>
        				<td><input id="parentid" name="parentid"  value="请选择父级菜单"></td>
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
            				<a id="btn" href="javascript:upMenu();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">增加</a>
            			</td>
            		</tr>
            	</table>   
            </form>
        </div>
    </body>
</html>
