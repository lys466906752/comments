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

	
	function c_imgs()
	{
		$("#files").click();
	}
	
	var form_loads=1;
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
		if(result.indexOf("|")>0){
			arr=result.split("|");
			if(arr[0]==100){
				layer.msg('添加成功');
				setTimeout("location='<?php echo admin_url();?>yins/index?keywords=<?php echo $keywords;?>&pageindex=<?php echo $pageindex;?>'",1500);
			}else if(arr[0]==200){
				layer.msg('登录状态已失效');		
				setTimeout("location='<?php echo admin_url();?>login/indexs'",1500);			
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
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff; display:none;"></iframe>
<form id="recsons" name="recsons" action="<?php echo admin_url();?>yins/index_insert" method="post" enctype="multipart/form-data" class="definewidth m20" target="upload_target1">
<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
			
			<tr class="text-c" >
			  <td width="177">表情名称：</td>
			  <td width="826" align="left" valign="middle">
              <input type="text" class="input-text" value="" placeholder="请填写表情名称，10个字以内" id="name" name="name">
              </td>
		  </tr>

          <tr >
              <td align="center" valign="middle" style=" text-align:center;">所需金额：</td>
              <td align="left" valign="middle">
               <input type="text" class="input-text" value="" placeholder="必须填写整形数字" id="award" name="award" style="ime-mode:disabled">
              </td>
          </tr>
          <tr >
			  <td align="center" valign="middle" style=" text-align:center;">对应图片：</td>
			  <td align="left" valign="middle">
                <input type="file" id="files" name="files" value="">
                
              </td>
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
			var award=$("#award").val().replace(/(^\s*)|(\s*$)/g,"");
			
			if(name=="")
			{
				layer.msg('请填写印章名称！');			
			}
			else if(name.length>10)
			{
				layer.msg('印章名称必须少于10字');	
			}
			else if(award=='')
			{
				layer.msg('请填写印章对应的金额！');		
			}
			else if(isNaN(award))
			{
				layer.msg('印章对应金额格式不正确，仅允许填写整形！');		
			}
			else
			{
				layer.closeAll();
				var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
				form_loads=2;	
				document.recsons.submit();	
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