<!DOCTYPE html assets "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
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
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->
<script>
	function show_iports()
	{
		var daili=$("#daili").val();
		if(daili==1)
		{
			$("#ports").hide();		
		}	
		else
		{
			$("#ports").show();	
		}
	}
	
	function choose_lists(id)
	{
		var s_group = document.getElementsByName("pc_item_" + id);
		for(var i = 0; i< s_group.length; i++){
			s_group[i].checked=true;
		}	
	}
</script>
<title>采集配置</title>

</head>
<body>
<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
			
			<tr >
			  <td width="177" height="40" style="text-align:center;">验证码发送两次间隔时间：</td>
			  <td width="826" height="40" align="left" valign="middle" style="text-align:left;">
              <input type="text" class="input-text" value="<?php echo $config["captchaMax"];?>" placeholder="验证码发送两次间隔时间,必须为整形" id="captchaMax" name="captchaMax">
              </td>
		  </tr>
          <tr >
             <td height="40">&nbsp;</td>
             <td height="40" align="left" valign="middle" style="text-align:left;">&nbsp;<font color="#FF0000">发送验证码需要等待的时间，可以防止验证码被一直调用发送</font></td>
          </tr>
           <tr class="text-c" >
		     <td height="40">用户默认昵称配置：</td>
			  <td height="40" align="left" valign="middle">
              <input type="text" class="input-text" value="<?php echo $config["nicknameInit"];?>" placeholder="每个会员昵称用@符号隔开" id="nicknameInit" name="nicknameInit">
             </td>
		  </tr>
          <tr >
             <td height="40">&nbsp;</td>
             <td height="40" align="left" valign="middle" style="text-align:left;">&nbsp;<font color="#FF0000">每个昵称中间用@符号分割开来，用户注册时会随机从其中抽取一个出来</font></td>
          </tr>
          <tr class="text-c" >
		     <td height="40">会员最大消息保存条数：</td>
			  <td height="40" align="left" valign="middle">
              <input type="text" class="input-text" value="<?php echo $config["maxMsgCountSave"];?>" placeholder="会员最大消息保存条数" id="maxMsgCountSave" name="maxMsgCountSave">
             </td>
		  </tr>
          <tr >
             <td height="40">&nbsp;</td>
             <td height="40" align="left" valign="middle" style="text-align:left;">&nbsp;<font color="#FF0000">服务器上仅会保存最近的多少条信息，建议填写300以内</font></td>
          </tr>
			<tr class="text-c" >
			  <td colspan="2" align="center" valign="middle">
              
              <button onclick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 更 新 配 置 信 息  </button>
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
		
			
			var captchaMax=$("#captchaMax").val().replace(/(^\s*)|(\s*$)/g,"");
			var nicknameInit=$("#nicknameInit").val().replace(/(^\s*)|(\s*$)/g,"");
			var maxMsgCountSave=$("#maxMsgCountSave").val().replace(/(^\s*)|(\s*$)/g,"");
			
			if(captchaMax=="")
			{
				layer.msg('请填写验证码发送间隔时间！');			
			}
			else if(isNaN(captchaMax))
			{
				layer.msg('验证码间隔时间不正确');	
			}
			else if(nicknameInit=='')
			{
				layer.msg('请填写默认昵称');	
			}
			else if(maxMsgCountSave=='')
			{
				layer.msg('请填写会员消息保存数量');	
			}
			else if(isNaN(maxMsgCountSave))
			{
				layer.msg('消息保存数量不正确');	
			}
			else
			{
				$.ajax({url:"<?php echo admin_url();?>systems/index_update", 
				type: 'POST', 
				data:{captchaMax:captchaMax,nicknameInit:nicknameInit,maxMsgCountSave:maxMsgCountSave}, 
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
	
							}else if(arr[0]==200){
								layer.alert('登录状态已失效，请重新登录！', {
									icon: 2,
									skin: 'layer-ext-moon'
								})			
								setTimeout("location='<?php echo admin_url();?>login/index'",1500);			
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
<script type="text/javascript" src="/assets/admins/lib/jquery/1.9.1/jquery.min.js"></script> 
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
<body>
</body>
</html>