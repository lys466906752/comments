<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/assets/admins/lib/html5.js"></script>
<script type="text/javascript" src="/assets/admins/lib/respond.min.js"></script>
<script type="text/javascript" src="/assets/admins/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/assets/admins/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/admins/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/assets/admins/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/assets/admins/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/assets/admins/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/assets/admins/static/h-ui.admin/css/style.css" />
<script type="text/javascript" src="/assets/admins/lib/jquery/1.9.1/jquery.min.js"></script> 
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->
<script>

	var form_loads=1;

	function c_imgs()
	{
		$("#files").click();
	}
	
	function uploads()
	{
		if(form_loads==1)
		{
			layer.closeAll();
			var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
			form_loads=2;	
			document.recsons.submit();	
		}
		else
		{
			layer.msg('抱歉：还有进程数据正在处理中，请稍等...');
		}
	}
	
	function stopUpload(result){
		layer.closeAll();
		form_loads=1;	
		//$("#sub_avatar").val("");	
		document.getElementById("file_inner").innerHTML='<input type="file" id="files" name="files" value="" onChange="uploads();">';
		if(result.indexOf("|")>0){
			arr=result.split("|");
			if(arr[0]==100){
				$("#show_a").show();
				layer.msg('上传成功');
				$("#tupian").val(arr[1]);
				document.getElementById("avatars").src='<?php echo base_url();?>' + arr[1];

							
			}else if(arr[0]==200){
				layer.msg('登录状态已失效');		
				setTimeout("location='<?php echo http_url();?>admin/login/indexs'",1500);			
			}else if(arr[0]==300){	
				layer.msg(arr[1]);				
			}
		}else{
			form_loads=1;	
			layer.msg('操作过程出错，请您稍后再试！');					
		}	
	}
	$(document).ready(function(){

		
		change_tmp();
	});		
	function change_tmp()
	{
		var temp=$('#temp').val();
		var arr=temp.split('_');
		$('#tmp_div').css('background',arr[1]);	
	}
</script>
<title>采集配置</title>

</head>
<body>
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>

<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
			<tr class="text-c">
			  <td>站点名称：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['name'];?>" placeholder="请填写站点名称" id="name" name="name"></td>
		  </tr>
			<tr class="text-c">
			  <td>所属模板：</td>
			  <td align="left" valign="middle">
              <select class="input-text" id="temp" name="temp" onChange="change_tmp();">
              	<?php
					$arr=json_decode($result['template'],true);
                	foreach($tmp->result_array() as $tmps)
					{
				?>
              	<option value="<?php echo $tmps['id'];?>_<?php echo $tmps['color'];?>" <?php if($arr['id']==$tmps['id']){?> selected<?php }?>><?php echo $tmps['name'];?></option>
                <?php
					}
				?>
              </select>
              </td>
		  </tr>
                    <tr class="text-c">
			  <td>模板预览：</td>
			  <td align="left" valign="middle">
              	<div style="width:150px;height:30px;" id="tmp_div"></div>
           </td>
		  </tr> 
			<tr class="text-c">
			  <td>站点网址：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['url'];?>" placeholder="请填写站点网址" id="url" name="url"></td>
		  </tr>
          <tr class="text-c">
			  <td width="164">参与人数：</td>
			  <td width="760" align="left" valign="middle">
              <input type="text" class="input-text" value="<?php echo $result['join'];?>" placeholder="请填写参与人数" id="join" name="join">
              </td>
		  </tr>
			<tr class="text-c">
			  <td>评论总数：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['counts'];?>" placeholder="请填写评论总数" id="counts" name="counts"></td>
		  </tr>
			<tr class="text-c">
			  <td>好评：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['best'];?>" placeholder="请填写好评总数" id="best" name="best"></td>
		  </tr>
			<tr class="text-c">
			  <td>中评：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['medium'];?>" placeholder="请填写中评总数" id="medium" name="medium"></td>
		  </tr>
			<tr class="text-c">
			  <td>差评：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['negative'];?>" placeholder="请填写差评总数" id="negative" name="negative"></td>
		  </tr>
          </span>
			<tr class="text-c" >
			  <td colspan="2" align="center" valign="middle">
              
              <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 点 击 修 改 更 新    </button>
              </td>
		  </tr>
 
		</tbody>
	</table>   	
	</div>
  
</article>

