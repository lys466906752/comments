<html lang="en-US" manifest=""><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Expires" content="-1">
<title>评论系统首页</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="<?php echo base_url();?>assets/css/show.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/layer/layer.js"></script>
<!--<script src="<?php echo base_url();?>assets/layui/layui.all.js"></script>-->

<script>
	layer.msg("hello");
	
	var textarea_bg="<?php echo base_url();?>assets/images/input_bg.png";
	var timeMax=<?php echo select_config('site','captchaMax');?>;
	
	function clear_input_index()
	{
		var values=$("#csrf_input_index").val();	
		if(values=="有事没事说两句...")
		{
			$("#csrf_input_index").val("");	
			$("#csrf_input_index").css("background-image","url()");
			$("#csrf_input_index").css("color","#333");
		}
	}


	function rev_input_index()
	{
		var values=$("#csrf_input_index").val();	
		if(values=="有事没事说两句..." || values=="")
		{
			$("#csrf_input_index").val("有事没事说两句...");
			$("#csrf_input_index").css("background","url(" + textarea_bg + ") center no-repeat");
			$("#csrf_input_index").css("color","#999");	
		}	
	}
	
	var hc_comments_show_id=4;
	function choose_star(id)
	{
		for(var i=1;i<=5;i++)
		{
			if(i<=id)
			{
				$("#hc_star_" + i).html("<img src=<?php echo base_url();?>assets/images/grade02.png onClick=choose_star(" + i + ") onMouseOut=rev_star_bg()>");	
			}
			else
			{
				$("#hc_star_" + i).html("<img src=<?php echo base_url();?>assets/images/grade01.png onClick=choose_star(" + i + ") onMouseMove=change_star_bg(" + i + ") onMouseOut=rev_star_bg()>");		
			}	
		}	
		hc_comments_show_id=id;
	}
	
	function change_star_bg(id)
	{
		for(var i=1;i<=5;i++)
		{
			if(i<=id)
			{
				$("#hc_star_" + i).html("<img src=<?php echo base_url();?>assets/images/grade02.png onClick=choose_star(" + i + ")  onMouseOut=rev_star_bg()>");	
			}
			else
			{
				$("#hc_star_" + i).html("<img src=<?php echo base_url();?>assets/images/grade01.png onClick=choose_star(" + i + ");  onMouseMove=change_star_bg(" + i + ") onMouseOut=rev_star_bg()>");		
			}	
		}
	}
	
	function rev_star_bg()
	{
		choose_star(hc_comments_show_id);	
	}
	
	function hc_comments_sub()
	{
		$(".hc_form_inner").hide();
		var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
		if(comments_csrf=="" || comments_csrf=="有事没事说两句...")
		{
			$(".hc_form_inner").show();
			$(".hc_form_inner").html("请随便说两句呗！");
		}
	}
	

	function hc_login_show()
	{
		show_box();	
	}

	var hc_box='';
	function show_box()
	{
		var web_height=document.body.clientHeight;
		var web_width1=screen.width;
		var web_height1=document.documentElement.clientHeight;
		var web_width=document.documentElement.clientWidth;
		
		document.getElementById("hc_comments_bg").style.height=web_height + "px";
		document.getElementById("hc_comments_bg").style.width=web_width + "px";	
		if(document.getElementById("hc_comments_bg").style.display!="block")
		{
			$("#hc_comments_bg").show(400);
		}		

		if(document.getElementById("hc_comments_box").style.display!="block")
		{
			$("#hc_comments_box").show();
		}

		var div_h=document.getElementById("hc_comments_box").offsetHeight;
		var div_w=document.getElementById("hc_comments_box").offsetWidth;
	
		document.getElementById("hc_comments_box").style.left=(web_width-div_w)/2 + "px";
		document.getElementById("hc_comments_box").style.top=parseInt((web_height-div_h))/2 + "px";
		
		document.body.style.overflow="hidden";
		
		hc_box=setTimeout("show_box()",100);			
	}
	
	function close_hc_login_box()
	{
		$("#hc_comments_box").hide();
		$("#hc_comments_bg").hide();
		$(".hc_member_nav").hide();
		document.body.style.overflow="auto";
		clearTimeout(hc_box);	
	}
	
	var login_state=1;
	var captcha_state=1;
	function comments_get_passwd()
	{
		if(captcha_state==1)
		{
			$("#comments_login_error").hide();
			var comments_login_mobile=$("#comments_login_mobile").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_mobile_check=/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/;	
			if(comments_csrf=="")
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("您可能长时间未操作页面，请刷新重试！");	
			}
			else if(comments_login_mobile=="")
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("请填写您的手机号！");	
			}
			else if(!comments_mobile_check.test(comments_login_mobile))
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("您填写的手机号不正确！");		
			}
			else
			{
				captcha_state=2;
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/captcha",  
					dataType:"jsonp",  
					data:{  
					   "comments_login_mobile":comments_login_mobile,
					   "comments_csrf":comments_csrf
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						captcha_state=1;
						if(data.code==100)
						{
							timeDestroy();
						}
						else if(data.code==300)
						{
							$("#comments_login_error").show();
							$("#comments_login_error").html(data.show);	
						}
						else
						{
							$("#comments_login_error").show();
							$("#comments_login_error").html("服务器数据读取失败，请稍后再试！");	
						}
					},  
					error:function(){ 
						captcha_state=1; 
						$("#comments_login_error").show();
						$("#comments_login_error").html("服务器数据读取失败，请稍后再试！");
					}	
				});			
			}
		}
		else
		{
			$("#comments_login_error").show();
			$("#comments_login_error").html("正在发送中，请稍等...");		
		}

	}
	
	var timeWhileSet;
	var timeClock=0;
	function timeDestroy()
	{
		timeClock=parseInt(timeMax)+1;	
		timeDestroyTimeout();
	}
	
	function timeDestroyTimeout()
	{
		timeClock=timeClock-1;
		if(timeClock<=0)
		{
			$(".get_passwds").html('<a href="javascript:comments_get_passwd();">获取新密码</a>');
			clearTimeout(timeWhileSet);
		}	
		else
		{
			$(".get_passwds").html('<a>' + timeClock + '秒后获取</a>');
			timeWhileSet=setTimeout("timeDestroyTimeout()",1000);	
		}
	}
	
	function comments_login()
	{
		if(login_state==1)
		{

			var comments_login_mobile=$("#comments_login_mobile").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_login_passwd=$("#comments_login_passwd").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_mobile_check=/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/;
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_login_passwd=$("#comments_login_passwd").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
			if(comments_csrf=="")
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("您可能长时间未操作页面，请刷新重试！");	
			}
			else if(comments_login_mobile=="")
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("请填写您的手机号！");	
			}
			else if(!comments_mobile_check.test(comments_login_mobile))
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("您填写的手机号不正确！");		
			}
			else if(comments_login_passwd=="")
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("请填写您的登录密码！");		
			}
			else if(comments_login_passwd.length<6 || comments_login_passwd.length>18)
			{
				$("#comments_login_error").show();
				$("#comments_login_error").html("您的登录密码不正确！");		
			}
			else
			{
				var index = layer.load(1, {
				  shade: [0.1,'#fff']
				});
				login_state=2;
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/login",  
					dataType:"jsonp",  
					data:{  
					   "comments_login_mobile":comments_login_mobile,
					   "comments_login_passwd":comments_login_passwd,
					   "comments_csrf":comments_csrf,
					   "comments_sid":comments_sid
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						layer.closeAll();
						login_state=1;
						if(data.code==100)
						{
							$("#comments_login_mobile").val("");
							$("#comments_login_passwd").val("");
							close_hc_login_box();
							member_info=1;
							comments_member_info_read();
						}
						else if(data.code==300)
						{
							$("#comments_login_error").show();
							$("#comments_login_error").html(data.show);	
						}
						else
						{
							$("#comments_login_error").show();
							$("#comments_login_error").html("服务器数据读取失败，请稍后再试！");	
						}
					},  
					error:function(){ 
						layer.closeAll();
						login_state=1; 
						$("#comments_login_error").show();
						$("#comments_login_error").html("服务器数据读取失败，请稍后再试！");
					}	
				});			
			}
		}
		else
		{
			$("#comments_login_error").show();
			$("#comments_login_error").html("正在登录中，请稍等...");		
		}
	}
	
	var member_info=1;
	function comments_member_info_read()
	{
		if(member_info==1)
		{
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
			if(comments_csrf=="")
			{
				alert("系统配置有误，请联系管理员解决");	
			}
			else
			{
				member_info=2;
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/infos",  
					dataType:"jsonp",  
					data:{  
					   "comments_csrf":comments_csrf,
					   "comments_sid":comments_sid
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						member_info=1;
						if(data.code==100)
						{
							members_info=data.show;
							
							$(".hs_forms_login").hide();
							$(".hs_forms_login_nickname").show();
							$(".hs_forms_login_avatar").show();
							$(".hs_forms_login_nickname").html(data.show.nickname);
							$(".hs_forms_login_avatar").html('<img src="<?php echo base_url();?>' + data.show.avatar + '">');							
						}
						else
						{
							$(".hs_forms_login").show();
							$(".hs_forms_login_nickname").hide();
							$(".hs_forms_login_avatar").hide();	
						}
					},  
					error:function(){ 
						member_info=1; 
						
					}	
				});		
			}
		}	
	}
	
	$(document).ready(function() {
		comments_member_info_read();
		$(".plugins_avatar").mouseover(
			function(){
				$(".avatar_fly").show();
			}
		);
		$(".plugins_avatar").mouseleave(
			function(){
				$(".avatar_fly").hide();
			}
		);
		$(".hc_changyandou").mouseover(
			function(){
				$("#ch_doudou_text").show();
			}
		);
		$(".hc_changyandou").mouseleave(
			function(){
				$("#ch_doudou_text").hide();
			}
		);
		
	});	
	
	function hc_login_state_show()
	{
		show_box1();
		$(".hc_member_nav").show();
		ch_show_my();
	}

	function show_box1()
	{
		var web_height=document.body.clientHeight;
		var web_width1=screen.width;
		var web_height1=document.documentElement.clientHeight;
		var web_width=document.documentElement.clientWidth;
		
		document.getElementById("hc_comments_bg").style.height=web_height + "px";
		document.getElementById("hc_comments_bg").style.width=web_width + "px";	
		document.body.style.overflow="hidden";
		if(document.getElementById("hc_comments_bg").style.display!="block")
		{
			$("#hc_comments_bg").show(400);
		}
		
		hc_box=setTimeout("show_box1()",100);			
	}
	var members_info="";
	
	function ch_show_my()
	{
		$(".comments_my_inner").show();
		$(".comments_task_inner").hide();
		$(".comments_msg_inner").hide();
	
		document.getElementById("member_avatars").src="<?php echo base_url();?>" + members_info.avatar;
		$("#member_nickname").html(members_info.nickname);
		$("#ch_money").html(members_info.money);
		$("#ch_comments_count").html(members_info.commentCount);
		comments_member_info_read();
	}
	
	function ch_comments_logout()
	{
		var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
		var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
		$.ajax({  
			url : "<?php echo base_url();?>index.php/members/logout",  
			dataType:"jsonp",  
			data:{  
			   "comments_csrf":comments_csrf,
			   "comments_sid":comments_sid
			},  
			type:"GET",  
			jsonp:"jsonpcallback",  
			timeout: 6000,  
			success:function(data){
				member_info=1;
				if(data.code==100)
				{
					comments_member_info_read();
					close_hc_login_box();											
				}
			},  
			error:function(){ 
				layer.msg("退出会员系统失败，请您稍后再试！");
			}	
		});			
	}
	
	function show_edit_nickname()
	{
		$(".plugins_nickname").hide();	
		$(".plugins_nickname1").show();
		$("#hc_edit_nickname").val(members_info.nickname);
	}
	
	function sub_edit_nickname()
	{
		var nickname=$("#hc_edit_nickname").val().replace(/(^\s*)|(\s*$)/g,"");	
		var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
		if(comments_csrf=="")
		{
			layer.msg("您可能长时间没有操作页面，请刷新重试！");
		}
		else if(nickname=="")
		{
			layer.msg("请填写您的新昵称！");
		}
		else if(nickname.length>5)
		{
			layer.msg("新昵称长度请控制在5个字以内！");	
		}
		else
		{
			var index = layer.load(1, {
			  shade: [0.1,'#fff']
			});
			login_state=2;
			$.ajax({  
				url : "<?php echo base_url();?>index.php/members/nickname",  
				dataType:"jsonp",  
				data:{  
				   "nickname":nickname,
				   "comments_csrf":comments_csrf
				},  
				type:"GET",  
				jsonp:"jsonpcallback",  
				timeout: 6000,  
				success:function(data){
					layer.closeAll();
					if(data.code==100)
					{
						layer.msg(data.show);
						$(".plugins_nickname").show();	
						$(".plugins_nickname1").hide();
						members_info.nickname=nickname;
						$("#member_nickname").html(members_info.nickname);
						$(".hs_forms_login_nickname").html(members_info.nickname);
					}
					else if(data.code==300)
					{
						layer.msg(data.show);
					}
					else
					{
						layer.msg("系统错误，请稍后再试！");
					}
				},  
				error:function(){
					layer.closeAll();
					layer.msg("系统错误，请稍后再试！");
				}	
			});			
		}

	}
