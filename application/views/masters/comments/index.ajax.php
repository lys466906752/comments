<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:del_all();" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 删除所选评论信息 </a> &nbsp;&nbsp;<a href="javaScript:clearTable();" class="btn btn-primary radius"> 清空数据 </a></span> <span class="r">共有数据：<strong><?php echo $pageall;?></strong> 条</span> 
</div>

	<div class="mt-20">
    
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
			  <th width="23"><input type="checkbox" name="sx" id="sx" value="100" onClick="choose_all();" ></th>
			  <th width="42">ID</th>
				<th width="81">昵称</th>
				<th width="52">星级</th>
				<th width="229">内容</th>
				<th width="50">点赞</th>
				<th width="47">图片</th>
				<th width="105">添加时间</th>
                <th width="105">IP地址</th>
			  <th width="42">操作</th>
          </tr>
		</thead>
		<tbody>
        	<?php
            	foreach($query->result_array() as $array)
				{
			?>
            <span id="jc_<?php echo $array['id'];?>" style="display:none;padding:10px 10px 10px 10px;">
      			<div style="width:400px; float:left; padding-top:10px; padding-bottom:10px; padding-right:10px; padding-left:10px;">
                
				</div>
            </span>
			<tr id="zo_<?php echo $array["id"];?>" class="text-c" >
			  <td><input type="checkbox" name="cid" id="cid" value="<?php echo $array["id"];?>"></td>
			  <td><?php echo $array["id"];?></td>
				<td>

					<?php echo $array["nickname"];?>

                </td>
				<td><?php echo $array["star"];?></td>
				<td><?php echo $array["fulltext"];?></td>
				<td><?php echo $array['ok'];?></td>
				<td><?php echo substr_count($array["files"],"img")>0?'是':'<span style="color:#ccc;">否</span>';?></td>
				<td><?php echo $array["time"]=='' || $array["time"]==0?'':date('Y-m-d H:i:s',$array["time"]);?></td>
                <td><?php echo $array["ip"]=='' || $array["ip"]==0?'':$array["ip"];?></td>
				<td class="f-14 td-manage"><a style="text-decoration:none" class="ml-5" onClick="members_edit('<?php echo $array["id"];?>')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> </td>
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