<script>
	
	var form_loads=1;
	
	function article_save_submit()
	{
		
		if(form_loads==1)
		{
			
		
			var s_group_value=2;
		
			var name=$("#name").val().replace(/(^\s*)|(\s*$)/g,"");
			var url=$("#url").val().replace(/(^\s*)|(\s*$)/g,"");
			var joins=$("#join").val().replace(/(^\s*)|(\s*$)/g,"");
			var counts=$("#counts").val().replace(/(^\s*)|(\s*$)/g,"");
			var best=$("#best").val().replace(/(^\s*)|(\s*$)/g,"");
			var medium=$("#medium").val().replace(/(^\s*)|(\s*$)/g,"");
			var negative=$("#negative").val().replace(/(^\s*)|(\s*$)/g,"");
			var temp=$("#temp").val().replace(/(^\s*)|(\s*$)/g,"");
				
			
			if(name=='')
			{
				layer.msg('请填写站点名称！');		
			}
			else if(url=='')
			{
				layer.msg('请填写网址！');		
			}
			else if(joins=='' || isNaN(joins))
			{
				layer.msg('请填写正确参与人数！');		
			}
			else if(counts=='' || isNaN(counts))
			{
				layer.msg('请填写正确的评论总条数！');		
			}
			else if(best=='' || isNaN(best))
			{
				layer.msg('请填写正确的好评数！');		
			}
			else if(medium=='' || isNaN(medium))
			{
				layer.msg('请填写正确的中评数！');		
			}
			else if(negative=='' || isNaN(negative))
			{
				layer.msg('请填写正确的差评数！');		
			}
			else
			{
				layer.closeAll();
			
				form_loads=2;	
				$.ajax({url:"<?php echo masters_url();?>sites/updates/<?php echo $result['id'];?>", 
				type: 'POST', 
				data:{name:name,url:url,joins:joins,counts:counts,best:best,medium:medium,negative:negative,temp:temp}, 
				dataType: 'html', 
				timeout: 15000, 
					error: function(){
						layer.closeAll();
						form_loads=1;
						layer.alert('抱歉：程序更新过程中出错，请您稍后再试！', {
							icon: 2,
							skin: 'layer-ext-moon'
						})
					},
					beforeSend:function(){
						var index = layer.load(3,{
							shade: [0.2,'#333333'] //0.1透明度的白色背景
						});	
						form_loads=2;								
					},
					success:function(result){
						layer.closeAll();
						form_loads=1;
						result=result.replace(/(^\s*)|(\s*$)/g,"");
						if(result.indexOf("|")>0){
							arr=result.split("|");
							if(arr[0]==100){
								
								layer.alert(arr[1], {
									icon: 1,
									skin: 'layer-ext-moon'
								})		
								
								setTimeout("location='<?php echo masters_url();?>sites/index?keywords=<?php echo $keywords;?>&pageindex=<?php echo $pageindex;?>'",1500);	

								
							}else if(arr[0]==200){
								layer.alert('登录状态已失效，请重新登录！', {
									icon: 2,
									skin: 'layer-ext-moon'
								})			
								setTimeout("location='<?php echo admin_url();?>login/indexs'",1500);			
							}else if(arr[0]==300){
								layer.alert(arr[1], {
									icon: 2,
									skin: 'layer-ext-moon'
								})						
							}
						}else{
							layer.alert('操作过程出错，请您稍后再试！', {
								icon: 2,
								skin: 'layer-ext-moon'
							})					
						}						
					} 
				});	
			}
		}
		else
		{
			//第三方扩展皮肤
			layer.alert('尚有其他数据正在处理中，请稍等', {
			  icon: 7,
			  skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
			})			
		}
	}
</script>

<!--_footer 作为公共模版分离出去-->

<script type="text/javascript" src="/assets/admins/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/jquery.validation/1.14.0/messages_zh.min.js"></script> 
<script type="text/javascript" src="/assets/admins/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/assets/admins/static/h-ui.admin/js/H-ui.admin.js"></script> 
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/assets/admins/lib/My97DatePicker/WdatePicker.js"></script>  
<script type="text/javascript" src="/assets/admins/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/ueditor/1.4.3/ueditor.config.js"></script> 
<script type="text/javascript" src="/assets/admins/lib/ueditor/1.4.3/ueditor.all.min.js"> </script> 
<script type="text/javascript" src="/assets/admins/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>

<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>