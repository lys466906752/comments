<?php
	$arr=explode('@',$config['avatarInit']);
	foreach($arr as $k=>$v)
	{
?>
<div class="items" id="tupian_<?php echo $k+1;?>">
	<img src="<?php echo base_url().$v;?>"><p><a href="javascript:del('<?php echo $v;?>');">删除</a></p>
</div>
<?php
	}
?>