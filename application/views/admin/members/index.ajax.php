<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:del_all();" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 删除所选会员</a> &nbsp;&nbsp; <a href="<?php echo admin_url();?>members/add?keywords=<?php echo $keywords;?>&pageindex=<?php echo $pageindex;?>" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加会员</a></span> <span class="r">共有数据：<strong><?php echo $pageall;?></strong> 条</span> 
</div>

	<div class="mt-20">

	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
			  <th width="25"><input type="checkbox" name="sx" id="sx" value="100" onClick="choose_all();" ></th>
			  <th width="52">ID</th>
			  <th width="79">发言</th>
				<th width="83">昵称</th>
				<th width="99">手机号</th>
				<th width="99">头像</th>
				<th width="99">余额</th>
				<th width="93">最后登录IP</th>
				<th width="105">最后登录时间</th>
			  <th width="99">操作</th>
          </tr>
		</thead>
		<tbody>
        	<?php
            	foreach($query->result_array() as $array)
				{
			?>
			<tr id="zo_<?php echo $array["id"];?>" class="text-c" >
			  <td><input type="checkbox" name="cid" id="cid" value="<?php echo $array["id"];?>"></td>
			  <td><?php echo $array["id"];?></td>
			  <td><?php echo $array["state"]==1?"<strong style='color:green;'>是</strong>":"<strong style='color:red;'>否</strong>";?></td>
				<td>

					<?php echo $array["nickname"];?>

                </td>
				<td>
				<?php 
					if($array["mobile"]!='')
					{
						echo $array["mobile"];	
					}
					else
					{
						if($array["qqId"]!='')
						{
							echo 'QQ用户';	
						}	
						elseif($array["sinaId"]!='')
						{
							echo '新浪微博用户';	
						}
						else
						{
							echo '批量生成用户';	
						}
					}
				
				?>
                </td>
				<td><img src="<?php echo base_url().$array["avatar"];?>" style="width:50px;height:50px;"></td>
				<td><?php echo $array["money"];?></td>
				<td><?php echo $array["login_ip"];?></td>
				<td class="f-14 td-manage"><?php echo $array["login_time"]=='' || $array["login_time"]==0?'':date('Y-m-d H:i:s',$array["login_time"]);?></td>
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
            if($i!=$pageindex)
			
			{
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

