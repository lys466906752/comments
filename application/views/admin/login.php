<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<title>军颐评论系统管理系统</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap.css" />
 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/layer_pc/layer.js"></script>
<style type="text/css">
body{ background:#000  no-repeat center 0px;}
.tit{ margin:auto; margin-top:140px; text-align:center; width:350px; padding-bottom:20px;}
.login-wrap{ width:220px; padding:30px 50px 0 330px; height:260px; background:#fff url(<?php echo base_url();?>assets/admin/img/20150212154319.jpg) no-repeat 30px 40px; margin:auto; overflow: hidden;}
.login_input{ display:block;width:210px;}
.login_input1{ display:block;width:120px;}
.login_user{ background: url(<?php echo base_url();?>assets/admin/img/input_icon_1.png) no-repeat 200px center; font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif}
.login_password{ background: url(<?php echo base_url();?>assets/admin/img/input_icon_2.png) no-repeat 200px center; font-family:"Courier New", Courier, monospace}
.login_captcha{background: url(<?php echo base_url();?>assets/admin/img/input_icon_3.png) no-repeat 200px center; font-family:"Courier New", Courier, monospace}
.btn-login{ background:#40454B; box-shadow:none; text-shadow:none; color:#fff; border:none;height:35px; line-height:26px; font-size:14px; font-family:"microsoft yahei";}
.btn-login:hover{ background:#333; color:#fff;}
.copyright{ margin:auto; margin-top:40px; text-align:center; width:370px; color:#CCC}
@media (max-height: 700px) {.tit{ margin:auto; margin-top:100px; }}
@media (max-height: 500px) {.tit{ margin:auto; margin-top:50px; }}
</style>
<script>
	var form_load=0;
	function login_sub()
	{
		var username=$("#username").val().replace(/(^\s*)|(\s*$)/g,"");
		var password=$("#password").val().replace(/(^\s*)|(\s*$)/g,"");
		var captcha=$('#captcha').val().replace(/(^\s*)|(\s*$)/g,"");
		var pc_csrf=$('#pc_csrf').val().replace(/(^\s*)|(\s*$)/g,"");
		//alert(1);
		if(form_load==0)
		{
			if(pc_csrf=='')
			{
				layer.msg('抱歉：系统错误，请刷新页面重试！');
			}
			else if(username=="")
			{
				layer.tips('抱歉：请您输入登录账号!','#username');
			}
			else if(password=="")
			{
				layer.tips('抱歉：请您输入登录密码!','#password');	
			}
			else if(password.length<6 || password.length>16)
			{
				layer.tips('抱歉：您输入的登录密码不正确!','#password');	
			}
			else if(captcha=='')
			{
				layer.tips('抱歉：请输入登录验证码!','#captcha');	
			}
			else if(captcha.length!=4)
			{
				layer.tips('抱歉：登录验证码不正确!','#captcha');	
			}
			else
			{
				//ajax sends
				var sub_url=$('#login_form').attr('action');
				$.ajax({url:sub_url, 
				type: 'POST', 
				data:{username:username,passwd:password,captcha:captcha,pc_csrf:pc_csrf}, 
				dataType: 'html', 
				timeout: 15000, 
					error:function(){
						layer.closeAll();
						form_load=0;
						layer.msg("登录过程出现错误，请您稍后再试！");					
					},
					beforeSend:function(){
						form_load=1;
						var index = layer.load(1, {
						  shade: [0.5,'#333'] //0.1透明度的白色背景
						});
				
					},
					success:function(result){
						layer.closeAll();
						form_load=0;
						result=result.replace(/(^\s*)|(\s*$)/g,"");
						if(result.indexOf('|')>=0)
						{
							var arr=result.split('|');
							if(arr[0]==100)
							{
								layer.msg('登录成功');
								if(arr[1]==1)
								{
									//跳转主站后台	
									setTimeout('location="<?php echo admin_url();?>home/index"',1400);
								}
								else
								{
									//跳转到管理模块后台
									setTimeout('location="<?php echo masters_url();?>home/index"',1400);	
								}
								
							}	
							else
							{
								layer.msg(arr[1]);		
							}
						}
						else
						{
							layer.msg('登录过程出现错误，请您稍后再试！');	
						}
					} 
				});
			}
		}
		else
		{
				
		}
		
		return false;		
	}
	
	function changeCaptcha()
	{
		document.getElementById('captcha_img').src='<?php echo http_url();?>safes/admincaptcha?rands=' + Date.parse(new Date());
	}
</script>
</head>

<body>
<div class="tit"><img src="<?php echo base_url();?>assets/admin/img/tit.png" alt="" /></div>
<div class="login-wrap">
<form action="<?php echo admin_url();?>login/subs" onsubmit="return login_sub();" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm" method="post">
    <input type="hidden" id="pc_csrf" name="pc_csrf" value="<?php echo get_csrfToken($this->encrypt,$this->session);?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="25" valign="bottom">账  号：</td>
        </tr>
        <tr>
        <td><input type="text" class="login_input login_user" id="username" name="username" value="" /></td>
        </tr>
        <tr>
        <td height="35" valign="bottom">密  码：</td>
        </tr>
        <tr>
        <td><input type="password" id="password" name="password" class="login_input login_password" value="" /></td>
        </tr>
        <tr>
        <td height="30" valign="bottom">验 证 码：</td>
        </tr>
        <tr>
        <td><input type="text" id="captcha" name="captcha" class="login_input1 login_captcha" value="" /> <a href="javascript:changeCaptcha();"><img src='<?php echo http_url();?>safes/admincaptcha' style="border:#e4e4e4 1px dotted" id="captcha_img"></a></td>
        </tr>
        <tr>
        <td height="60" valign="bottom"><input type="submit" value="登录" style="display:none;" /><a href="javascript:void();" onclick="return login_sub();" class="btn btn-block btn-login">登录</a></td>
        </tr>
    
    </table>
</form>
</div>
<div class="copyright">建议使用IE8以上版本或谷歌浏览器</div>
</body>
</html>