</script>
</head>

<style>
.hs_comments{
	margin:0,0,0,0;padding:0,0,0,0;margin-left: 0px;margin-right: 0px;width:100%;margin:0 auto;height:500px; max-width:1200px;font-size:14px;
}
.hs_comments div{font-size:14px;}
.hs_comments .input textarea{resize:none;width:98%;float:left; margin-left:1%; margin-right:1%; height:100px; border:none; outline:none;color:#999;background:url(<?php echo base_url();?>assets/images/input_bg.png) center no-repeat;}
hs_comments div,td,th,textarea,input {
	font-family: "微软雅黑";font-size:14px;
}
.hs_comments ul{padding:0; margin:0;}
.hs_comments li{padding:0; margin:0; list-style:none;}
.hs_comments .star li{ float:left; text-align:right; padding-right:5px; cursor:pointer;}
.hs_comments .comments_submit{width:auto;float:right; padding-top:10px;}
.hs_comments .comments_submit a{width:102px; height:30px; background:url(<?php echo base_url();?>assets/images/post-btn.png) no-repeat; display:inline-block;}
.hs_comments .comments_submit a:hover{width:102px; height:30px; background:url(<?php echo base_url();?>assets/images/post-btn-hover.png) no-repeat; display:inline-block;}

.hs_box{width:100%; float:left; height:auto;}
.hs_forms{width:100%; float:left; height:40px;}
.hs_forms_login{width:40px; height:40px; border-radius:50%; text-align:center;border:#5fbf5e 1px solid;font-size:16px; line-height:40px;color:#5fbf5e; margin-left:12px; position:absolute;z-index:4; margin-top:3px; background:#FFF; cursor:pointer;}
.hs_forms_login_avatar{width:40px; height:40px; text-align:center;font-size:16px; line-height:40px;color:#5fbf5e; margin-left:12px; position:absolute;z-index:4; margin-top:3px; background:#FFF; cursor:pointer; display:none;}
.hs_forms_login_avatar img{width:40px;height:40px;border-radius:50%;}

.hs_comments .input{width:100%;float:left;height:auto;border:#5fbf5e 1px solid;border-radius:8px; padding-top:18px; position:relative;z-index:1;background:#FFF;}

.hs_forms_face{width:30px; float:left; height:30px; padding-top:18px; padding-left:15px;}
.hs_forms_face a{width:18px;height:18px; background:url(<?php echo base_url();?>assets/images/face.png) no-repeat; display:inline-block;}
.hs_forms_face a:hover{width:18px;height:18px; background:url(<?php echo base_url();?>assets/images/face-active.png) no-repeat; display:inline-block;}
.hs_comments_star{width:auto; float:right; padding-top:18px; padding-right:5px;}
.hs_comments_star .star{width:auto; float:right; height:auto; padding-top:1px;}
.hs_comments_star .star_text {width:auto;float:right; padding-right:10px;}

.hs_comments_lists{width:100%; float: left; height: auto; padding-top: 25px;}
.hs_comments_lists .item_title{position:absolute;z-index:2;width: 70px; line-height: 30px; border:#5fbf5e 1px solid;border-top-right-radius: 8px; background: #fff; border-bottom: none;border-top-left-radius: 8px; text-align: center;color:#5fbf5e;font-size:16px;}
.hs_comments_lists .item_line{line-height: 30px;height: 30px;position: relative;overflow: hidden;border-bottom:#5fbf5e 1px solid; text-align: right;color:#5fbf5e;}
.hs_comments_start{width: 100%; float: left; height:auto; background: url(/assets/images/title-tag.png) 0px 20px no-repeat;}
.hs_comments_start .comments_alts{width:100px; float: left;padding-left:15px; text-align: left; line-height:55px;font-size:16px;font-weight:blod;color:#5fbf5e;}
.hs_box .listsview{width:100%; float:left; height:auto; border-bottom:#e4e4e4 1px dashed; padding-bottom:10px; padding-top:5px;}
.hs_lists_avatar{border-radius:50%;width:45px;height:45px;}
.pd15{padding-top:15px;}
.hs_comments_nickname{width:auto; float: left; height: 30px; line-height: 30px;color:#5fbf5e;font-size:12px;}
.hs_comments_star_show{width:auto;float: right;text-align:right;color:#999;font-size:10px;color:#999; line-height:30px;}
.comments_contents{width:100%; float: left;height:auto;line-height: 25px; padding-top:5px;}
.comments_button{width:100%; float:left; height:auto; text-align:right;}
.hc_form_inner{width:100%; float:left; text-align:center; height:35px; line-height:35px; color:#F00; display:none;}

#hc_comments_bg{position:fixed;background:#000000;filter:alpha(opacity=50);Opacity:0.5;width:2000px; height:1200px;left:0px;top:0px;z-index:910;display:none;}
#hc_comments_box{position:fixed;z-index:990;width:auto;height:auto;top:200px;left:200px;display:none;}

#comments_login_error{width:310px; float:left; text-align:center; padding-top:15px;color:#F00;font-size:13px; display:none;}

#hc_comments_box .login_form{width:310px;height:auto;float:left;background:#FFF;border-radius:10px; padding-bottom:30px;}
#hc_comments_box .login_form_close_btn{width:100%; float:left; text-align:right; line-height:40px;}
#hc_comments_box .login_form_close_btn a{margin-right:10px;font-size:24px;font-weight:bold; text-decoration:none;color:#999;}
#hc_comments_box .login_form_close_btn a:hover{margin-right:10px;font-size:24px;font-weight:bold; text-decoration:none;color:#333;}
#hc_comments_box .login_alts{width:100%; float:left; text-align:center; font-size:18px;color:#333;}
#hc_comments_box .login_alts_innner{width:100%; float:left; text-align:center; font-size:14px;color:#999; line-height:30px;}
#hc_comments_box .login_input{width:100%; float:left; text-align:center; padding-top:5px;}
#comments_login_mobile{outline:none; width:290px; line-height:35px; height:35px; border:#999 1px solid; border-radius:8px;  padding-left:10px;}
#hc_comments_box .login_input1{width:310px; float:left; text-align:center; padding-top:15px;}
#comments_login_passwd{outline:none; width:195px; line-height:35px; height:35px; border:#999 1px solid; border-radius:8px; padding-left:10px;margin-right:5px;}
.get_passwds a{width:85px;line-height:35px; height:35px; border:#999 1px solid; border-radius:8px; padding-left:2%; display:inline-block; text-decoration:none; text-align:center;color:#666;}
.get_passwds a:hover{width:85px;line-height:35px; height:35px; border:#38a3fd 1px solid; background:#38a3fd
;border-radius:8px; padding-left:2%; display:inline-block; text-decoration:none; text-align:center;color:#fff;}
.comments_login_btn{width:100%; float:left; text-align:center; padding-top:15px;font-size:16px;}
.comments_login_btn a{background:#38a3fd;border-radius:8px;display:inline-block; width:290px;height:35px; line-height:35px;color:#FFF; text-decoration:none;}
.comments_login_btn a:hover{background:#1859a5;border-radius:8px;display:inline-block; width:290px;height:35px; line-height:35px;color:#FFF; text-decoration:none;}
.comments_other_login{width:100%; float:left; text-align:center; padding-top:25px;}
.comments_other_login .qq a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -80px no-repeat;display:inline-block; margin-right:15px;}
.comments_other_login .qq a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -80px no-repeat;display:inline-block; margin-right:15px;}

.comments_other_login .sina a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -40px no-repeat;display:inline-block;margin-right:15px;}
.comments_other_login .sina a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -40px no-repeat;display:inline-block;margin-right:15px;}


.comments_other_login .phone a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -120px no-repeat;display:inline-block;}
.comments_other_login .phone a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -120px no-repeat;display:inline-block;}
.comments_login_history{width:100%; float:left; text-align:center; padding-top:15px;color:#999;font-size:12px;}

.hs_forms_login_down{width:45px;height:40px; border-radius:50%; background:#FFF; position:absolute;z-index:2;border:#5fbf5e 1px solid; margin-left:10px; margin-top:10px;}
.hs_forms_login_down_bg{width:70px;height:40px; background:#fff; position:absolute;z-index:3;margin-left:10px;}
.hs_forms_login_nickname{width:auto; height:40px; line-height:40px; text-align:center; background:#FFF; position:absolute;z-index:5; margin-left:70px; margin-top:20px; padding-left:10px; padding-right:10px;color:#5fbf5e; display:none;}
</style>
<body>
<div class="hs_comments">
	<div class="hs_box">

        <!--对应的回复文本框-->
        <div class="hs_forms">
        	<div class="hs_forms_login_avatar" onClick="hc_login_state_show();"></div>
            <div class="hs_forms_login_nickname"></div>
            <div class="hs_forms_login" onClick="hc_login_show();">登录</div>
            <div class="hs_forms_login_down"></div>
            <div class="hs_forms_login_down_bg"></div>
        </div>
        
        <div class="input">
            <textarea id="csrf_input_index" onFocus="clear_input_index();" onBlur="rev_input_index();">有事没事说两句...</textarea>
            <input type="hidden" id="comments_csrf" name="comments_csrf" value="<?php echo get_csrfToken($this->encrypt);?>" >
            <input type="hidden" id="comments_sid" name="comments_sid" value="<?php echo $comments_sid;?>">
        </div>
        
        <div class="hs_box">
        	<div class="hs_forms_face">
            	<a href=""></a>
            </div>
            <div class="comments_submit"><a href="javascript:hc_comments_sub();"></a></div>
            
            
            <div class="hs_comments_star">
            	
                <div class="star">
                	<ul>
                    	<li id="hc_star_1"><img src="<?php echo base_url();?>assets/images/grade02.png" onClick="choose_star(1);"></li>
                        <li id="hc_star_2"><img src="<?php echo base_url();?>assets/images/grade02.png" onClick="choose_star(2);"></li>
                        <li id="hc_star_3"><img src="<?php echo base_url();?>assets/images/grade02.png" onClick="choose_star(3);"></li>
                        <li id="hc_star_4"><img src="<?php echo base_url();?>assets/images/grade02.png" onClick="choose_star(4);"></li>
                        <li id="hc_star_5"><img src="<?php echo base_url();?>assets/images/grade01.png" onClick="choose_star(5);" onMouseMove="change_star_bg(5);" onMouseOut="rev_star_bg();"></li>
                    </ul>
                </div>
                <div class="star_text">评分</div>
            </div>
            
            
        </div> 
        <div class="hc_form_inner"></div>
    </div>
   
    <!--对应的回复信息-->
    <div class="hs_comments_lists">

            <div class="item_title"> 评 论 </div>

            <div class="item_line">
                
                <strong>41</strong> 人参与 ， <strong>41</strong> 条评论

            </div>

            <div class="hs_comments_start">
                    <div class="comments_alts">最新评论</div>
            </div>

            <div class="hs_box">
                <ul>
                    <?php
                        for($i=1;$i<=10;$i++)
                        {
                    ?>
                    <div class="listsview">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="55" height="108" rowspan="2" align="left" valign="top" class="pd15">
                                <img src="<?php echo base_url();?>assets/images/933601085_1514190827071_c55.jpg" class="hs_lists_avatar">
                            </td>
                            <td width="" height="30" align="left" valign="top">
                            <div class="hs_box">
                                    <div class="hs_comments_nickname">回首依然在</div>
                                    <div class="hs_comments_star_show"><img src="<?php echo base_url();?>assets/images/grade04.png"> <img src="<?php echo base_url();?>assets/images/grade04.png"> <img src="<?php echo base_url();?>assets/images/grade04.png"> <img src="<?php echo base_url();?>assets/images/grade04.png"> 2018年3月16日 14:57</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                            <div class="comments_contents">听病友介绍过这家医院，有点不太相信，和家人来实地考察了一圈，整体还可以，就挂了一个刘晓蕊主任的号，主任长得比较和蔼可亲，给我们认认真真的分析了半个多小时，有点小感动，去其他医院有的医生就三五分钟就看完完事儿了。只有有了对比，才能真正分出好坏，只有有了亲身经历，才知道什么是好医生。</div>
                            <div class="comments_button">
                            	
                                
                                
                                <div style="width:auto;float:right;padding-left:5px;padding-top:3px;">
                                <a href="" style="width:20px;height:20px; background:url(<?php echo base_url();?>assets/images/prop-ico.png) no-repeat; display:inline-block;"></a>
                                </div>
                                
                                <div style="width:auto;float:right;padding-left:5px; padding-right:15px;padding-top:5px;">
                                <a href="" style="width:16px;height:15px; background:url(<?php echo base_url();?>assets/images/cai.png) no-repeat; display:inline-block;"></a>
                                </div>
                                
                                <div style="width:auto;float:right;padding-left:5px; padding-right:15px; position:relative; padding-top:5px;">
                                <a href="" style="width:16px;height:20px; background:url(<?php echo base_url();?>assets/images/ding.png) no-repeat; display:inline-block;"></a>
                                </div>
                                
                                <div style="width:auto;float:right;padding-left:5px; padding-right:15px; padding-top:5px;">
                            		<a href="" style="font-size:12px; text-decoration:none;color:#666;">回复</a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php
                        }
                    ?>
                </ul>
            </div>

    </div>
</div>


<div id="hc_comments_bg" onClick="close_hc_login_box();"></div>
<div id="hc_comments_box">
	<div class="login_form">
    	<div class="login_form_close_btn">
        	<a href="javascript:close_hc_login_box();">×</a>
        </div>
        <div class="login_alts">
        	手机登录
        </div>
        <div class="login_alts_innner">
        	短信获取6位初始密码
        </div>
        <div class="login_input">
        	<input type="text"  placeholder="手机号" id="comments_login_mobile">
        </div>
        <div class="login_input1">
        	<table width="310" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td align="right"><span style="float:right;"><input type="password" placeholder="密码" id="comments_login_passwd"></span></td>
            <td align="left" width="100" class="get_passwds"><a href="javascript:comments_get_passwd();">获取新密码</a></td>
            </tr>
            </table>
        </div>

        <div id="comments_login_error">
        	请填写正确手机号码
        </div>
        <div class="comments_login_btn">
        	<a href="javascript:comments_login();"> 登 录 畅 言 </a>
        </div>
        <div class="comments_other_login">
        	<span class="qq">
        		<a href=""></a>
            </span>
            <span class="sina">
            	<a href=""></a>
            </span>
            <span class="phone">
            	<a href=""></a>
            </span>
        </div>
        <div class="comments_login_history">
        	登录过的用户请沿用之前的登录方式
        </div>
    </div>
</div>

<style>
.comments_login_my1 a{background:url(<?php echo base_url();?>assets/images/tab-list-icon-active1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_my a{background:url(<?php echo base_url();?>assets/images/tab-list-icon1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_my a:hover{background:url(<?php echo base_url();?>assets/images/tab-list-icon-active1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_task1 a{background:url(<?php echo base_url();?>assets/images/task-ico-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_task a{background:url(<?php echo base_url();?>assets/images/task-ico.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_task a:hover{background:url(<?php echo base_url();?>assets/images/task-ico-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}

.comments_login_msg1 a{background:url(<?php echo base_url();?>assets/images/set-icon-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_msg a{background:url(<?php echo base_url();?>assets/images/set-icon.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
.comments_login_msg a:hover{background:url(<?php echo base_url();?>assets/images/set-icon-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}

.hc_member_nav{width:310px; height:100%; position:fixed;z-index:997;right:0px; float:right;top:0; display:none;}
.hc_member_nav .close{width:30px; float:left; height:100%;font-size:30px;color:#FFF;}
.hc_member_nav .close a{color:#FFF; text-decoration:none;}

.comments_my_inner{float:left;width:236px; height:100%; background:#FFF; display:none;}
.comments_my_inner .box{width:100%; float:left; height:80px; text-align:center; padding-top:30px;}
.comments_my_inner .box .plugins_avatar{width:80px;height:80px; margin:0 auto;}
.comments_my_inner .box .avatar_fly{position:absolute;z-index:998; background:#000; height:80px; width:80px;color:#FFF; line-height:80px; border-radius:3px;filter:alpha(opacity=50);Opacity:0.5;cursor:pointer;display:none;}
.comments_my_inner .box .plugins_avatar img{width:80px; height:80px;border-radius:3px;}
.plugins_nickname{width:180px;height:auto; margin:0 auto; text-align:center; padding-top:10px;}
.plugins_nickname a{ background:url(/assets/images/edit.png) right no-repeat;width:auto; display:inline-block; padding-right:30px; height:30px; line-height:30px; text-align:center;color:#000;text-decoration:none;font-size:12px;}
.plugins_nickname1{width:180px;height:auto; margin:0 auto; text-align:center; padding-top:10px; display:none;}
.plugins_nickname1 input{width:100px;border:none;border-bottom:#CCC 1px solid; height:24px; line-height:24px; padding-left:5px; padding-right:5px; outline:none; text-align:center;}
.plugins_nickname1 a{background:url(/assets/images/edit.png) 0px 0px no-repeat;width:20px;height:20px; display:inline-block;}
.plugins_counts{width:100%; float:left; height:auto;font-size:14px; padding-top:15px; border-bottom:#CCC 1px dashed}
.plugins_counts .money{width:45%; float:left; padding-left:5%; text-align:left; line-height:40px;}
.plugins_counts .money strong{color:#F00;}
.plugins_counts .comments{width:45%; float:left; padding-right:5%; text-align:right; line-height:40px;}
.plugins_counts .comments strong{color:#1859a5;}
.plugins_logout{width:100%; float:left; height:auto;font-size:14px; padding-top:15px;}
.plugins_logout a{width:150px; text-align:center; line-height:35px; display:inline-block; text-decoration:none; background:#CCC; border-radius:5px;color:#999;}
.plugins_logout a:hover{width:150px; text-align:center; line-height:35px; display:inline-block; text-decoration:underline; background:#000; border-radius:5px;color:#fff;}

.comments_task_inner{float:left;width:236px; height:100%; background:#FFF;overflow:auto;overflow-x:hidden;display:none;}
.comments_task_inner .title{width:215px; float:left; padding-left:21px;font-size:20px; padding-top:20px;}
.comments_task_inner .mys{width:215px; float:left; height:auto; text-align:left; padding-top:20px; padding-left:21px;}
.comments_task_inner #ch_doudou_text{width:180px;position:absolute;z-index:997; height:auto; padding:5px 5px 5px 5px; background:#FFF;-moz-box-shadow:2px 2px 2px 1px #888888;box-shadow: 2px 2px 2px 1px #888888;font-size:14px; line-height:28px; text-align:left; margin-left:20px; margin-top:40px;border-radius:3px; display:none;}
.comments_task_inner .mys .hc_changyandou{width:auto;display:inline-block; height:30px; line-height:30px; border:#f1a624 2px dotted; background:#fffaf0; padding-left:10px; padding-right:10px; border-radius:5px;color:#ffa912;}

.hc_changyandou_sm{width:185px; float:left; margin-left:21px; padding-top:20px;}
.hc_changyandou_sm ul{padding:0; margin:0;}
.hc_changyandou_sm ul li{ float:left;width:100%; border-bottom:#e4e4e4 1px solid; list-style:none; line-height:60px;font-size:14px;}
.hc_changyandou_sm ul li span{padding-left:20px; display:inline-block;color:#38a3fd;}

.comments_msg_inner{float:left;width:236px; height:100%; background:#FFF;overflow:auto;overflow-x:hidden;display:none;}
.comments_msg_inner .title{width:215px; float:left; padding-left:21px;font-size:20px; padding-top:20px;}
.comments_msg_inner .msg{width:185px; float:left;font-size:20px; padding-top:20px;font-size:12px; border-bottom:#e4e4e4 1px dashed; padding-bottom:15px; margin-left:21px;}
.comments_msg_inner .msg a{color:#FFF;display:inline-block;width:auto; padding-left:5px; padding-right:5px; border-radius:10px; background:#F00; text-align:center; line-height:21px; text-decoration:none;}
.comments_msg_inner .bars{width:185px; float:left; margin-left:21px;font-size:20px; padding-top:20px;font-size:12px;border-bottom:#e4e4e4 1px dashed; padding-bottom:15px;}
.comments_msg_inner .bars a{display:inline-block;width:auto; padding-left:12px; padding-right:18px; background:#f00;color:#fff; display:inline-block; margin-left:5px;line-height:25px; text-decoration:none;border-radius:5px;}

.comments_msg_inner .msg_list{width:185px; float:left; margin-left:21px;font-size:20px; padding-top:5px;font-size:12px; padding-bottom:15px;}
.comments_msg_inner .msg_list ul{padding:0; margin:0;}
.comments_msg_inner .msg_list ul li{ list-style:none; float:left;border-bottom:#e4e4e4 1px dashed; padding-bottom:12px; padding-top:12px;}
.comments_msg_inner .msg_list ul li .a1{width:100%; float:left; height:auto;}
.comments_msg_inner .msg_list ul li .a2{width:28px; float:left; height:40px;}
.comments_msg_inner .msg_list ul li .a3{width:152px; float:left; height:auto;}
.comments_msg_inner .msg_list ul li .a4{width:152px; float:left; text-align:left;color:#666;}
.comments_msg_inner .msg_list ul li .a5{width:152px; float:left; text-align:left;line-height:25px;color:#999;}
.comments_msg_inner .msg_list ul li .a6{width:152px; float:left; height:auto;line-height:22px;color:#333; margin-bottom:10px;}
.comments_msg_inner .msg_list ul li .a7{width:144px; float:left; height:auto;line-height:22px;color:#999;border:#e4e4e4 1px dotted; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; border-radius:5px;}
.comments_msg_inner .msg_list ul li .a7 strong{color:#666;}
</style>
<div class="hc_member_nav">

	<div class="close"><a href="">×</a></div>
    
    <div style="width:44px; float:left; height:100%; background:#000;">
    	
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;">
          <tr>
          <td valign="top" style="padding-top:20px;">
          		<span class="comments_login_my1">
                <a href="javascript:ch_show_my();">我的</a>
                </span>
                <span class="comments_login_task">
                <a href="javascript:ch_show_task();">任务</a> 
                </span>
                <span class="comments_login_msg">
                <a href="javascript:ch_show_msg();">消息</a>    
                </span>
            </td>
          </tr>
          <tr>
            <td align="center" valign="bottom"  style="color:#FFF;padding-bottom:10px;color:#999;text-align:center;">军颐</td>
          </tr>
        </table>
    </div>
 
	<script>
        function ceshi()
        {
            var index = layer.load(1, {
              shade: [0.1,'#fff']
            });
        }

    </script>
    <div class="comments_my_inner">
    	<div class="box">
        	<div class="plugins_avatar">
            	<div class="avatar_fly">
                	修改头像
                </div>
        		<img id="member_avatars">
            </div>
            <div class="plugins_nickname">
            	<a href="javascript:show_edit_nickname();" id="member_nickname"></a>
            </div>
            <div class="plugins_nickname1">
            	<input type="text" id="hc_edit_nickname" > <a href="javascript:sub_edit_nickname();"></a>
            </div>
            <div class="plugins_counts">
            	<div class="money">
            		畅言豆：<strong id="ch_money"></strong> 个
                </div>
                <div class="comments">
                	评论：<strong id="ch_comments_count"></strong> 条
                </div>
            </div>
            
			<div class="plugins_logout">
            	<a href="javascript:ch_comments_logout();"> 退 出 登 录 </a>
            </div>
            
        </div>
    </div>

	<div class="comments_task_inner">
    	<div class="title">
        	任务奖励
        </div>
        <div class="mys">
        	<div id="ch_doudou_text">
            	畅言豆是军颐评论系统的通用虚拟货币。在评论中使用盖章道具将会消耗畅言豆。
            </div>
        
        	<a class="hc_changyandou">畅言豆 12</a>
        </div>
        <div class="hc_changyandou_sm">
        	<ul>
            <?php
            	foreach($awards->result_array() as $award)
				{
			?>
            	<li><?php echo $award['title'];?> <span><?php echo $award['award'];?>畅言</span></li>
            <?php
				}
			?>
            </ul>
        </div>

    </div>
    
    <div class="comments_msg_inner">
    	<div class="title">我的消息</div>
        
        <div class="bars"><input type="checkbox" > <a href=""> 删 除 </a></div>
        
        <div class="msg_list">
        	<ul>
            <?php
            	for($i=1;$i<=10;$i++)
				{
			?>
            	<li>
                	<div class="a1">
                    	<div class="a2">
                        	<input type="checkbox" >
                        </div>
                        <div class="a3">
                            <div class="a4" style="color:#090"><strong>笑谈江湖</strong> 回复了您</div>
                            <div class="a5">2014-01-01 10:00</div>
                            <div class="a6">
                                回复的内容回复的内容回复的内容回复的内容
                            </div>
                            
                            <div class="a7">
                            	<strong>您说:</strong><br>
                                这是我之前说的内容哦，哈哈哈哈哈哈这是我之前说的内容哦，哈哈哈哈哈哈这是我之前说的内容哦，哈哈哈哈哈哈这是我之前说的内容哦，哈哈哈哈哈哈
                            </div>
                        </div>
                    </div>
                </li>
            <?php
				}
			?>
            </ul>
        </div>
    </div>

</div>


</body>
</html>