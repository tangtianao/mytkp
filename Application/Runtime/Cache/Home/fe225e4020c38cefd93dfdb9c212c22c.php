<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>菜单管理</title>
    </head>
    <body>
        
          <table width="800px";cellspacing="0" border="1">
	          <tr>
	         	 <td>编号</td>
	         	 <td>菜单名字</td>
	         	 <td>菜单url</td>
	         	 <td>父级菜单</td>
	         	 <td>是否显示</td>
	          </tr>
	         <!--  <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$msg" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 3 );++$i; if(($mod) == "0"): ?><tr style="background-color: gray">
			         	  <td><?php echo ($menu["menuid"]); ?></td>
			         	  <td><?php echo ($menu["name"]); ?></td>
			         	  <td><?php echo ($menu["url"]); ?></td>
			         	  <td><?php echo ($menu["parentid"]); ?></td>
			         	  <td>
			         	 	<?php if($data.$i["isshow"] == 1): ?>显示
			         	 	<?php else: ?>
			         	 	不显示<?php endif; ?>
				          </td>
		              </tr><?php endif; endforeach; endif; else: echo "$msg" ;endif; ?> -->
          	 <?php if(is_array($data)): foreach($data as $i=>$menu): if(($i%3) == "1"): ?><tr style="background-color: red">
			         	 <td><?php echo ($menu["menuid"]); ?></td>
			         	 <td><?php echo ($menu["name"]); ?></td>
			         	 <td><?php echo ($menu["url"]); ?></td>
			         	 <td><?php echo ($menu["parentid"]); ?></td>
			         	 <td>
			         	 	<?php if($menu["isshow"] == 1): ?>显示
			         	 	<?php else: ?>
			         	 	不显示<?php endif; ?>
				          </td>
			         </tr><?php endif; endforeach; endif; ?>
	          	<!--  <?php $__FOR_START_24717__=$da-1;$__FOR_END_24717__=0;for($i=$__FOR_START_24717__;$i > $__FOR_END_24717__;$i+=-1){ if(($i%3) == "2"): ?><tr style="background-color: blue;">
			         	 <td><?php echo ($data["$i"]["menuid"]); ?></td>
			         	 <td><?php echo ($data["$i"]["name"]); ?></td>
			         	 <td><?php echo ($data["$i"]["url"]); ?></td>
			         	 <td><?php echo ($data["$i"]["parentid"]); ?></td>
			         	 <td>
			         	 	<?php if($data.$i["isshow"] == 2): ?>显示
			         	 	<?php else: ?>
			         	 	不显示<?php endif; ?>
			         	 </td>
			          	</tr><?php endif; } ?> -->
          </table>
          <?php if($j == 1): ?>这个是等于1
          <?php elseif($j == 2): ?>
          	这个等于2
           <?php elseif($j == 3): ?>
       		   这个等于3
          <?php elseif($j == 4): ?>
		          这个等于4
          <?php else: ?>
    		      这个是什么都不等于<?php endif; ?>
          
    </body>
</html>