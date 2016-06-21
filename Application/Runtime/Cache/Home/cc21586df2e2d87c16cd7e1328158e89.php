<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>菜单分配</title>
		<script type="text/javascript" src="http://localhost:8080/mytyk/Public/css/jquery-1.7.1.js"></script>
		<script type="text/javascript">
		$(function(){

			var b = true;
			$("#a1").click(function(){
				if(b){
					$("input").prop("checked",true);
					$("#a1").text("全不选");
					b = false;
				}else{
					$("input").prop("checked",false);
					$("#a1").text("全选");
					b = true;
				}	
			});
			
 
			$("#a2").click(function(){
				$("input").each(function(){
					this.checked = !this.checked;
				});	
			});	
			
			
		});
		
		</script>
			
	</head>
	<body>
		
		<a href="javascript:void(0)" id="a1"style="text-decoration: none;color: black;" >全选</a>
		<span id="a2" style="cursor: pointer;">反选</span>
		<br />
		<form action="../controller/main.php" method="post">
			<input type="hidden" name ="rid" value ="<?php echo $rid; ?>">
    		<input type="hidden" name ="controller" value="AllocationController">
    		<input type="hidden" name ="methodName" value="amendEuserRloe"> 
    	
            <input type="submit" value="确定提交">
		</form>
	</body>
</html>