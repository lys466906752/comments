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

	function delete_tupian(id,url)
	{
		$("#tupians_" + id).remove();		
	}
	
	var form_loads=1;

	function c_imgs()
	{
		var int=0;
		$(".tupianInner p").each(function(){
			int=parseInt(int)+1;
		});
		if(int>=5)
		{
			layer.msg("抱歉：最多允许上传5张配图");	
		}
		else
		{
			$("#files").click();	
		}
		
	}
	
	function uploads()
	{
		var int=0;
		$(".tupianInner p").each(function(){
			int=parseInt(int)+1;
		});
		if(form_loads==1)
		{
			if(int>=5)
			{
				layer.msg("抱歉：最多允许上传5张配图");	
			}
			else{
				layer.closeAll();
				var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
				form_loads=2;	
				document.recsons.submit();
			}
		}
		else
		{
			layer.msg('抱歉：还有进程数据正在处理中，请稍等...');
		}
	}
	
	var maxInt=1000;
	function stopUpload(result){
		layer.closeAll();
		form_loads=1;	
		//$("#sub_avatar").val("");	
		document.getElementById("file_inner").innerHTML='<input type="file" id="files" name="files" value="" onChange="uploads();">';
		if(result.indexOf("|")>0){
			arr=result.split("|");
			if(arr[0]==100){
				layer.msg('上传成功');
				maxInt=parseInt(maxInt)+1;
				
				if(arr[2]==1)
				{
					var tupianInner=$(".tupianInner").html();
					$(".tupianInner").html(tupianInner + '<div class="tupianItem" id="tupians_' + maxInt + '"><p><img src="/' + arr[1] + '"><br><a href=javascript:delete_tupian(' + maxInt + ',"' + arr[1] + '")>删除</a><input type="hidden" class="tupians" value="' + arr[1] + '"></p>');
					
				}
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
	
	function add_one()
	{
		var shuiyin=$("#shuiyin").val();
		if(shuiyin=='')
		{
			layer.msg('请选择一个印章'); 
		}
		else
		{
			files=shuiyin;
			maxInt=parseInt(maxInt)+1;
			var yinzhangInner=$(".yinzhangInner").html();
			$(".yinzhangInner").html(yinzhangInner + '<div class="yinzhangItem" id="yinzhangs_' + maxInt + '"><p><img src="/' + files + '"><br><a href=javascript:delete_yinzhang(' + maxInt + ',"' + files + '")>删除</a><input type="hidden" class="tupians" value="' + files + '"></p>');
		}
	}
	
	
	function delete_yinzhang(id)
	{
		$("#yinzhangs_" + id).remove();	
	}
</script> 
             
<style>
.tupianInner{float:left;width:100%; height:auto;}
.tupianInner .tupianItem{width:70px; float:left; height:auto; padding-right:10px;}
.tupianInner .tupianItem img{width:70px;float:left;height:70px; margin-bottom:10px;}

.yinzhangInner{float:left;width:100%; height:auto;}
.yinzhangInner .yinzhangItem{width:70px; float:left; height:auto; padding-right:10px;}
.yinzhangInner .yinzhangItem img{width:70px;float:left;height:70px; margin-bottom:10px;}
</style>  
<title>采集配置</title>

</head>
<body>
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
<iframe id="upload_target2" name="upload_target2" src="#" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
        <tr class="text-c">
			  <td>回复人用户ID：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['uid'];?>" placeholder="请填写回复人用户ID" id="uid" name="uid"></td>
		  </tr>
			<tr class="text-c">
			  <td>回复人用户昵称：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['uname'];?>" placeholder="请填写回复人用户昵称" id="uname" name="uname"></td>
		  </tr>
          <tr class="text-c">
			  <td>被回复人用户ID：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['rid'];?>" placeholder="被回复人用户ID" id="rid" name="rid"></td>
		  </tr>
			<tr class="text-c">
			  <td>被回复人用户昵称：</td>
			  <td align="left" valign="middle"><input type="text" class="input-text" value="<?php echo $result['rname'];?>" placeholder="被回复人用户昵称" id="rname" name="rname"></td>
		  </tr>
			
          <tr class="text-c">
			  <td width="164">内容：</td>
			  <td width="760" align="left" valign="middle"><textarea name="fulltext" class="input-text" id="fulltext" placeholder="请填写评论内容" style="height:80px;"><?php echo $result['fulltext'];?></textarea>
              </td>
		  </tr>
			
			
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
		
			var uid=$("#uid").val().replace(/(^\s*)|(\s*$)/g,"");
			var uname=$("#uname").val().replace(/(^\s*)|(\s*$)/g,"");
			var fulltext=$("#fulltext").val().replace(/(^\s*)|(\s*$)/g,"");
			var rid=$("#rid").val().replace(/(^\s*)|(\s*$)/g,"");
			var rname=$("#rname").val().replace(/(^\s*)|(\s*$)/g,"");
			
			if(uid=='')
			{
				layer.msg('回复人信息不能为空！');		
			}
			else if(uname=='')
			{
				layer.msg('回复人信息不能为空！');		
			}
			else if(fulltext=='')
			{
				layer.msg('请认证填写回复内容！');		
			}
			else
			{
				layer.closeAll();
			
				form_loads=2;	
				$.ajax({url:"<?php echo masters_url();?>comments/res_updates/<?php echo $result['id'];?>/<?php echo $siteid;?>", 
				type: 'POST', 
				data:{uid:uid,uname:uname,fulltext:fulltext,rname:rname,rid:rid}, 
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
								
								setTimeout("location='<?php echo masters_url();?>comments/res?keywords=<?php echo $keywords;?>&pageindex=<?php echo $pageindex;?>&reId=<?php echo $reId;?>'",1500);	

								
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