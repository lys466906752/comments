<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/PIE_IE678.js"></script>
<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admins/static/h-ui.admin/css/style.css" />
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/layer_pc/layer.js"></script>

<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 任务设置 <span class="c-gray en">&gt;</span> 任务列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
    <span id="inners">
	<div class="mt-20">
    
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
			  <th width="52">ID</th>
				<th width="81">任务名称</th>
				<th width="99">奖励数量</th>
			  <th width="99">操作</th>
          </tr>
		</thead>
		<tbody>
        	<?php
            	foreach($query->result_array() as $array)
				{
			?>
			<tr id="zo_<?php echo $array["id"];?>" class="text-c" >
			  <td><?php echo $array["id"];?></td>
				<td>

					<?php echo $array["title"];?>

                </td>
				<td><?php echo $array["award"];?></td>
				<td class="f-14 td-manage"><a style="text-decoration:none" class="ml-5" href="<?php echo admin_url();?>awards/edit/<?php echo $array["id"];?>" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> </td>
            </tr>
            <?php
            	}
			?>
		</tbody>
	</table>
    
    
    
</div>	
    </span>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/laypage/1.2/laypage.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/admins/static/h-ui.admin/js/H-ui.admin.js"></script> 
<style>
.pages a{background-color: #FFFFFF;border: 1px solid #c53357;color: #c53357;display:inline-block;font-size: 12px;height: 26px;line-height:26px;margin: 0px 3px 0px 0px;padding-left: 8px;padding-right:8px; margin-right:12px; width:auto;}
.pages a:hover{margin-right:12px; text-decoration:underline;}
.pages span{background-color: #f4f4f4;border: 1px solid #ccc;color: #999;display:inline-block;font-size: 12px;height: 26px;line-height: 26px;margin: 0px 3px 0px 0px;padding-left: 10px;padding-right: 10px;margin-right:12px;font-weight:bold;}
</style>
</body>
</html>