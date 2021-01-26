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

	function showShow()
	{
		var s_group = document.getElementsByName("addType");
		var s_group_value="";
		for(var i = 0; i< s_group.length; i++){
			if(s_group[i].checked==true){
				s_group_value=s_group[i].value;
			}
		}
		if(s_group_value==1)
		{
			$("#show_a").show();
			$("#show_b1").hide();
			$("#show_b2").hide();
			$("#show_b3").hide();	
		}
		else if(s_group_value==2)
		{
			$("#show_a").hide();
			$("#show_b1").show();
			$("#show_b2").show();
			$("#show_b3").show();	
		}			
	}
	$(document).ready(function(){

		showShow();
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
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff; display:none;"></iframe>
<form id="recsons" name="recsons" action="<?php echo admin_url();?>faces/index_insert" method="post" enctype="multipart/form-data" class="definewidth m20" target="upload_target1">
<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
			<tr class="text-c">
			  <td width="164">站点名称：</td>
			  <td width="760" align="left" valign="middle"><input type="text" class="input-text" value="" placeholder="请填写站点的名称" id="name" name="name"></td>
		  </tr>
			<tr class="text-c">
			  <td>所属模板：</td>
			  <td align="left" valign="middle">
              <select class="input-text" id="temp" name="temp" onChange="change_tmp();">
              	<?php
                	foreach($tmp->result_array() as $tmps)
					{
				?>
              	<option value="<?php echo $tmps['id'];?>_<?php echo $tmps['color'];?>"><?php echo $tmps['name'];?></option>
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
			  <td align="left" valign="middle"><input type="text" class="input-text" value="" placeholder="请填写网址，需要带上http://或者https://" id="url" name="url"></td>
		  </tr>
			<tr class="text-c" >
			  <td colspan="2" align="center" valign="middle">
              
              <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 点 击 添 加   </button>
              </td>
		  </tr>
 
		</tbody>
	</table>   	
	</div>
  
</article>
</form>
<script>
	
	var form_loads=1;
	
	function article_save_submit()
	{
		
		if(form_loads==1)
		{
			
			var name=$("#name").val().replace(/(^\s*)|(\s*$)/g,"");
			var url=$("#url").val().replace(/(^\s*)|(\s*$)/g,"");
			var temp=$("#temp").val().replace(/(^\s*)|(\s*$)/g,"");
			
			
			if(name=="")
			{
				layer.msg('请填写站点名称！');			
			}
			else if(temp=='')
			{
				layer.msg('请至少选择一个对应模板');	
			}
			else if(url=='')
			{
				layer.msg('请填写站点网址');	
			}
			else if(url.indexOf("http://")<0 && url.indexOf("https://")<0)
			{
				layer.msg('站点网址必须要带上http或者https！');		
			}
			else
			{
				layer.closeAll();
			
				form_loads=2;	
				$.ajax({url:"<?php echo masters_url();?>sites/inserts", 
				type: 'POST', 
				data:{name:name,url:url,temp:temp}, 
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
								form_state=1;
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