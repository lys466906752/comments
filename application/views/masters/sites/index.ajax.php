<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:del_all();" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 删除所选站点</a> &nbsp;&nbsp;<a href="<?php echo masters_url();?>sites/add?keywords=<?php echo $keywords;?>&pageindex=<?php echo $pageindex;?>" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加站点</a></span> <span class="r">共有数据：<strong><?php echo $pageall;?></strong> 条</span> 
</div>

	<div class="mt-20">
    
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
			  <th width="23"><input type="checkbox" name="sx" id="sx" value="100" onClick="choose_all();" ></th>
			  <th width="42">ID</th>
				<th width="62">名称</th>
				<th width="188">网址</th>
				<th width="65">appKey</th>
				<th width="53">模板</th>
				<th width="53">模板颜色</th>
				<th width="53">参与人数</th>
				<th width="57">发布总数</th>
				<th width="38">好评</th>
				<th width="41">中评</th>
				<th width="39">差评</th>
				<th width="116">添加时间</th>
			  <th width="77">操作</th>
          </tr>
		</thead>
		<tbody>
        	<?php
            	foreach($query->result_array() as $array)
				{
			?>
            <span id="jc_<?php echo $array['id'];?>" style="display:none;padding:10px 10px 10px 10px;">
      			<div style="width:400px; float:left; padding-top:10px; padding-bottom:10px; padding-right:10px; padding-left:10px;">
                <?php
                	$contents='<script src="'.http_url().'comments/index/'.$array['id'].'/'.$array['appkey'].'"></script>';
					echo htmlspecialchars($contents);
					echo "<br>";
					$contents='<script>';
					echo htmlspecialchars($contents);
					echo "<br>";
					$contents='		document.write(result);';
					echo htmlspecialchars($contents);
					echo "<br>";
					$contents='</script>';
					echo htmlspecialchars($contents);
				?>
				</div>
            </span>
			<tr id="zo_<?php echo $array["id"];?>" class="text-c" >
			  <td><input type="checkbox" name="cid" id="cid" value="<?php echo $array["id"];?>"></td>
			  <td><?php echo $array["id"];?></td>
				<td>

					<?php echo $array["name"];?>

                </td>
				<td><?php echo $array["url"];?></td>
				<td><?php echo $array["appkey"];?></td>
				<td><?php $arr=json_decode($array["template"],true);echo $arr['name'];?></td>
				<td><div style="width:40px;height:25px; background:<?php echo $arr['color'];?>"></div></td>
				<td><?php echo $array["join"];?></td>
				<td><?php echo $array['counts'];?></td>
				<td><?php echo $array["best"];?></td>
				<td><?php echo $array["medium"];?></td>
				<td><?php echo $array["negative"];?></td>
				<td><?php echo $array["time"]=='' || $array["time"]==0?'':date('Y-m-d H:i:s',$array["time"]);?></td>
				<td class="f-14 td-manage"><a style="text-decoration:none" class="ml-5" onClick="members_edit('<?php echo $array["id"];?>')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> &nbsp;&nbsp; <a href="javascript:jicheng('<?php echo $array['id'];?>');">集成</a> </td>
            </tr>
            <?php
            	}
			?>
		</tbody>
	</table>
    
 
    
</div>
    
    <?php
    	 if($pagecount>1){
	?>
    <div style="width:100%;padding-top:15px;">
    	<div style="width:40%; float:left; height:30px; line-height:30px;">显示 <?php echo $pageindex;?> / <?php echo $pagecount;?> 页 &nbsp;&nbsp;&nbsp;  <input type="text" id="pagenum" name="pagenum" value="<?php echo $pageindex;?>" style="text-align:center; width:40px; height:18px; line-height:18px; border:#999999 1px solid;" > &nbsp; 页 &nbsp; <input type="button" value="跳转" style="text-align:center; width:40px; height:20px; line-height:20px; border:#999999 1px solid;" onClick="page_gos();"> &nbsp;&nbsp;&nbsp; 共 <strong><?php echo $pageall;?></strong> 条数据</div>
        
        <div style="width:60%; float:right; text-align:right;" class="pages">
		<?php
           if($pageindex>1){
        ?>
        <a href="javascript:show_pages(1)">首页</a> <a href="javascript:show_pages('<?php echo $pageindex-1;?>')">上一页</a> 
        <?php
            }
        ?>
        <?php
            for($i=$arrs[0];$i<=$arrs[1];$i++){
        ?>
        <?php
            if($i!=$pageindex){
        ?>
        <a href="javascript:show_pages('<?php echo $i;?>')"><?php echo $i;?></a>
        <?php
            }else{
        ?>
        <span><?php echo $i;?></span>
        <?php
            }
        ?>
        <?php
            }
        ?>      
        <?php
            if($pageindex<$pagecount){
        ?>                                         
        <a href="javascript:show_pages('<?php echo $pageindex+1;?>')">下一页</a> <a href="javascript:show_pages('<?php echo $pagecount;?>')">末页</a>
        <?php
            }
        ?>
        </div>
    </div>
    <?php
    	}
	?>

