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
			  <td>用户昵称：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $this->adminInfos['nickname'];?>" placeholder="请填写用户昵称" id="nickname_b" name="nickname_b"></td>
		  </tr>
			<tr class="text-c">
			  <td>手机号：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $this->adminInfos['mobile'];?>" placeholder="请填写会员注册的手机号" id="mobile_b" name="mobile_b" disabled></td>
		  </tr>
          <tr class="text-c">
			  <td width="164">账户余额：</td>
			  <td width="760" align="left" valign="middle">
              <input type="text" class="input-text" value="<?php echo $this->adminInfos['money'];?>" placeholder="请填写用户账户畅言豆余额，必须为整数，大于0" id="money_b" name="money_b">
              </td>
		  </tr>
          <tr>
			  <td width="164" style="text-align:center;">当前头像：</td>
			  <td width="760" align="left" valign="middle" style="text-align:left;">
              <input type="hidden" id="tupian" name="tupian" value="<?php echo $this->adminInfos['avatar'];?>">
              <img src="<?php echo base_url().$this->adminInfos['avatar'];?>" style="width:100px;height:100px" id="avatars">
              </td>
		  </tr>
          <tr>
			  <td width="164" style="text-align:center;">头像更新：</td>
			  <td width="760" align="left" valign="middle" style="text-align:left;">
              <form id="recsons" name="recsons" action="<?php echo masters_url();?>members/avatar_upload" method="post" enctype="multipart/form-data" class="definewidth m20" target="upload_target1">
              <input type="button" value="选择文件"  class="btn btn-default btn-uploadstar radius" onClick="c_imgs();">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span style="display:none;" id="file_inner"><input type="file" id="files" name="files" value="" onChange="uploads();"></span>
                </form>
              </td>
		  </tr>
			<tr class="text-c">
			  <td width="164">登录密码：</td>
			  <td width="760" align="left" valign="middle">
              <input type="password" class="input-text" value="" placeholder="请填写登录密码，长度为6-16个字节" id="passwd_b" name="passwd_b">
              </td>
		  </tr>
          <tr>
			  <td width="164"></td>
			  <td width="760" align="left" valign="middle" style="text-align:left;">
              <font color="#FF0000">密码不修改则不用填写</font>
              </td>
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

			var tupian=$("#tupian").val().replace(/(^\s*)|(\s*$)/g,"");
			var money_b=$("#money_b").val().replace(/(^\s*)|(\s*$)/g,"");
			var nickname_b=$("#nickname_b").val().replace(/(^\s*)|(\s*$)/g,"");
			var mobile_b=$("#mobile_b").val().replace(/(^\s*)|(\s*$)/g,"");
			var passwd_b=$("#passwd_b").val().replace(/(^\s*)|(\s*$)/g,"");
			var mobile_check=/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/;	
			
			if(s_group_value==2 && nickname_b=='')
			{
				layer.msg('请填写会员昵称！');		
			}
			else if(s_group_value==2 && nickname_b.length>15)
			{
				layer.msg('会员昵称字数太长了！');		
			}
			else if(s_group_value==2 && mobile_b=='')
			{
				layer.msg('请填写会员手机号！');		
			}
			else if(s_group_value==2 && !mobile_check.test(mobile_b))
			{
				layer.msg('会员手机号填写有误！');		
			}
			else if(money_b=='')
			{
				layer.msg('请填写会员余额！');		
			}
			else if(isNaN(money_b))
			{
				layer.msg('会员余额必须为数字类型！');		
			}
			else if(s_group_value==2 && passwd_b!='' && (passwd_b.length<6 || passwd_b.length>16))
			{
				layer.msg('会员登录密码长度为6-16位之间！');		
			}
			else
			{
				layer.closeAll();
			
				form_loads=2;	
				$.ajax({url:"<?php echo masters_url();?>members/updates", 
				type: 'POST', 
				data:{money:money_b,nickname_b:nickname_b,mobile_b:mobile_b,passwd_b:passwd_b,avatar:tupian}, 
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

								setTimeout("location='<?php echo $_SERVER['REQUEST_URI'];?>'",1500);	
	

								
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