<script src="<?php echo base_url();?>assets/js/zepto.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/layer_mobile/layer.js"></script>
<script>

	
	var textarea_bg="<?php echo base_url();?>assets/images/input_bg.png";
	var timeMax=<?php echo select_config('site','captchaMax');?>;

	var host_a="<?php echo $res['url'];?>";
	var host_b=document.domain;
	var Inshow=1;
	
	$(document).ready(function() {
		if(host_a.indexOf(host_b)<0)
		{
			Inshow=2;	
			$(".hs_comments").html("当前站点不合法，不能调用基本数据信息！");
		}
	});
	
	if(Inshow==1)
	{
		
		var hc_box1;
		function openLoginBox(text,a)
		{
			
			var userAgent=1;
			
			if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
				try{
					if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
						var userAgent=2;
					}
				}catch(e){}
			}
				
			if( location.href.indexOf("https") > -1 )
			{  
				domains="https://" + document.domain;
				
			}
			else
			{
				domains="http://" + document.domain;
			}
			
			var testDomains = '';
			
			if(userAgent==2)
			{
				testDomains = window.location.href;	
			}

			if(a==1)
			{
				$(".sx_otherLoginTitle").html("QQ合作登录");	
				$(".sx_loginFormIframe").html('<iframe src="<?php echo http_url();?>members/qq?url=' + domains + '&backurl=' + testDomains + '"></iframe>');
				showOtherLogin();
			}		
			else
			{
				$(".sx_otherLoginTitle").html("新浪微博合作登录");	
				$(".sx_loginFormIframe").html('<iframe src="<?php echo http_url();?>members/sina?url=' + domains + '&backurl=' + testDomains + '"></iframe>');
				showOtherLogin();	
			}		
		}
		
		function sanfangLogin(code,str)
		{
			if(code==100)
			{
				sfLoginShow(); 	
			}	
			else if(code==200)
			{
			  layer.open({
				content: '您的登录状态异常，请稍后再试！'
				,skin: 'msg'
				,time: 2
			  });
			}
			else if(code==300)
			{
			  layer.open({
				content: str
				,skin: 'msg'
				,time: 2
			  });					
			}
			else
			{
			  layer.open({
				content: '登录失败，请稍后再试！'
				,skin: 'msg'
				,time: 2
			  });				
			}
		}
		
		function showOtherLogin()
		{
			clearTimeout(hc_box1);
			var web_height=document.body.clientHeight;
			var web_width1=screen.width;
			var web_height1=document.documentElement.clientHeight;
			var web_width=document.documentElement.clientWidth;
			
			document.getElementById("hc_comments_bg").style.height=web_height + "px";
			document.getElementById("hc_comments_bg").style.width=web_width + "px";	
			
			if(document.getElementById("hc_comments_bg").style.display!="block")
			{
				$("#hc_comments_bg").show();
			}		
	
			if(document.getElementById("loginFormDiv").style.display!="block")
			{
				$("#loginFormDiv").show();
			}
	
			var div_h=document.getElementById("loginFormDiv").offsetHeight;
			var div_w=document.getElementById("loginFormDiv").offsetWidth;
			
			var top=parseInt((web_height-div_h))/2;
			if(top<=0)
			{
				if(web_height<web_height1)
				{
					web_height=	web_height1;
				}
				var top=parseInt((web_height-div_h))/2;	
				document.getElementById("hc_comments_bg").style.height=web_height + "px";
				$("#hc_comments_bg").show();			
			}
	
			
			document.getElementById("loginFormDiv").style.left=parseInt(web_width-div_w)/2 + "px";
		
			
			document.body.style.overflow="auto";

			hc_box1=setTimeout("showOtherLogin()",100);			
		}
		
		function qqLogin()
		{
			if(members_info=='')
			{
				openLoginBox('QQ合作登录',1);	
				
			}
			else
			{
				  layer.open({
					content: '您的登录状态异常，请稍后再试！'
					,skin: 'msg'
					,time: 2
				  });	
			}	
		}
		
		function sinaLogin()
		{
			if(members_info=='')
			{
				openLoginBox('新浪微博合作登录',2);			
			}
			else
			{
				  layer.open({
					content: '您的登录状态异常，请稍后再试！'
					,skin: 'msg'
					,time: 2
				  });	
			}		
		}
		
		function sfLoginShow()
		{
			if(member_info==1)
			{
				close_hc_login_box();
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				if(comments_csrf=="")
				{
					layer.open({
						content: '系统配置有误，请联系管理员解决!'
						,skin: 'msg'
						,time: 2
					});	
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
								$(".sx_hs_forms_login").hide();
								$(".sx_hs_forms_login_nickname").show();
								$(".sx_hs_forms_login_avatar").show();
								$(".sx_hs_forms_login_nickname").html(data.show.nickname);
								$(".sx_hs_forms_login_avatar").html('<img src="<?php echo base_url();?>' + data.show.avatar + '" class="sx_hs_forms_login_avatar_img">');
								document.getElementById("member_avatars").src="<?php echo base_url();?>" + data.show.avatar;
								close_hc_login_box();							
							}
							else
							{
								members_info='';
								$(".sx_hs_forms_login").show();
								$(".sx_hs_forms_login_nickname").hide();
								$(".sx_hs_forms_login_avatar").hide();	
							}
						},  
						error:function(){ 
							member_info=1; 
							
						}	
					});		
				}
			}			
		}
	
		function clear_input_index()
		{
			var values=$("#csrf_input_index").val();	
			if(values=="就医体验如何？把感受告诉更多人")
			{
				$("#csrf_input_index").val("");	
				$("#csrf_input_index").css("color","#333");
			}
		}
	
	
		function rev_input_index()
		{
			var values=$("#csrf_input_index").val();	
			if(values=="就医体验如何？把感受告诉更多人" || values=="")
			{
				$("#csrf_input_index").val("就医体验如何？把感受告诉更多人");
				$("#csrf_input_index").css("color","#999");	
			}	
		}
		
		function checkReCommentPut(id)
		{
			var values=$("#re_comments_" + id).val();	
			if(values=="就医体验如何？把感受告诉更多人")
			{
				$("#re_comments_" + id).val("");	
				$("#re_comments_" + id).css("color","#333");
			}
		 
		}
		
		function resaveCommentPut(id)
		{
			var values=$("#re_comments_" + id).val();	
			if(values=="就医体验如何？把感受告诉更多人" || values=='')
			{
				$("#re_comments_" + id).val("就医体验如何？把感受告诉更多人");	
				$("#re_comments_" + id).css("color","#ccc");
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
		
		 var insert_do=1;
		function hc_comments_sub()
		{
			if(insert_do==1)
			{
				$(".sx_hc_form_inner").hide();
				var files='';
				$("#upload_success_inners span").each(function(){
					var values=$(this).find(".sx_kkfile").val().replace(/(^\s*)|(\s*$)/g,"");
					if(files=="")
					{
						files=values;	
					}
					else
					{
						files=files + ',' + values;	
					}
				});	
			
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var csrf_input_index=$("#csrf_input_index").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				if(csrf_input_index=="" || csrf_input_index=="就医体验如何？把感受告诉更多人")
				{
	
					layer.open({
					content: '请随便说两句呗！'
					,skin: 'msg'
					,time: 2
					});
	
				}
				else if(csrf_input_index.length>200)
				{
					layer.open({
					content: '内容请不要超过200字哦！'
					,skin: 'msg'
					,time: 2
					});
				}
				else if(comments_csrf=="")
				{
					layer.open({
					content: '您可能长时间未做操作，请刷新重试！'
					,skin: 'msg'
					,time: 2
					});	
				}
				else
				{
					insert_do=2;
					$.ajax({  
						url : "<?php echo base_url();?>index.php/comments/insert",  
						dataType:"jsonp",  
						data:{  
						   "csrf_input_index":csrf_input_index,
						   "comments_csrf":comments_csrf,
						   "cacheId":files,
						   'xingXing':hc_comments_show_id,
						   'cid':comments_sid,
						},  
						type:"GET",  
						jsonp:"jsonpcallback",  
						timeout: 6000,  
						success:function(data){
							insert_do=1;
							if(data.code==100)
							{
								  layer.open({
									content: '发布成功'
									,skin: 'msg'
									,time: 2
								  });
						
								$("#csrf_input_index").val("");
								upload_cache_id='';
								$('#upload_success_inners').html("");
								
								var commentAllInner=parseInt($("#commentAllInner").html())+1;
								$("#commentAllInner").html(commentAllInner);
								$("#commentsAll").html(commentAllInner);
								
								choseId=0;
								readCommentsSelect(1);
								
								hc_comments_show_id=parseInt(hc_comments_show_id);
								
								if(hc_comments_show_id>3)
								{
									var commentsBest=parseInt($("#commentsBest").html())+1;
									$("#commentsBest").html(commentsBest);	
								}
								else if(hc_comments_show_id==3)
								{
									var commentsMedium=parseInt($("#commentsMedium").html())+1;
									$("#commentsMedium").html(commentsMedium);	
								}
								else if(hc_comments_show_id<3 && hc_comments_show_id>0)
								{
									var commentsNegative=parseInt($("#commentsNegative").html())+1;
									
									$("#commentsNegative").html(commentsNegative);	
								}
								
								
							}
							else if(data.code==200)
							{
								hc_login_show();
							}
							else if(data.code==300)
							{
								layer.open({
								content: data.show
								,skin: 'msg'
								,time: 2
								});	
	
							}
							else
							{
	
								layer.open({
								content: '系统错误，请稍后再试！'
								,skin: 'msg'
								,time: 2
								});	
	
							}
						},  
						error:function(){ 
							insert_do=1;
							layer.open({
							content: '系统错误，请稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
						}	
					});						
				}
			}
			else
			{
				layer.open({
				content: '正在发布评论，请稍后再试！'
				,skin: 'msg'
				,time: 2
				});	
	
			}
		}
		
		
	
	
		function hc_login_show()
		{
			close_hc_login_box();
			show_box();	
		}
	
		var hc_box='';
		function show_box()
		{
			clearTimeout(hc_box);
			var web_height=document.body.clientHeight;
			var web_width1=screen.width;
			var web_height1=document.documentElement.clientHeight;
			var web_width=document.documentElement.clientWidth;
			
			document.getElementById("hc_comments_bg").style.height=web_height + "px";
			document.getElementById("hc_comments_bg").style.width=web_width + "px";	
			
			if(document.getElementById("hc_comments_bg").style.display!="block")
			{
				$("#hc_comments_bg").show();
			}		
	
			if(document.getElementById("hc_comments_box").style.display!="block")
			{
				$("#hc_comments_box").show();
			}
	
			var div_h=document.getElementById("hc_comments_box").offsetHeight;
			var div_w=document.getElementById("hc_comments_box").offsetWidth;
			
			var top=parseInt((web_height-div_h))/2;
			if(top<=0)
			{
				if(web_height<web_height1)
				{
					web_height=	web_height1;
				}
				var top=parseInt((web_height-div_h))/2;	
				document.getElementById("hc_comments_bg").style.height=web_height + "px";
				$("#hc_comments_bg").show();			
			}
			
			if(web_height<=web_height1)
			{
				web_height=	web_height;
			}
			else
			{
				web_height=	web_height1;
			}
			
			
			document.getElementById("hc_comments_box").style.left=parseInt(web_width-div_w)/2 + "px";
			document.getElementById("hc_comments_box").style.top=parseInt((web_height-div_h))/2 + "px";
			
			document.body.style.overflow="auto";
	
			hc_box=setTimeout("show_box()",100);			
		}
		
		function close_hc_login_box1()
		{
			$("#loginFormDiv").hide();	
			clearTimeout(hc_box1);	
		}
		
		function close_hc_login_box()
		{
			close_hc_login_box1();
			$("#hc_comments_box").hide();
			$("#hc_comments_bg").hide();
			$(".sx_hc_member_nav").hide();
			$("#hc_comments_bg").hide();
			$("#zoomsShow").hide();
			
			
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
					$("#comments_login_error").hide();
					$("#comments_login_error").html("");
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
			clearTimeout(timeWhileSet);
			timeClock=timeClock-1;
			if(timeClock<=0)
			{
				$(".sx_get_passwds").html('<a href="javascript:comments_get_passwd();">获取新密码</a>');
				clearTimeout(timeWhileSet);
			}	
			else
			{
				$(".sx_get_passwds").html('<a>' + timeClock + '秒后获取</a>');
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
				  layer.open({
					type: 2
					,content: '加载中'
				  });
					login_state=2;
					$("#comments_login_error").hide();
					$("#comments_login_error").html("");
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
					layer.open({
						content: '系统配置有误，请联系管理员解决!'
						,skin: 'msg'
						,time: 2
					});	
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
								$(".sx_hs_forms_login").hide();
								$(".sx_hs_forms_login_nickname").show();
								$(".sx_hs_forms_login_avatar").show();
								$(".sx_hs_forms_login_nickname").html(data.show.nickname);
								$(".sx_hs_forms_login_avatar").html('<img src="<?php echo base_url();?>' + data.show.avatar + '"  class="sx_hs_forms_login_avatar_img">');
								document.getElementById("member_avatars").src="<?php echo base_url();?>" + data.show.avatar;							
							}
							else
							{
								members_info='';
								$(".sx_hs_forms_login").show();
								$(".sx_hs_forms_login_nickname").hide();
								$(".sx_hs_forms_login_avatar").hide();	
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
			var userAgentIf=1;
			
			if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
				try{
					if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
						var userAgentIf=2;
					}
				}catch(e){}
			}
			
			if(userAgentIf==1)
			{	
				$(".sx_plugins_avatar").mouseover(
					function(){
						$(".sx_avatar_fly").show();
					}
				);
				$(".sx_plugins_avatar").mouseleave(
					function(){
						$(".sx_avatar_fly").hide();
					}
				);
			}
			else
			{
				$(".sx_avatar_fly").css("opacity","0");
				$(".sx_avatar_fly").show();
			}
			
			$(".sx_hc_changyandou").mouseover(
				function(){
					$("#ch_doudou_text").show();
				}
			);
			$(".sx_hc_changyandou").mouseleave(
				function(){
					$("#ch_doudou_text").hide();
				}
			);	
			
			jsonpReadComments();
		
		});
		
		function showNewItems(id)
		{
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var site_id=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
			
			$.ajax({  
				url : "<?php echo base_url();?>index.php/comments/readitem",  
				dataType:"jsonp",  
				data:{  
				   "comments_csrf":comments_csrf,
				   "site_id":site_id,
				   "id":id
				},  
				type:"GET",  
				jsonp:"jsonpcallback",  
				timeout: 6000,  
				success:function(data){
					if(data.code==100)
					{
						
						var arrays=data.show.array;
						var htmls='';
						var htmlInner='';
						for(var i=0;i<arrays.length;i++)
						{
							var htmlInner=htmlInner + '<div class="sx_plbt"><img src="<?php echo base_url();?>' + arrays[i]["avatar"] + '" alt="" class="sx_pltx" onclick="javascript:show_members_infos(\'' + arrays[i].uid + '\');"/><span class="sx_mz">' + arrays[i]["nickname"] + '</span><p class="sx_plri"><i>' + arrays[i]["time"] + '</i><span>' + createStar(arrays[i]["star"],arrays[i]["id"]) + '</span></p></div><div class="sx_plcont"><p>' + arrays[i]["fulltext"] + '<a>' + comments_img_show(arrays[i].files,arrays[i].id) + '</a></p><div class="sx_click"><img src="<?php echo base_url();?>assets/images/sx_zan.png" class="sx_zan" onclick="addPraise(\'' + arrays[i].id + '\')" /><span id="praiseInner_' + arrays[i].id + '">' + arrays[i].ok + '</span><img src="<?php echo base_url();?>assets/images/sxpl.png" alt="" class="sx_pl" onclick="showOrHideRe(\'' + arrays[i].id + '\')" /><div class="sx_plreply" id="sx_reply_' + arrays[i]["id"] + '"><textarea  placeholder="就医体验如何？把感受告诉更多人" class="sx_reply1" id="replyItem_' + arrays[i].id + '"></textarea>' + createFaceHtml(arrays[i].id) + '<p><a href="javascript:showFaceDiv(\'' + arrays[i]["id"] + '\')"><img src="<?php echo base_url();?>assets/images/template/face_orange.jpg" alt="" /></a><input type="submit" value="发表" class="sx_reply2" onclick="subReplyItem(\'' + arrays[i].id + '\')"/></p></div></div></div><div class="sx_plhf">' + createReItem(arrays[i]["retext"]) + '</div>';
										
						}	
							
						$('#listsview_' + id).html(htmlInner);				
					}
				},  
				error:function(){ 
	
				}	
			});			
		}	
		
		var choseId=1;
		function readCommentsSelect(id)
		{
			if(choseId!=id)
			{
				$('#commentsAlls').attr('class','sx_commentsAll');	
				$('#commentsBests').attr('class','sx_commentsBest');	
				$('#commentsMediums').attr('class','sx_commentsMedium');	
				$('#commentsNegatives').attr('class','sx_commentsNegative');
				if(id==1)
				{
					$('#commentsAlls').attr('class','sx_commentsAll1');		
				}
				else if(id==2)
				{
					$('#commentsBests').attr('class','sx_commentsBest1');		
				}
				else if(id==3)
				{
					$('#commentsMediums').attr('class','sx_commentsMedium1');		
				}
				else if(id==4)
				{
					$('#commentsNegatives').attr('class','sx_commentsNegative1');		
				}
				choseId=id;
				commentsTypeId=choseId;
				$('.sx_commentsListAll').html('<span id="comments_page_new"></span><span id="comments_page_1"></span>');
				JsonPPageIndex=1;
				jsonpReadComments();	
			}	
		}	
		
		var commentsTypeId=0;
		var JsonPPageIndex=1;
		var JsonPPageShow=1;
		function jsonpReadComments()
		{
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var site_id=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
			if(JsonPPageShow==1)
			{
				JsonPPageShow=2;
				$('.sx_commentsPageLoad').hide();
				$('.sx_commentsPageEnd').hide();
				$('.sx_commentsPageMore').hide();
				if(JsonPPageIndex!=1)
				{
					$('.sx_commentsPageLoad').show();	
				}
				$.ajax({  
					url : "<?php echo base_url();?>index.php/comments/pages/" + JsonPPageIndex,  
					dataType:"jsonp",  
					data:{  
					   "comments_csrf":comments_csrf,
					   "site_id":site_id,
					   "commentsTypeId":commentsTypeId
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						JsonPPageShow=1;

						if(data.code==100)
						{
							$('.sx_commentsPageLoad').hide();
							var arrays=data.show.array;
							var pagecount=parseInt(data.show.pagecount);
							var pageindex=parseInt(data.show.pageindex);
							if(pagecount>pageindex)
							{
								$('.sx_commentsPageMore').show();	
							}
							else if(pagecount==pageindex)
							{
								$('.sx_commentsPageEnd').show();	
							}
		
							var htmls='';
							var htmlInner='';
							
							for(var i=0;i<arrays.length;i++)
							{
								var htmlInner=htmlInner + '<li id="listsview_' + arrays[i].id + '"><div class="sx_plbt"><img src="<?php echo base_url();?>' + arrays[i]["avatar"] + '" alt="" class="sx_pltx" onclick="javascript:show_members_infos(\'' + arrays[i].uid + '\');"/><span class="sx_mz">' + arrays[i]["nickname"] + '</span><p class="sx_plri"><i>' + arrays[i]["time"] + '</i><span>' + createStar(arrays[i]["star"],arrays[i]["id"]) + '</span></p></div><div class="sx_plcont"><p>' + arrays[i]["fulltext"] + '<a>' + comments_img_show(arrays[i].files,arrays[i].id) + '</a></p><div class="sx_click"><img src="<?php echo base_url();?>assets/images/sx_zan.png" class="sx_zan" onclick="addPraise(\'' + arrays[i].id + '\')" /><span id="praiseInner_' + arrays[i].id + '">' + arrays[i].ok + '</span><img src="<?php echo base_url();?>assets/images/sxpl.png" alt="" class="sx_pl" onclick="showOrHideRe(\'' + arrays[i].id + '\')" /><div class="sx_plreply" id="sx_reply_' + arrays[i]["id"] + '"><textarea  placeholder="就医体验如何？把感受告诉更多人" class="sx_reply1" id="replyItem_' + arrays[i].id + '"></textarea>' + createFaceHtml(arrays[i].id) + '<p><a href="javascript:showFaceDiv(\'' + arrays[i]["id"] + '\')"><img src="<?php echo base_url();?>assets/images/template/face_orange.jpg" alt="" /></a><input type="submit" value="发表" class="sx_reply2" onclick="subReplyItem(\'' + arrays[i].id + '\')"/></p></div></div></div><div class="sx_plhf">' + createReItem(arrays[i]["retext"]) + '</div></li>';
											
							}
							
							pageNexts=parseInt(JsonPPageIndex)+1;
							
							$("#comments_page_" + JsonPPageIndex).html(htmlInner + '<span class="sx_spansss" id="comments_page_' + pageNexts + '"></span>');
							
							JsonPPageIndex=pageNexts;
							
							onLoadJsShow();
															
						}
					},  
					error:function(){ 
						JsonPPageShow=1;
					}	
				});					
			}	
		}
		
		
		function comments_img_show1(objs,id,pid)
		{
			var htmlStart='<div class="sx_comments_img_lists"><ul>';
			
			var htmlCenter='';
			
			var htmlShow=false;
			
			for(var i=0;i<objs.length;i++)
			{
				htmlCenter=htmlCenter + '<li><a href=javascript:showBigImg1("' + objs[i].img + '","' + id + '","' + pid + '");><img src="<?php echo base_url();?>' + objs[i].img + '"></a></li>';	
				htmlShow=true;
			}
			
			var htmlEnd='</ul><div class="sx_img_zooms" id="zooms_' + id + '_' + pid + '"><input type="hidden" id="cookieZooms' + id + '_' + pid + '"><div class="sx_bars"><label class="sx_shouqilai"><a href="javascript:suoyisuoUp1(' + id + ',' + pid + ');" >收起</a></label><span>|</span><label class="sx_yuantulook"><a href="javascript:lookZoomPic1(' + id + ',' + pid + ');">查看原图</a></label></div><div class="sx_imgzoomshow" id="zooms_pic_' + id + '_' + pid + '"></div></div></div>';
			
			if(htmlShow)
			{
				var Htmls=htmlStart + htmlCenter + htmlEnd;
				return Htmls;
			}
			
			return '';
			
		}
		
		function comments_img_show(objs,id)
		{
			var htmlStart='';
			
			var htmlCenter='';
			
			var htmlShow=false;
			
			for(var i=0;i<objs.length;i++)
			{
				htmlCenter=htmlCenter + '<img src="<?php echo base_url();?>' + objs[i].img + '" onclick="bigImgShow(\'<?php echo base_url();?>' + objs[i].img + '\')">';	
				htmlShow=true;
			}
			
			var htmlEnd='';
			
			if(htmlShow)
			{
				var Htmls=htmlStart + htmlCenter + htmlEnd;
				return Htmls;
			}
			
			return '';
			
		}
		
		function suoyisuoUp(id)
		{
			$('#zooms_' + id).hide();	
		}
		
		function suoyisuoUp1(id,pid)
		{
			$('#zooms_' + id + '_' + pid).hide();	
		}
		
		function lookZoomPic(id)
		{
			var urls=$('#cookieZooms' + id).val();
			window.open('<?php echo base_url();?>' + urls);
		}
		
		function lookZoomPic1(id,pid)
		{
			var urls=$('#cookieZooms' + id + '_' + pid).val();
			window.open('<?php echo base_url();?>' + urls);
		}
		
		function showBigImg(url,id)
		{
			$('#zooms_' + id).show();
			$('#cookieZooms' + id).val(url);
			$("#zooms_pic_" + id).html('<a href="javascript:suoyisuoUp(' + id + ');"><img src="<?php echo base_url();?>' + url + '"></a>');
		}
		
		function showBigImg1(url,id,pid)
		{
			$('#zooms_' + id + '_' + pid).show();
			$('#cookieZooms' + id + '_' + pid).val(url);
			$("#zooms_pic_" + id + '_' + pid).html('<a href="javascript:suoyisuoUp1(' + id + ',' + pid + ');"><img src="<?php echo base_url();?>' + url + '"></a>');
		}
		
	
		
		function re_comments_inner(id)
		{
			var text=$('#com_huifu_' + id).html().replace(/(^\s*)|(\s*$)/g,"");
			if(text=='回复')
			{
				$('#com_huifu_' + id).html('取消回复');
				$('#re_comments_html_' + id).show();	
			}
			else
			{
				$('#com_huifu_' + id).html('回复');
				$('#re_comments_html_' + id).hide();
			}
		}
		
		function onLoadJsShow()
		{
			
			$('.sx_hc_comments_re_maopao').mousemove(function(e){
				var pc_itemer=$(this).find(".sx_pc_itemer").val();
				$("#re_sub_form_lines_" + pc_itemer).show();
				$("#re_sub_form_liness_" + pc_itemer).hide();
				
			});
			$('.sx_hc_comments_re_maopao').mouseleave(function(e){
				
				var pc_itemer=$(this).find(".sx_pc_itemer").val();
				var hl=$("#re_a_" + pc_itemer).html().replace(/(^\s*)|(\s*$)/g,"");
				
				if(hl=='回复')
				{
					
					$("#re_sub_form_lines_" + pc_itemer).hide();
					$("#re_sub_form_liness_" + pc_itemer).show();	
				}
				
			});
			
			makeDivForWidth();
		}
		
		function makeDivForWidth()
		{

			
		}
		
		function house_show(retext,id)
		{
			var htmlShowTop='';
			var htmlShowBottom='';
			for(var i=0;i<retext.length;i++)
			{
				
				htmlShowTop=htmlShowTop + '<div class="sx_hc_comments_re_item" id="hc_comments_re_item_' + retext[i].id + '_' + id + '">';
				htmlShowBottom=htmlShowBottom + '<div class="sx_hc_comments_re_maopao"><input type="hidden" class="sx_pc_itemer" value="' + retext[i].id + '_' + id + '"><div class="sx_members_infos"><div class="sx_nickname"><a href="javascript:show_members_infos(' + retext[i].uid + ');">' + retext[i].nickname + '</a></div><div class="sx_star"> ' + createStar(retext[i].star,retext[i].pid) + ' ' + parseInt(i+1) + '</div></div><div class="sx_re_contents">' + retext[i].fulltext + '</div>' + comments_img_show1(retext[i].files,retext[i].id,id) + '<div class="sx_re_sub_form_liness" id="re_sub_form_liness_' + retext[i].id + '_' + id + '"></div><div class="sx_comments_re_button" id="re_sub_form_lines_' + retext[i].id + '_' + id + '"><div class="sx_cai" id="caiyicaiI_' + retext[i].id + '_' + id + '"><a href="javascript:caiyicai(' + retext[i].id + ',' + id + ');" id="caiyicai_' + retext[i].id + '_' + id + '"> ' + retext[i].cai + ' </a></div><div class="sx_ding" id="okyiokI_' + retext[i].id + '_' + id + '"><a href="javascript:okyiok(' + retext[i].id + ',' + id + ');" id="okyiok_' + retext[i].id + '_' + id + '"> ' + retext[i].ok + ' </a></div><div class="sx_res" ><a href="javascript:hc_re_comments_put_show1(' + retext[i].id + ',' + id + ');" id="re_a_' + retext[i].id + '_' + id + '">回复</a><input type="hidden" class="sx_hengsar" value="' + retext[i].id + '_' + id + '"></div></div><div class="sx_re_comments_forms" id="re_comments_forms_' + retext[i].id + '_' + id + '"><div class="sx_re_comments_forms_input"><textarea id="re_comments_' + retext[i].id + '_' + id + '" onFocus="checkReCommentPut1(' + retext[i].id + ',' + id + ');" onBlur="resaveCommentPut1(' + retext[i].id + ',' + id + ');">来说两句吧...</textarea></div><div class="sx_re_comments_forms_subs1"><div class="sx_hs_forms_face_re_position1" id="hs_forms_face_re_position_' + retext[i].id + '_' + id + '"><ul>' + getReFace1(retext[i].id,id) + '</ul></div><div class="sx_re_face_inner1"><a href="javascript:show_faces_rere(' + retext[i].id + ',' + id + ');"></a></div><div class="sx_re_face_comments_btn1"><a href="javascript:sub_re_comments(' + retext[i].id + ',' + id + ',' + retext[i].pid +  ',2);"></a></div></div></div></div></div>';	
			} 
			
			return '<div class="sx_ieHacksBug">' + htmlShowTop + htmlShowBottom + '</div>';
				
		}
		
		function okyiok(id,parentId)
		{
			if(members_info=='')
			{
				hc_login_show();	
			}
			else
			{
				var cai=$("#okyiok_" + id + '_' + parentId).html().replace(/(^\s*)|(\s*$)/g,"");
				cai=parseInt(cai)+1;
				$('#okyiokI_' +  + id + '_' + parentId).html('<span class="sx_clicked2"> ' + cai + ' </span>');
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/comments/clicked",  
					dataType:"jsonp",  
					data:{  
					   "comments_csrf":comments_csrf,
					   'cid':comments_sid,
					   'act':"2",
					   'id':id
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						insert_do=1;
						if(data.code==100)
						{
						}
						else if(data.code==200)
						{
							hc_login_show();
						}
						else if(data.code==300)
						{
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});	
	
						}
						else
						{
	
							layer.open({
							content: '系统错误，请稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
	
						}
					},  
					error:function(){ 
						insert_do=1;
						layer.open({
						content: '系统错误，请稍后再试！'
						,skin: 'msg'
						,time: 2
						});	
					}	
				});			
				
			}			
		}
		
	
		function caiyicai(id,parentId)
		{
	
			if(members_info=='')
			{
				hc_login_show();	
			}
			else
			{
				var cai=$("#caiyicai_" + id + '_' + parentId).html().replace(/(^\s*)|(\s*$)/g,"");
				cai=parseInt(cai)+1;
				$('#caiyicaiI_' +  + id + '_' + parentId).html('<span class="sx_clicked1"> ' + cai + ' </span>');
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/comments/clicked",  
					dataType:"jsonp",  
					data:{  
					   "comments_csrf":comments_csrf,
					   'cid':comments_sid,
					   'act':"1",
					   'id':id
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						insert_do=1;
						if(data.code==100)
						{
						}
						else if(data.code==200)
						{
							
							hc_login_show();
						}
						else if(data.code==300)
						{
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});	
	
						}
						else
						{
	
							layer.open({
							content: '系统错误，请稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
	
						}
					},  
					error:function(){ 
						insert_do=1;
						layer.open({
						content: '系统错误，请稍后再试！'
						,skin: 'msg'
						,time: 2
						});	
					}	
				});			
				
			}
		}
	
		
		function hc_re_comments_put_show1(id,parentId)
		{
			var hl=$("#re_a_" + id + '_' + parentId).html().replace(/(^\s*)|(\s*$)/g,"");
			if(hl=='回复')
			{
				$("#re_a_" + id + '_' + parentId).html('取消回复');
				$("#re_comments_forms_" + id + '_' + parentId).show();
					
			}
			else
			{
				$("#re_a_" + id + '_' + parentId).html('回复');
				$("#re_comments_forms_" + id + '_' + parentId).hide();	
			}	
		}
		
		function checkReCommentPut1(id,parentId)
		{
			var values=$("#re_comments_" + id + '_' + parentId).val();	
			if(values=="来说两句吧...")
			{
				$("#re_comments_" + id + '_' + parentId).val("");	
				$("#re_comments_" + id + '_' + parentId).css("background-image","url()");
				$("#re_comments_" + id + '_' + parentId).css("color","#333");
			}			
		}
		
		function resaveCommentPut1(id,parentId)
		{
			var values=$("#re_comments_" + id + '_' + parentId).val();	
			if(values=="来说两句吧..." || values=='')
			{
				$("#re_comments_" + id + '_' + parentId).val("来说两句吧...");	
				$("#re_comments_" + id + '_' + parentId).css("background","url(" + textarea_bg + ") center no-repeat");
				$("#re_comments_" + id + '_' + parentId).css("color","#ccc");
			}			
		}
		
		function getReFace1(id,parentId)
		{
			var Jsons='<?php echo $faceStr;?>';
			arr=Jsons.split('====');
			var returnStr='';
			for(var i=0;i<arr.length;i++)
			{
				array=arr[i].split('____');
				returnStr=returnStr + '<li><img src="<?php echo base_url();?>' + array[1] + '" onClick=inserttag_rere("[' + array[0] + '","]","' + id + '","' + parentId + '")></li>';	
			}
			return returnStr;
		}
		
		function inserttag_rere(topen,tclose,id)
		{
			var themess = document.getElementById('replyItem_' + id);
			themess.focus();
			if (document.selection) {
			var theSelection = document.selection.createRange().text;
			if(theSelection){
			document.selection.createRange().text = theSelection = topen+theSelection+tclose;
			}else{
			document.selection.createRange().text = topen+tclose;
			}
			theSelection='';
			
			}else{
			
				var scrollPos = themess.scrollTop;
				var selLength = themess.textLength;
				var selStart = themess.selectionStart;
				var selEnd = themess.selectionEnd;
				if (selEnd <= 2)
				selEnd = selLength;
				
				var s1 = (themess.value).substring(0,selStart);
				var s2 = (themess.value).substring(selStart, selEnd);
				var s3 = (themess.value).substring(selEnd, selLength);
				
				themess.value = s1 + topen + s2 + tclose + s3;
				
				themess.focus();
				themess.selectionStart = newStart;
				themess.selectionEnd = newStart;
				themess.scrollTop = scrollPos;
				return;
			}				
		}
		
		function show_faces_rere(id,parentId)
		{
			$('#hs_forms_face_re_position_' + id + '_' + parentId).show();	
		}
		
		function hc_re_comments_put_show(id,parentId)
		{
	
		}
		
		function sub_re_comments(id,upid,pid,type)
		{
			if(insert_do==1)
			{
				if(type==1)
				{
					var re_comments=$('#re_comments_' + id).val().replace(/(^\s*)|(\s*$)/g,"");	
				}
				else
				{
					var re_comments=$('#re_comments_' + id + '_' + upid).val().replace(/(^\s*)|(\s*$)/g,"");	
				}
				
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
	
				if(re_comments=="" || re_comments=="来说两句吧...")
				{
				
					layer.open({
					content: '请说两句呗！'
					,skin: 'msg'
					,time: 2
					});
				
				}
				else if(re_comments.length>200)
				{
					layer.open({
					content: '内容请不要超过200字哦！'
					,skin: 'msg'
					,time: 2
					});
				}
				else if(comments_csrf=="")
				{
					layer.open({
					content: '您可能长时间未做操作，请刷新重试！'
					,skin: 'msg'
					,time: 2
					});	
				}
				else
				{
					insert_do=2;
					$.ajax({  
						url : "<?php echo base_url();?>index.php/comments/rev",  
						dataType:"jsonp",  
						data:{  
						   "re_comments":re_comments,
						   "comments_csrf":comments_csrf,
						   'cid':comments_sid,
						   'id':id
						},  
						type:"GET",  
						jsonp:"jsonpcallback",  
						timeout: 6000,  
						success:function(data){
							insert_do=1;
							if(data.code==100)
							{
		
								layer.open({
									content: '回复成功！'
									,skin: 'msg'
									,time: 2
								 });
								 
								choseId=0;
								readCommentsSelect(1);
								
								var commentAllInner=parseInt($("#commentAllInner").html())+1;
								$("#commentAllInner").html(commentAllInner);
								$("#commentsAll").html(commentAllInner);							 
								
								if(type==1)
								{
								
									$('#re_comments_' + id).val("");
								
									$("#re_comments_html_" + id).hide();
									
									$("#listsview_" + id).remove();
								
								}
								else
								{
									$('#re_comments_' + id + '_' + upid).val("");
									
									$("#re_comments_forms_" + id + '_' + upid).hide();
									
									$('#re_a_' + id + '_' + upid).html('回复');
								}
								
								
							}
							else if(data.code==200)
							{
								hc_login_show();
							}
							else if(data.code==300)
							{
								layer.open({
								content: data.show
								,skin: 'msg'
								,time: 2
								});	
	
							}
							else
							{
	
								layer.open({
								content: '系统错误，请稍后再试！'
								,skin: 'msg'
								,time: 2
								});	
	
							}
						},  
						error:function(){ 
							insert_do=1;
							layer.open({
							content: '系统错误，请稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
						}	
					});			
				}
			}
			else
			{
				layer.open({
				content: '正在发布信息，请稍后再试！'
				,skin: 'msg'
				,time: 2
				});	
	
			}
	
		
		}
		
		function getReFace(id)
		{
			var Jsons='<?php echo $faceStr;?>';
			arr=Jsons.split('====');
			var returnStr='';
			for(var i=0;i<arr.length;i++)
			{
				array=arr[i].split('____');
				returnStr=returnStr + '<li><img src="<?php echo base_url();?>' + array[1] + '" onClick=inserttag_re("[' + array[0] + '","]","' + id + '")></li>';	
			}
			return returnStr;
		}
		
		function createStar(int,pid)
		{
			var a='';
			if(int>0)
			{
				for(var i=1;i<=int;i++)
				{
					a=a + '<img src="<?php echo base_url();?>assets/images/grade04.png"> ';
				}
				return a;
			}
			else
			{
				return '';
			}
		}
		
		function hc_login_state_show()
		{
			close_hc_login_box();
			
			show_box1();
			$("#mySelfInfoBtn").show();
			$("#youSelfInfoBtn").hide();
			$(".sx_hc_member_nav").show();
			$(".sx_comments_you_inner").hide();
			ch_show_my();
			var counts=parseInt(members_info.msgCount);
			if(counts>0)
			{
				$('.sx_msgCountShow').show();
				$('.sx_msgCountShow').html(counts);	
			}
		}
	
		function show_box1()
		{
			clearTimeout(hc_box);
			var web_height=document.body.clientHeight;
			var web_width1=screen.width;
			var web_height1=document.documentElement.clientHeight;
			var web_width=document.documentElement.clientWidth;
			
			document.getElementById("hc_comments_bg").style.height=web_height + "px";
			document.getElementById("hc_comments_bg").style.width=web_width + "px";	
			document.body.style.overflow="auto";
			if(document.getElementById("hc_comments_bg").style.display!="block")
			{
				$("#hc_comments_bg").show(400);
			}
			
			hc_box=setTimeout("show_box1()",100);			
		}
		var members_info="";
		
		function ch_show_my()
		{
			$(".sx_comments_my_inner").show();
			$(".sx_comments_task_inner").hide();
			$(".sx_comments_msg_inner").hide();
			
		   $("#comments_login_my").attr("class","sx_comments_login_my1"); 	
		   $("#comments_login_task").attr("class","sx_comments_login_task"); 	
		   $("#comments_login_msg").attr("class","sx_comments_login_msg"); 
		   	
			if( location.href.indexOf("https") > -1 )
			{  
				domains="https://" + document.domain;
				
			}
			else
			{
				domains="http://" + document.domain;
			}  	
		
			$("#avatarIframes").html('<iframe src="<?php echo http_url();?>members/avatarshow?url=' + domains + '" frameborder="0" style="width:80px;height:80px;border:none; overflow:hidden;filter:alpha(opacity=00);Opacity:0;"></iframe>');
		
			document.getElementById("member_avatars").src="<?php echo base_url();?>" + members_info.avatar;
			$("#member_nickname").html(members_info.nickname);
			$("#ch_money").html(members_info.count1);
			$("#ch_comments_count").html(members_info.commentCount);
			comments_member_info_read();
		}
		
		function avatarBacks(code,str)
		{
			if( location.href.indexOf("https") > -1 )
			{  
				domains="https://" + document.domain;
				
			}
			else
			{
				domains="http://" + document.domain;
			} 
			$("#avatarIframes").html('<iframe src="<?php echo http_url();?>members/avatarshow?url=' + domains + '" frameborder="0" style="width:80px;height:80px;border:none; overflow:hidden;filter:alpha(opacity=00);Opacity:0;"></iframe>');
			if(code==200)
			{
				hc_login_show();		
			}	
			else if(code==300)
			{
				layer.open({
				content: str
				,skin: 'msg'
				,time: 2
				});	
			}
			else if(code==100)
			{
				members_info.avatar=str;
				document.getElementById("member_avatars").src="<?php echo base_url();?>" + members_info.avatar;
				$(".sx_hs_forms_login_avatar").html('<img src="<?php echo base_url();?>' + members_info.avatar + '"  class="sx_hs_forms_login_avatar_img">');	
			}
			else
			{
				layer.open({
				content: '上传失败，请您稍后再试！'
				,skin: 'msg'
				,time: 2
				});					
			}
		}
	
		function ch_show_task()
		{
			$(".sx_comments_my_inner").hide();
			$(".sx_comments_task_inner").show();
			$(".sx_comments_msg_inner").hide();	
	
		   $("#comments_login_my").attr("class","sx_comments_login_my"); 	
		   $("#comments_login_task").attr("class","sx_comments_login_task1"); 	
		   $("#comments_login_msg").attr("class","sx_comments_login_msg"); 	
	
		   $(".sx_hc_changyandou").html(members_info.money);
	
		}
		
		var mgsShowLoad=1;
		function ch_show_msg()
		{
			$(".sx_comments_my_inner").hide();
			$(".sx_comments_task_inner").hide();
			$(".sx_comments_msg_inner").show();	
			
			$("#comments_login_my").attr("class","sx_comments_login_my"); 	
			$("#comments_login_task").attr("class","sx_comments_login_task"); 	
			$("#comments_login_msg").attr("class","sx_comments_login_msg1");
			
			var msgCount=parseInt($('.sx_msgCountShow').html());
			if(msgCount>0)
			{
				$('.sx_msgCountShow').hide();
				$('.sx_msgCountShow').html(' 0 ');
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/msgclear",  
					dataType:"jsonp",  
					data:{  
					   "comments_csrf":comments_csrf,
					   "comments_sid":comments_sid
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						
					},  
					error:function(){ 
				
					}	
				});
			}
			if(mgsShowLoad==1)
			{
				pageMsgShow(1);	
			}			
		}
		
		var pageMsgIndex=1;
		var pageMsgLoad=1;
		function pageMsgShow(page)
		{
			if(pageMsgLoad==1)
			{
				mgsShowLoad=2;
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/msgall",  
					dataType:"jsonp",  
					data:{
					   "comments_sid":comments_sid,
					   "page":page
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						if(data.code==100)
						{
							var array=data.show.lists;
							var counts=parseInt(data.show.counts);
							
							var htmlShow='';
							for(var i=0;i<array.length;i++)
							{
								htmlShow=htmlShow + '<li id="nnn_' + array[i].id + '"><div class="sx_a1"><div class="sx_a2"><input type="checkbox" name="hc_cid" value="' + array[i].id + '" ></div><div class="sx_a3"><div class="sx_a4"><strong>' + array[i].nickname + '</strong> 回复了您</div><div class="sx_a5">' + array[i].time + '</div><div class="sx_a6">' + array[i].showText + '</div><div class="sx_a7"><strong>您说:</strong><br>' + array[i].yousText + '</div></div></div></li>';	
							}
							
							$('#msgPageInner').append(htmlShow);
							
							pageMsgIndex=page;
							
							pageMsgIndex=parseInt(pageMsgIndex)+1;
							
							
							if(pageMsgIndex<=counts)
							{
								$(".sx_msgNextBtn").show();
								$(".sx_msgNextBtn").html('<a href="javascript:pageMsgShow(' + pageMsgIndex + ')">点击加载下一页</a>');	
							}
							else
							{
								pageMsgLoad=2;
								$(".sx_msgNextBtn").hide();
								$(".sx_msgNoBtn").show();		
							}
						}
						else if(data.code==200)
						{
							close_hc_login_box();
							hc_login_show();
						}
						else if(data.code==300) 
						{
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});	
						}
						else if(data.code==400) 
						{
							pageMsgLoad=2;
							$(".sx_msgNextBtn").hide();
							$(".sx_msgNoBtn").show();		
						}
						else
						{
							layer.open({
							content: '消息读取失败，请您稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
						}
					},  
					error:function(){ 
				
					}	
				});	
			}	
		}
		
		function choose_hc_msg_all()
		{
	
			var s_group = document.getElementsByName("hc_sx");
			var s_group_value="";
			for(var i = 0; i< s_group.length; i++){
				if(s_group[i].checked==true){
					s_group_value=s_group[i].value;
				}
			}
			var s_group = document.getElementsByName("hc_cid");
			for(var i = 0; i< s_group.length; i++){
				if(s_group_value!=""){
					s_group[i].checked=true;
				}else{
					s_group[i].checked=false;	
				}
			}			
		}
		
		function deleteMsg()
		{
			var s_group = document.getElementsByName("hc_cid");
			var s_group_value="";
			for(var i = 0; i< s_group.length; i++){
				if(s_group[i].checked==true){
			
					if(s_group_value==""){
						s_group_value=s_group[i].value;	
					}else{
						s_group_value=s_group_value + "," + s_group[i].value;
					}
				}
			}	
			if(s_group_value=="")
			{
				layer.open({
				content: '请选择您要删除的消息！'
				,skin: 'msg'
				,time: 2
				});
			}
			else
			{
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/msgdelete",  
					dataType:"jsonp",  
					data:{
					   "comments_sid":comments_sid,
					   "id":s_group_value
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						if(data.code==100)
						{
							deleteMsgInnner(s_group_value);
						}
						else if(data.code==200)
						{
							close_hc_login_box();
							hc_login_show();
						}
						else if(data.code==300) 
						{
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});	
						}
						else
						{
							layer.open({
							content: '消息删除失败，请您稍后再试！'
							,skin: 'msg'
							,time: 2
							});	
						}
					},  
					error:function(){ 
						layer.open({
						content: '服务器连接失败，请您稍后再试！'
						,skin: 'msg'
						,time: 2
						});
					}	
				});				
			}	
		}
		
		function deleteMsgInnner(id)
		{
			if(id.indexOf(',')>=0)
			{
				arr=id.split(',');
				for(var i=0;i<arr.length;i++)
				{
					$("#nnn_" + arr[i]).remove();	
				}	
			}	
			else
			{
				$("#nnn_" + id).remove();	
			}
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
						members_info='';
						comments_member_info_read();
						close_hc_login_box();											
					}
				},  
				error:function(){ 
	
					layer.open({
					content: '退出会员系统失败，请您稍后再试！'
					,skin: 'msg'
					,time: 2
					});
				}	
			});			
		}
		
		function show_edit_nickname()
		{
			$(".sx_plugins_nickname").hide();	
			$(".sx_plugins_nickname1").show();
			$("#hc_edit_nickname").val(members_info.nickname);
		}
		
		function sub_edit_nickname()
		{
			var nickname=$("#hc_edit_nickname").val().replace(/(^\s*)|(\s*$)/g,"");	
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			if(comments_csrf=="")
			{
	
				layer.open({
				content: '您可能长时间没有操作页面，请刷新重试！'
				,skin: 'msg'
				,time: 2
				});
			}
			else if(nickname=="")
			{
				layer.open({
				content: '请填写您的新昵称！'
				,skin: 'msg'
				,time: 2
				});
	
			}
			else if(nickname.length>10)
			{
				layer.open({
				content: '新昵称长度太长了！'
				,skin: 'msg'
				,time: 2
				});
		
			}
			else
			{
				  layer.open({
					type: 2
					,content: '加载中'
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
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});
							$(".sx_plugins_nickname").show();	
							$(".sx_plugins_nickname1").hide();
							members_info.nickname=nickname;
							$("#member_nickname").html(members_info.nickname);
							$(".sx_hs_forms_login_nickname").html(members_info.nickname);
						}
						else if(data.code==300)
						{
							layer.open({
							content: data.show
							,skin: 'msg'
							,time: 2
							});
						}
						else
						{
	
							layer.open({
							content: '系统错误，请稍后再试！'
							,skin: 'msg'
							,time: 2
							});
						}
					},  
					error:function(){
						layer.closeAll();
						layer.open({
						content: '系统错误，请稍后再试！'
						,skin: 'msg'
						,time: 2
						});
					}	
				});			
			}
	
		}
		
		
		function choose_all()
		{
			var s_group = document.getElementsByName("hc_sx");
			var s_group_value="";
			for(var i = 0; i< s_group.length; i++){
				if(s_group[i].checked==true){
					s_group_value=s_group[i].value;
				}
			}
			var s_group = document.getElementsByName("hc_cid");
			for(var i = 0; i< s_group.length; i++){
				if(s_group_value!=""){
					s_group[i].checked=true;
				}else{
					s_group[i].checked=false;	
				}
			}	
		}
		
		function upload_load()
		{
			  layer.open({
				type: 2
				,content: '加载中'
			  });		
		}
		
		function close_load()
		{
			layer.closeAll();	
		}
		
		function msg_show(show)
		{
	
			  layer.open({
				content: show
				,skin: 'msg'
				,time: 2
			  });	
		}
		
		function changeAvatar(url)
		{
			members_info.avatar=url;
			$(".sx_hs_forms_login_avatar").html('<img src="<?php echo base_url();?>' + members_info.avatar + '"  class="sx_hs_forms_login_avatar_img">');
			document.getElementById("member_avatars").src="<?php echo base_url();?>" + members_info.avatar;	
			$(".sx_avatar_fly").hide();
		}
		
		var commentUpFileInt=100;
		
		function addCommentFile(str)
		{
			commentUpFileInt=parseInt(commentUpFileInt)+1;
			var upload_success_inners=$("#upload_success_inners").html();
			$("#upload_success_inners").html(upload_success_inners + '<span id="aaasss_' + commentUpFileInt + '" onClick=delete_img("' + str + '","' + commentUpFileInt + '"); style="float:left;"><input type="hidden" class="sx_kkfile" value="' + str + '" ><img src="<?php echo base_url();?>' + str + '" style="width:38px;height:38px;margin-right:5px;border:#e4e4e4 1ps solid; border-radius:5px;"></span>');	
		}
		
		function commentupBack(code,str)
		{
			if(code==100)
			{
			
				addCommentFile(str);
				var cs=0;
				$("#upload_success_inners span").each(function(){
					cs=parseInt(cs)+1;	
				});	
				
				if( location.href.indexOf("https") > -1 )
				{  
					domains="https://" + document.domain;
					
				}
				else
				{
					domains="http://" + document.domain;
				} 
				$("#commentsUploadFileFrame").html('<iframe style="width:40px;height:40px;overflow:hidden;border:none;" src="<?php echo http_url();?>members/fileup?url=' + domains + '&nows=' + cs + '" frameborder="0"></iframe>');	
			}
			else if(code==200)
			{
				hc_login_show();
					
			}
			else if(code==300)
			{
				layer.open({
				content: str
				,skin: 'msg'
				,time: 2
				});	
				var cs=0;
				$("#upload_success_inners span").each(function(){
					cs=parseInt(cs)+1;	
				});	
				if( location.href.indexOf("https") > -1 )
				{  
					domains="https://" + document.domain;
					
				}
				else
				{
					domains="http://" + document.domain;
				} 
				$("#commentsUploadFileFrame").html('<iframe style="width:40px;height:40px;overflow:hidden;border:none;" src="<?php echo http_url();?>members/fileup?url=' + domains + '&nows=' + cs + '" frameborder="0"></iframe>');		
			}
			else
			{
				layer.open({
				content: "上传失败，请稍后再试"
				,skin: 'msg'
				,time: 2
				});	
				var cs=0;
				$("#upload_success_inners span").each(function(){
					cs=parseInt(cs)+1;	
				});	
				if( location.href.indexOf("https") > -1 )
				{  
					domains="https://" + document.domain;
					
				}
				else
				{
					domains="http://" + document.domain;
				} 
				$("#commentsUploadFileFrame").html('<iframe style="width:40px;height:40px;overflow:hidden;border:none;" src="<?php echo http_url();?>members/fileup?url=' + domains + '&nows=' + cs + '" frameborder="0"></iframe>');		
			}
		}
		
		function hc_comments_show_face()
		{
			var cs=0;
			$("#upload_success_inners span").each(function(){
				cs=parseInt(cs)+1;	
			});	
			
			$("#hs_forms_face_position").show();
			if( location.href.indexOf("https") > -1 )
			{  
				domains="https://" + document.domain;
				
			}
			else
			{
				domains="http://" + document.domain;
			} 
			$("#commentsUploadFileFrame").html('<iframe style="width:40px;height:40px;overflow:hidden;border:none;" src="<?php echo http_url();?>members/fileup?url=' + domains + '&nows=' + cs + '" frameborder="0"></iframe>');	
		}
		
		window.onload=function(){
			var myDiv = document.getElementById("hs_forms_face_position");
			document.addEventListener("click",function(){
				myDiv.style.display="none";
			});
			myDiv.addEventListener("click",function(event){
				event=event||window.event;
				event.stopPropagation();
			});
			
			$(document).bind("click",function(e){ 
				var target = $(e.target); 
				if(target.closest(".sx_hs_forms_face_re_position").length==0){ 
					$(".sx_hs_forms_face_re_position").hide(); 
				} 
			});
			
			$(document).bind("click",function(e){ 
				var target = $(e.target); 
				if(target.closest(".sx_hs_forms_face_re_position1").length==0){ 
					$(".sx_hs_forms_face_re_position1").hide(); 
				} 
			});
			
			$(document).bind("click",function(e){ 
				var target = $(e.target); 
				if(target.closest(".sx_comments_yin").length==0){ 
					$(".sx_comments_yin").hide(); 
				} 
			});		
	
		};
	
		
		function show_faces_re(id)
		{
			$('#hs_forms_face_re_position_' + id).show();
		}
		
		function inserttag_re(topen,tclose,id)
		{
			var themess = document.getElementById('re_comments_' + id);
			themess.focus();
			if (document.selection) {
			var theSelection = document.selection.createRange().text;
			if(theSelection){
			document.selection.createRange().text = theSelection = topen+theSelection+tclose;
			}else{
			document.selection.createRange().text = topen+tclose;
			}
			theSelection='';
			
			}else{
			
				var scrollPos = themess.scrollTop;
				var selLength = themess.textLength;
				var selStart = themess.selectionStart;
				var selEnd = themess.selectionEnd;
				if (selEnd <= 2)
				selEnd = selLength;
				
				var s1 = (themess.value).substring(0,selStart);
				var s2 = (themess.value).substring(selStart, selEnd);
				var s3 = (themess.value).substring(selEnd, selLength);
				
				themess.value = s1 + topen + s2 + tclose + s3;
				
				themess.focus();
				themess.selectionStart = newStart;
				themess.selectionEnd = newStart;
				themess.scrollTop = scrollPos;
				return;
			}	
		}
		
		function inserttag(topen,tclose)
		{
			var themess = document.getElementById('csrf_input_index');
			themess.focus();
			if (document.selection) {
			var theSelection = document.selection.createRange().text;
			if(theSelection){
			document.selection.createRange().text = theSelection = topen+theSelection+tclose;
			}else{
			document.selection.createRange().text = topen+tclose;
			}
			theSelection='';
			
			}else{
			
				var scrollPos = themess.scrollTop;
				var selLength = themess.textLength;
				var selStart = themess.selectionStart;
				var selEnd = themess.selectionEnd;
				if (selEnd <= 2)
				selEnd = selLength;
				
				var s1 = (themess.value).substring(0,selStart);
				var s2 = (themess.value).substring(selStart, selEnd);
				var s3 = (themess.value).substring(selEnd, selLength);
				
				themess.value = s1 + topen + s2 + tclose + s3;
				
				themess.focus();
				themess.selectionStart = newStart;
				themess.selectionEnd = newStart;
				themess.scrollTop = scrollPos;
				return;
			}
		}	
		
		var upload_now=1;
		
		var upload_cache_id='';
		var upload_file_window_a;
		var Windowloop_a;
		
		function upload_comments_file_a()
		{
			
			if(members_info=='')
			{
				hc_login_show();
			}
			else
			{
				if(upload_cache_id=='')
				{
					upload_cache_id=new Date().getTime();
				}
				
				if(upload_now==1)
				{
					var iHeight=170;
					var iWidth=350;
					var iTop = (window.screen.height-30-iHeight)/2;
					var iLeft = (window.screen.width-10-iWidth)/2;  
					upload_file_window_a=window.open('<?php echo base_url();?>index.php/members/uploads?day=<?php echo date('Y-m-d');?>&id=' + upload_cache_id,"上传图片",'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');	
					upload_now=2;
					Windowloop_a = setInterval(function() {     
						if(upload_file_window_a  != null && upload_file_window_a.closed) {    
							clearInterval(Windowloop_a); 
							show_hc_upload_file();   
							upload_now=1;
						}    
					},150);
				}
				else
				{
				  layer.open({
					content: '请先关闭其他上传小窗口，谢谢！'
					,skin: 'msg'
					,time: 2
				  });
	
				}			
			}
		}
		
		function show_hc_upload_file()
		{
			
			if(upload_cache_id!='')
			{
				$.ajax({  
				url : "<?php echo base_url();?>index.php/members/redimg",  
				dataType:"jsonp",  
				data:{  
				   "upload_cache_id":upload_cache_id,
				},  
				type:"GET",  
				jsonp:"jsonpcallback",  
				timeout: 6000,  
				success:function(data){
					if(data.code==100)
					{
						var results='';
						for(var i=0;i<data.show.length;i++)
						{
				
							
							results=results + '<span id="aaasss_' + i + '" onClick=delete_img("' + data.show[i].img + '","' + i + '","' + upload_cache_id + '"); style="float:left;"><img src="<?php echo base_url();?>' + data.show[i].img + '" style="width:38px;height:38px;margin-right:5px;border:#e4e4e4 1ps solid; border-radius:5px;"></span>'; 
							
	 
						}
						$("#upload_success_inners").html(results);   
					}
				}, 
				error:function(){ 
					
				}	
			});							
			}	
		}
		
		function delete_img(url,id)
		{
			$.ajax({  
				url : "<?php echo base_url();?>index.php/members/imgdel",  
				dataType:"jsonp",  
				data:{  
				   "url":url,
				},  
				type:"GET",  
				jsonp:"jsonpcallback",  
				timeout: 6000,  
				success:function(data){
					if(data.code==100)
					{
						$("#aaasss_" + id).remove(); 
					}
				}, 
				error:function(){ 
					
				}	
			});			
		}
	
		var windowObj;
		var Windowloop;
		function show_avatar_window()
		{
			if(upload_now==1)
			{
				$("#avatarFile").click();
			}
			else
			{
			  layer.open({
				content: '还有上传任务未完成，请稍等！'
				,skin: 'msg'
				,time: 2
			  })
			}
		}
		

		
		var memb_select=1;
		function show_members_infos(id)
		{
			
			if(memb_select==1)
			{
				if(members_info!='')	
				{
					if(members_info.id==id)
					{
						hc_login_state_show();
							
					}	
					else
					{
						memb_select=1;
						read_other_members_infos(id);	
					}
				}
				else
				{
					memb_select=1;
					read_other_members_infos(id);
				}
			}
		}
		
		var otherUserData="";
		
		function read_other_members_infos(id)
		{
			var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
			var sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
			if(otherUserData!='' && otherUserData.id==id)
			{
				show_members_infos_data_windows();	
			}
			else
			{
				$.ajax({  
					url : "<?php echo base_url();?>index.php/members/infodata",  
					dataType:"jsonp",  
					data:{
					   "comments_csrf":comments_csrf,
					   "id":id,
					   "sid":sid
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						layer.closeAll();
						login_state=1;
						memb_select=1;
					
						if(data.code==100)
						{
							otherUserData=data.show;
							show_members_infos_data_windows();
						}
						else if(data.code==300)
						{
							layer.closeAll();
								layer.open({
								content: data.show
								,skin: 'msg'
								,time: 2
							});
						}
						else
						{
							layer.closeAll();
								layer.open({
								content: '服务器连接失败，请您稍后再试！'
								,skin: 'msg'
								,time: 2
							});	
						}
					},  
					error:function(){ 
						layer.closeAll();
							layer.open({
							content: '服务器连接失败，请您稍后再试！'
							,skin: 'msg'
							,time: 2
						});				
					}	
				});	
			}
		}
		
		function show_members_infos_data_windows()
		{
			$("#mySelfInfoBtn").hide();
			$("#youSelfInfoBtn").show();
			show_box1();
			$(".sx_hc_member_nav").show();
			ch_show_you();
		}
		
		function ch_show_you()
		{
			$('.sx_comments_you_inner').show();
			document.getElementById("member_avatars1").src="<?php echo base_url();?>" + otherUserData.avatar;
			
			$(".sx_yourNickname").html(otherUserData.nickname);
			$("#youCommentsCounts").html(otherUserData.count);
			$("#youEndTimeShow").html(otherUserData.login_time);
	
		}
	
	}

</script>
<?php require 'comments.js.update.php';?>