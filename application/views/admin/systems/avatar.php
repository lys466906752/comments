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
<script type="text/javascript" src="/assets/admins/lib/jquery/1.9.1/jquery.min.js"></script> 
<script>
	function c_imgs1()
	{
		$("#files1").click();
	}
	

	
	function reads()
	{
		$.ajax({url:"<?php echo admin_url();?>systems/avatar_ajax", 
			type: 'POST', 
			dataType: 'html', 
			timeout: 15000, 
			error: function(){
				layer.closeAll();
				reads();
			},
			beforeSend:function(){
				var index = layer.load(3,{
					shade: [0.2,'#333333'] //0.1透明度的白色背景
				});									
			},
			success:function(result){
				layer.closeAll();
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				//alert(result);
				document.getElementById("tupians").innerHTML=result;
			}
		});			
	}	
	
	var form_status=0;
	function del(pic)
	{
		if(form_status==0 || form_status==3){
			$.ajax({url:"<?php echo admin_url();?>systems/avatar_del", 
			type: 'POST', 
			data:{pic:pic},
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_status=3;	
					layer.alert('处理失败，请您稍后再试！', {
						icon: 7,
						skin: 'layer-ext-moon'
					})			
				},
				beforeSend:function(){
					layer.closeAll();
					var index = layer.load(3,{
						shade: [0.2,'#333333'] //0.1透明度的白色背景
					});
					form_status=1;	
				},
				success:function(result){
					form_status=3;
					layer.closeAll();
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							reads();
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
		}else{
			layer.alert('还有其他进程正在进行中，请您稍后再试！', {
				icon: 7,
				skin: 'layer-ext-moon'
			})					
		}			
	}
	
	$(document).ready(function(){

		reads();
	});
	
	var form_loads=1;
	function uploads1()
	{
		//var forms="recsons" + id;
		//alert(forms);
		if(form_loads==1)
		{
			layer.closeAll();
			var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
			form_loads=2;	
			//alert(1);
			document.recsons.submit();
			
		}
		else
		{
			layer.msg('抱歉：尚有数据正在处理中...');	
		}
	}
	
	function stopUpload(result){
		layer.closeAll();
		form_loads=1;	

		document.getElementById("file_inner1").innerHTML='<input type="file" id="files1" name="files" value="" onchange="uploads1();">';
		
		if(result.indexOf("|")>0){
			arr=result.split("|");
			if(arr[0]==100){
				layer.msg('上传成功');
				reads();
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
<style>
.tupians{width:100%; float:left; text-align:center;}
.tupians .items{width:auto; height:auto; padding-bottom:10px; display:inline-block; padding-top:10px; margin-right:10px;}
.tupians .items img{width:60px; height:60px;}
.tupians .items a{color:#666; text-decoration:none;}
.tupians .items a:hover{color:#cc0000; text-decoration:underline;}
</style>

<iframe id="rs1" name="rs1" src="#" style="width:0;height:0;border:0px solid #fff; display:none;"></iframe>
<form id="recsons" name="recsons" action="<?php echo admin_url();?>systems/avatar_uploads" method="post" enctype="multipart/form-data" class="definewidth m20" target="rs1">
<span style="display:none;" id="file_inner1">
<input type="file" id="files1" name="files" value="" onchange="uploads1();">
</span>
<article class="page-container">
	<div class="form form-horizontal" id="form-article-add" action="#">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<tbody>
			
			<tr >
			  <td width="1003" height="40" style="text-align:center;">
              
              	<div class="tupians" id="tupians">
                	
                    
                </div>
                
              </td>
		  </tr>
			<tr class="text-c" >
			  <td align="center" valign="middle">
              
              
              
        		
                
              	<input type="button" value=" 点击选择图片文件并上传... "  class="btn btn-default btn-uploadstar radius" onclick="c_imgs1();">
                
    

              
              
              </td>
		  </tr>
 
		</tbody>
	</table>   	
  </div>
  
</article>
</form>
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
<body>
</body>
</html>