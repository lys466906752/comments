<style type="text/css">
	body,td,th {
		font-size: 14px;
	}
	.sx_hs_comments{
		margin:0 auto; height:auto;width:100%;font-size:14px;
	}
	.sx_hs_comments_center_pad{width:98%; float:left; padding-left:1%; padding-right:1%;background:#fff;}
	.sx_hs_comments div{font-size:14px;}
	.sx_commentstextarea{resize:none;width:98%;margin-left:1%; margin-right:1%;border:none; outline:none;color:#999;min-height:100px;}
	
	
	.sx_hs_comments div,.sx_hs_comments td,.sx_hs_comments th,.sx_hs_comments textarea,.sx_hs_comments input,.sx_hc_comments_box{
		font-family: "微软雅黑";font-size:14px;
	}
	.sx_hs_comments ul{padding:0; margin:0;}
	.sx_hs_comments li{padding:0; margin:0; list-style:none;}
	.sx_hs_comments .sx_star li{ float:left; text-align:right; padding-right:5px; cursor:pointer;}
	.sx_hs_comments .sx_comments_submit{width:auto;float:right; padding-top:10px;}
	.sx_hs_comments .sx_comments_submit a{width:102px; height:30px; background:url(<?php echo base_url();?>assets/images/template/post-btn-lan.jpg) no-repeat; display:inline-block;}
	.sx_hs_comments .sx_comments_submit a:hover{width:102px; height:30px; background:url(<?php echo base_url();?>assets/images/template/post-bt-lan2.jpg) no-repeat; display:inline-block;}
	
	.sx_hs_box{width:100%; float:left; height:auto; padding-bottom:12px;}
	.sx_hs_forms{width:100%; float:left; height:40px;}
	.sx_hs_forms_login{width:40px; height:40px; border-radius:50%; text-align:center;border:#4398ed 1px solid;font-size:16px; line-height:40px;color:#4398ed; margin-left:12px; position:absolute;z-index:4; margin-top:3px; background:#FFF; cursor:pointer;}
	.sx_hs_forms_login_avatar{width:40px; height:40px; text-align:center;font-size:16px;color:#4398ed; margin-left:12px; position:absolute;z-index:4; margin-top:3px; background:#FFF;cursor:pointer; display:none;border-radius:50%;}
	.sx_hs_forms_login_avatar img{width:40px;height:40px;border-radius:50%;}
	.sx_hs_forms_login_avatar_img{width:40px;height:40px;border-radius:50%;}
	
	.sx_hs_comments .sx_inputcomments{width:100%;float:left;height:auto;border:#4398ed 1px solid;border-radius:8px; padding-top:18px; position:relative;z-index:1;background:#FFF;}
	
	.sx_hs_forms_face{width:30px; float:left; height:30px; padding-top:18px; padding-left:15px;}
	.sx_hs_forms_face a{width:18px;height:18px; background:url(<?php echo base_url();?>assets/images/template/face_lan.jpg) no-repeat; display:inline-block;}
	.sx_hs_forms_face a:hover{width:18px;height:18px; background:url(<?php echo base_url();?>assets/images/template/face_lan2.jpg) no-repeat; display:inline-block;}
	.sx_hs_comments_star{width:auto; float:right; padding-top:18px; padding-right:5px;}
	.sx_hs_comments_star .sx_star{width:auto; float:right; height:auto; padding-top:1px;}
	.sx_hs_comments_star .sx_star_text {width:auto;float:right; padding-right:10px;}
	
	.sx_hs_comments_lists{width:100%; float: left; height: auto; padding-top: 25px;}
	.sx_hs_comments_lists .sx_item_title{position:absolute;z-index:2;width: 70px; line-height: 30px; border:#4398ed 1px solid;border-top-right-radius: 8px; background: #fff; border-bottom: none;border-top-left-radius: 8px; text-align: center;color:#4398ed;font-size:16px;}
	.sx_hs_comments_lists .sx_item_line{line-height: 30px;height: 30px;position: relative;overflow: hidden;border-bottom:#4398ed 1px solid; text-align: right;color:#4398ed;}
	.sx_hs_comments_start{width: 100%; float: left; height:auto; padding-top:20px;}
	.sx_hs_comments_start .sx_comments_alts{width:100px; float: left;padding-left:15px; text-align: left; line-height:55px;font-size:16px;font-weight:blod;color:#4398ed;}
	.sx_hs_box .sx_listsview{width:100%; float:left; height:auto; border-bottom:#e4e4e4 1px dashed; padding-bottom:8px; padding-top:8px;}
	.sx_hs_lists_avatar{border-radius:50%;width:45px;height:45px;}
	.sx_pd15{padding-top:8px;}
	.sx_hs_comments_nickname{width:110px; float: left; height: 30px; line-height: 30px;color:#4398ed;font-size:12px; overflow:hidden;}
	.sx_hs_comments_nickname a{color:#4398ed;font-size:12px;text-decoration:none;}
	.sx_hs_comments_nickname a:hover{color:#4398ed;font-size:12px;text-decoration:none;}
	.sx_hs_comments_star_show{width:auto;float: right;text-align:right;color:#999;font-size:10px;color:#999; margin-top:7px;}
	.sx_comments_contents{width:100%; float: left;height:auto;line-height:25px;}
	.sx_comments_button{width:100%; float:left; height:auto; text-align:right; padding-top:10px;}
	.sx_hc_form_inner{width:100%; float:left; text-align:center; height:35px; line-height:35px; color:#F00; display:none;}
	
	#hc_comments_bg{position:fixed;background:#000000;filter:alpha(opacity=80);Opacity:0.8;width:2000px; height:1200px;left:0px;top:0px;z-index:99999995;display:none;}
	#hc_comments_box{position:fixed;z-index:99999996;width:auto;height:auto;top:200px;left:200px;display:none;}
	
	#comments_login_error{width:310px; float:left; text-align:center; padding-top:15px;color:#F00;font-size:13px; display:none;}
	
	#hc_comments_box .sx_login_form{width:310px;height:auto;float:left;background:#FFF;border-radius:10px; padding-bottom:30px;}
	#hc_comments_box .sx_login_form_close_btn{width:100%; float:left; text-align:right; line-height:40px;}
	#hc_comments_box .sx_login_form_close_btn a{margin-right:10px;font-size:24px;font-weight:bold; text-decoration:none;color:#999;}
	#hc_comments_box .sx_login_form_close_btn a:hover{margin-right:10px;font-size:24px;font-weight:bold; text-decoration:none;color:#333;}
	#hc_comments_box .sx_login_alts{width:100%; float:left; text-align:center; font-size:18px;color:#333;}
	#hc_comments_box .sx_login_alts_innner{width:100%; float:left; text-align:center; font-size:14px;color:#999; line-height:30px;}
	#hc_comments_box .sx_login_input{width:100%; float:left; text-align:center; padding-top:5px;}
	#hc_comments_box .sx_login_input input{font-size:14px;font-weight:normal;}
	#comments_login_mobile{outline:none; width:290px; line-height:35px; height:35px; border:#999 1px solid; border-radius:8px;  padding-left:10px;}
	#hc_comments_box .sx_login_input1{width:310px; float:left; text-align:center; padding-top:15px;}
	#hc_comments_box .sx_login_input1 input{font-size:14px;font-weight:normal; }
	#comments_login_passwd{outline:none; width:195px; line-height:35px; height:35px; border:#999 1px solid; border-radius:8px; padding-left:10px;margin-right:5px;}
	.sx_get_passwds a{width:85px;line-height:35px; height:35px; border:#999 1px solid; border-radius:8px; padding-left:2%; display:inline-block; text-decoration:none; text-align:center;color:#666;font-size:14px;}
	.sx_get_passwds a:hover{width:85px;line-height:35px; height:35px; border:#38a3fd 1px solid; background:#38a3fd
	;border-radius:8px; padding-left:2%; display:inline-block; text-decoration:none; text-align:center;color:#fff;font-size:14px;}
	.sx_comments_login_btn{width:100%; float:left; text-align:center; padding-top:15px;font-size:16px;}
	.sx_comments_login_btn a{background:#38a3fd;border-radius:8px;display:inline-block; width:290px;height:35px; line-height:35px;color:#FFF; text-decoration:none;}
	.sx_comments_login_btn a:hover{background:#198ae8;border-radius:8px;display:inline-block; width:290px;height:35px; line-height:35px;color:#FFF; text-decoration:none;}
	.sx_comments_other_login{width:100%; float:left; text-align:center; padding-top:25px;}
	.sx_comments_other_login .sx_qq a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -80px no-repeat;display:inline-block; margin-right:15px;}
	.sx_comments_other_login .sx_qq a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -80px no-repeat;display:inline-block; margin-right:15px;}
	
	.sx_comments_other_login .sx_sina a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -40px no-repeat;display:inline-block;margin-right:15px;}
	.sx_comments_other_login .sx_sina a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -40px no-repeat;display:inline-block;margin-right:15px;}
	
	
	.sx_comments_other_login .sx_phone a{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) 0px -120px no-repeat;display:inline-block;}
	.sx_comments_other_login .sx_phone a:hover{width:40px;height:40px;background:url(<?php echo base_url();?>assets/images/login-group.png) -40px -120px no-repeat;display:inline-block;}
	.sx_comments_login_history{width:100%; float:left; text-align:center; padding-top:15px;color:#999;font-size:12px;}
	
	.sx_hs_forms_login_down{width:45px;height:40px; border-radius:50%; background:#FFF; position:absolute;z-index:2;border:#4398ed 1px solid; margin-left:10px; margin-top:10px;}
	.sx_hs_forms_login_down_bg{width:70px;height:40px; background:#fff; position:absolute;z-index:3;margin-left:10px;}
	.sx_hs_forms_login_nickname{width:auto; height:40px; line-height:40px; text-align:center; background:#FFF; position:absolute;z-index:5; margin-left:70px; margin-top:20px; padding-left:10px; padding-right:10px;color:#4398ed; display:none;}
	
	.sx_comments_login_my1 a{background:url(<?php echo base_url();?>assets/images/tab-list-icon-active1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_my a{background:url(<?php echo base_url();?>assets/images/tab-list-icon1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_my a:hover{background:url(<?php echo base_url();?>assets/images/tab-list-icon-active1.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_task1 a{background:url(<?php echo base_url();?>assets/images/task-ico-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_task a{background:url(<?php echo base_url();?>assets/images/task-ico.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_task a:hover{background:url(<?php echo base_url();?>assets/images/task-ico-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	
	.sx_comments_login_msg1 a{background:url(<?php echo base_url();?>assets/images/set-icon-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_msg a{background:url(<?php echo base_url();?>assets/images/set-icon.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#999;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	.sx_comments_login_msg a:hover{background:url(<?php echo base_url();?>assets/images/set-icon-active.png) 10px 0px no-repeat;width:44px; height:auto; display:inline-block;color:#38a3fd;text-decoration:none;padding-top:23px;font-size:12px; text-align:center;margin-top:20px;}
	
	.sx_hc_member_nav{width:310px; height:100%; position:fixed;z-index:99999997;right:0px; float:right;top:0; display:none;}
	.sx_hc_member_nav .sx_close{width:30px; float:left; height:100%;font-size:30px;color:#FFF;}
	.sx_hc_member_nav .sx_close a{color:#FFF; text-decoration:none;}
	
	.sx_comments_my_inner{float:left;width:236px; height:100%; background:#FFF; display:none;}
	.sx_comments_my_inner .sx_box_members_infos{width:100%; float:left; height:80px; text-align:center; padding-top:30px;}
	.sx_comments_my_inner .sx_box_members_infos .sx_plugins_avatar{width:80px;height:80px; margin:0 auto;}
	.sx_comments_my_inner .sx_box_members_infos .sx_avatar_fly{position:absolute;z-index:99999998; background:#000; height:80px; width:80px;color:#FFF; line-height:80px; border-radius:3px;filter:alpha(opacity=50);Opacity:0.5;cursor:pointer;display:none;}
	.sx_comments_my_inner .sx_box_members_infos .sx_plugins_avatar img{width:80px; height:80px;border-radius:3px;}
	.sx_plugins_nickname{width:180px;height:auto; margin:0 auto; text-align:center; padding-top:10px;}
	.sx_plugins_nickname a{ background:url(<?php echo base_url();?>assets/images/edit.png) right no-repeat;width:auto; display:inline-block; padding-right:30px; height:30px; line-height:30px; text-align:center;color:#000;text-decoration:none;font-size:12px;}
	.sx_plugins_nickname1{width:180px;height:auto; margin:0 auto; text-align:center; padding-top:10px; display:none;}
	.sx_plugins_nickname1 input{width:100px;border:none;border-bottom:#CCC 1px solid; height:24px; line-height:24px; padding-left:5px; padding-right:5px; outline:none; text-align:center;}
	.sx_plugins_nickname1 a{background:url(<?php echo base_url();?>assets/images/edit.png) 0px 0px no-repeat;width:20px;height:20px; display:inline-block;}
	.sx_plugins_counts{width:100%; float:left; height:auto;font-size:14px; padding-top:15px; border-bottom:#CCC 1px dashed}
	.sx_plugins_counts .sx_money{width:45%; float:left; padding-left:5%; text-align:left; line-height:40px;}
	.sx_plugins_counts .sx_money strong{color:#F00;}
	.sx_plugins_counts .sx_comments{width:45%; float:left; padding-right:5%; text-align:right; line-height:40px;}
	.sx_plugins_counts .sx_comments strong{color:#1859a5;}
	.sx_plugins_logout{width:100%; float:left; height:auto;font-size:14px; padding-top:15px;}
	.sx_plugins_logout a{width:150px; text-align:center; line-height:35px; display:inline-block; text-decoration:none; background:#CCC; border-radius:5px;color:#999;}
	.sx_plugins_logout a:hover{width:150px; text-align:center; line-height:35px; display:inline-block; text-decoration:underline; background:#000; border-radius:5px;color:#fff;}
	
	.sx_comments_task_inner{float:left;width:236px; height:100%; background:#FFF;overflow:auto;overflow-x:hidden;display:none;}
	.sx_comments_task_inner .sx_title{width:215px; float:left; padding-left:21px;font-size:20px; padding-top:20px;}
	.sx_comments_task_inner .sx_mys{width:215px; float:left; height:auto; text-align:left; padding-top:20px; padding-left:21px;}
	.sx_comments_task_inner #ch_doudou_text{width:180px;position:absolute;z-index:997; height:auto; padding:5px 5px 5px 5px; background:#FFF;-moz-box-shadow:2px 2px 2px 1px #888888;box-shadow: 2px 2px 2px 1px #888888;font-size:14px; line-height:28px; text-align:left; margin-left:20px; margin-top:40px;border-radius:3px; display:none;}
	.sx_comments_task_inner .sx_mys .sx_hc_changyandou{width:auto;display:inline-block; height:30px; line-height:30px; border:#f1a624 2px dotted; background:#fffaf0; padding-left:10px; padding-right:10px; border-radius:5px;color:#ffa912;}
	
	.sx_hc_changyandou_sm{width:185px; float:left; margin-left:21px; padding-top:20px;}
	.sx_hc_changyandou_sm ul{padding:0; margin:0;}
	.sx_hc_changyandou_sm ul li{ float:left;width:100%; border-bottom:#e4e4e4 1px solid; list-style:none; line-height:60px;font-size:14px;}
	.sx_hc_changyandou_sm ul li span{padding-left:20px; display:inline-block;color:#38a3fd;}
	
	.sx_comments_msg_inner{float:left;width:236px; height:100%; background:#FFF;overflow:auto;overflow-x:hidden;display:none;}
	.sx_comments_msg_inner .sx_title{width:215px; float:left; padding-left:21px;font-size:20px; padding-top:20px;}
	.sx_comments_msg_inner .sx_msg{width:185px; float:left;font-size:20px; padding-top:20px;font-size:12px; border-bottom:#e4e4e4 1px dashed; padding-bottom:15px; margin-left:21px;}
	.sx_comments_msg_inner .sx_msg a{color:#FFF;display:inline-block;width:auto; padding-left:5px; padding-right:5px; border-radius:10px; background:#F00; text-align:center; line-height:21px; text-decoration:none;}
	.sx_comments_msg_inner .sx_bars{width:185px; float:left; margin-left:21px;font-size:20px; padding-top:20px;font-size:12px;border-bottom:#e4e4e4 1px dashed; padding-bottom:15px;}
	.sx_comments_msg_inner .sx_bars .sx_delitem{display:inline-block;width:auto; padding-left:12px; padding-right:18px; background:#f00;color:#fff; display:inline-block; margin-left:5px;line-height:25px; text-decoration:none;border-radius:5px;}
	
	.sx_comments_msg_inner .sx_bars .sx_delall{display:inline-block;width:auto; padding-left:12px; padding-right:18px; background:#ccc;color:#e4e4e4; display:inline-block; margin-left:5px;line-height:25px; text-decoration:none;border-radius:5px;}
	
	.sx_comments_msg_inner .sx_msg_list{width:185px; float:left; margin-left:21px;font-size:20px; padding-top:5px;font-size:12px; padding-bottom:15px;}
	.sx_comments_msg_inner strong,.sx_comments_msg_inner a,.sx_comments_msg_inner span,.sx_comments_msg_inner label,.sx_comments_msg_inner .sx_a5,.sx_comments_msg_inner .sx_a6 ,.sx_comments_msg_inner .sx_a4 ,.sx_comments_msg_inner .sx_a7{font-size:12px;}
	.sx_comments_msg_inner .sx_msg_list ul{padding:0; margin:0;}
	.sx_comments_msg_inner .sx_msg_list ul li{ list-style:none; float:left;border-bottom:#e4e4e4 1px dashed; padding-bottom:12px; padding-top:12px;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a1{width:100%; float:left; height:auto;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a2{width:28px; float:left; height:40px;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a3{width:152px; float:left; height:auto;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a4{width:152px; float:left; text-align:left;color:#666;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a5{width:152px; float:left; text-align:left;line-height:25px;color:#999;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a6{width:152px; float:left; height:auto;line-height:22px;color:#333; margin-bottom:10px;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a7{width:144px; float:left; height:auto;line-height:22px;color:#999;border:#e4e4e4 1px dotted; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; border-radius:5px;}
	.sx_comments_msg_inner .sx_msg_list ul li .sx_a7 strong{color:#666;}
	#hs_forms_face_position{width:306px; height:auto; position:absolute;z-index:4; border:#4398ed 1px solid; background:#FFF;padding-left:9px;padding-bottom:9px; border-radius:10px; margin-top:30px; display:none;}
	#hs_forms_face_position ul{padding:0; margin:0; float:left;width:100%;}
	#hs_forms_face_position ul li{float:left;height:30px; line-height:30px;width:29px;padding-top:9px; text-align:center;} 
	#hs_forms_face_position ul li img{width:24px; height:24px; cursor:pointer;}
	.sx_hc_upload_file{border-top:#CCC 1px dotted; height:60px;float:left; width:295px; margin-top:15px;font-size:30px;padding-top:15px; padding-bottom:10px;}
	.sx_hc_upload_file .sx_hash{width:40px; height:40px;border:#e4e4e4 1px dotted; line-height:40px;float:left;text-align:center;font-size:28px;color:#CCC; cursor:pointer; margin-right:12px;}
	
	.sx_hs_forms_face_re_position{width:306px; height:auto; position:absolute;z-index:4; border:#4398ed 1px solid; background:#FFF;padding-left:9px;padding-bottom:9px; border-radius:10px; margin-top:30px; display:none; margin-left:10px; padding-top:12px; padding-bottom:12px;}
	.sx_hs_forms_face_re_position ul{padding:0; margin:0; float:left;width:100%;}
	.sx_hs_forms_face_re_position ul li{float:left;height:25px;height:25px; padding-right:9px; padding-top:9px;} 
	.sx_hs_forms_face_re_position ul li img{width:25px; height:25px; cursor:pointer;}	
	
	.sx_re_comments_textarea{width:100%; height:auto; float:left; padding-top:20px; padding-bottom:20px;}
	.sx_re_comments_textarea textarea{width:100%; height:110px; outline:none; border:#4398ed 1px solid; border-radius:12px; padding:8px 8px 8px 8px;color:#ccc;background:url(<?php echo base_url();?>assets/images/input_bg.png) center center no-repeat;resize:none;}
	.sx_re_comments_subs{width:100%; height:auto; float:left;}
	.sx_re_face_inner{width:40px; float:left; height:auto; padding-left:10px;}
	.sx_re_face_inner a{width:18px;height:18px;background: url(<?php echo base_url();?>assets/images/template/face_lan.jpg) no-repeat;display: inline-block;}
	.sx_re_face_inner a:hover{width:18px;height:18px;background: url(<?php echo base_url();?>assets/images/template/face_lan2.jpg) no-repeat;display: inline-block;}
	.sx_re_face_comments_btn{width:200px; float:right; height:auto; text-align:right;}
	.sx_re_face_comments_btn a{width: 102px;height: 30px;background: url(<?php echo base_url();?>assets/images/template/post-btn-lan.jpg) no-repeat;display: inline-block;}
	.sx_re_face_comments_btn a:hover{width: 102px;height: 30px;background: url(<?php echo base_url();?>assets/images/template/post-bt-lan2.jpg) no-repeat;display: inline-block;}
	
	.sx_hc_comments_re_item{width:100%;padding-left:5px;padding-right:5px; padding-top:5px; padding-bottom:5px;border:#e4e4e4 1px solid;float:left;height:auto; margin-bottom:15px; }
	.sx_hc_comments_re_item .sx_members_infos{width:100%; float:left; height:auto;}
	.sx_hc_comments_re_item .sx_members_infos .sx_nickname{width:100px; float:left; height:30px; line-height:30px;font-size:12px;color:#4398ed;}
	.sx_hc_comments_re_item .sx_members_infos .sx_nickname a{color:#4398ed;text-decoration:none;}
	.sx_hc_comments_re_item .sx_members_infos .sx_nickname a:hover{color:#4398ed;text-decoration:underline;}
	.sx_hc_comments_re_item .sx_members_infos .sx_star{width:200px; float:right; text-align:right;color:#999;}
	.sx_hc_comments_re_item .sx_re_contents{width:100%; float:left; height:auto; line-height:26px; padding-top:10px; padding-bottom:15px;}
	
	.sx_showCCcontents{padding-top:10px;}
	.sx_ieHacksBug{width:100%; float:left; height:auto;}
	
	
	.sx_re_sub_form_liness{width:100%;float:left;height:32px;}
	.sx_comments_re_button{width:100%;float:left;height:32px;text-align:right;display:none; }
	.sx_comments_re_button .sx_cai{width:auto;float:right;height:auto; margin-left:20px;}
	.sx_comments_re_button .sx_cai a{width:auto;height:30px; background:url(<?php echo base_url();?>assets/images/cai.png) 0px 4px no-repeat; display:inline-block;color:#999; text-decoration:none; padding-left:18px; padding-top:2px;}
	.sx_comments_re_button .sx_cai a:hover{background:url(<?php echo base_url();?>assets/images/cai-active.png) 0px 4px no-repeat;color:#4398ed;}
	.sx_comments_re_button .sx_clicked1{width:auto;height:30px; background:url(<?php echo base_url();?>assets/images/cai-active.png) 0px 4px no-repeat; display:inline-block;color:#4398ed; text-decoration:none; padding-left:18px; padding-top:2px;}
	
	.sx_comments_re_button .sx_ding{width:auto;float:right;height:auto; margin-left:20px;}
	.sx_comments_re_button .sx_ding a{width:auto;height:30px; background:url(<?php echo base_url();?>assets/images/ding.png) 0px 4px no-repeat; display:inline-block;color:#999; text-decoration:none; padding-left:19px; padding-top:2px;}
	.sx_comments_re_button .sx_ding a:hover{background:url(<?php echo base_url();?>assets/images/ding-active.png) 0px 4px no-repeat;color:#4398ed;}
	.sx_comments_re_button .sx_clicked2{width:16px;height:30px; background:url(<?php echo base_url();?>assets/images/ding-active.png) 0px 4px no-repeat; display:inline-block;color:#4398ed; text-decoration:none; padding-left:12px; padding-top:2px;}
	
	.sx_comments_re_button .sx_res{width:auto;float:right;height:auto;line-height:25px; display:inline-block;}
	.sx_comments_re_button .sx_res a{font-size:12px; text-decoration:none;color:#ccc;}
	.sx_comments_re_button .sx_res a:hover{font-size:12px; text-decoration:none;color:#4398ed;}
	
	.sx_re_comments_forms{float:left;width:100%; height:auto; display:none;}
	.sx_re_comments_forms_input{width:100%; float:left; height:auto;}
	.sx_re_comments_forms_input textarea{width:100%; height:110px; outline:none; border:#4398ed 1px solid; border-radius:12px; padding:8px 8px 8px 8px;color:#ccc;background:url(<?php echo base_url();?>assets/images/input_bg.png) center center no-repeat;resize:none;}
	.sx_re_comments_forms_subs1{width:100%; float:left; height:auto;padding-top:20px;}
	.sx_re_comments_forms_subs1 .sx_re_face_inner1{width:40px;float:left; height:auto;}
	.sx_re_comments_forms_subs1 .sx_re_face_inner1 a{width:18px;height:18px;background: url(<?php echo base_url();?>assets/images/template/face_lan.jpg) no-repeat;display: inline-block;}
	.sx_re_comments_forms_subs1 .sx_re_face_comments_btn1{width:200px; float:right; height:auto; text-align:right;}
	.sx_re_face_comments_btn1 a{width: 102px;height: 30px;background: url(<?php echo base_url();?>assets/images/template/post-btn-lan.jpg) no-repeat;display: inline-block;}
	.sx_re_face_comments_btn1 a:hover{width: 102px;height: 30px;background: url(<?php echo base_url();?>assets/images/template/post-btn-lan2.jpg) no-repeat;display: inline-block;}
	.sx_hs_forms_face_re_position1{width:306px; height:auto; position:absolute;z-index:4; border:#4398ed 1px solid; background:#FFF;padding-left:9px;padding-bottom:9px; border-radius:10px; margin-top:40px; display:none; margin-left:0px; padding-top:12px; padding-bottom:12px;}
	.sx_hs_forms_face_re_position1 ul{padding:0; margin:0; width:100%;}
	.sx_hs_forms_face_re_position1 ul li{float:left;height:30px; line-height:30px;width:29px;text-align:center;} 
	.sx_hs_forms_face_re_position1 ul li img{width:24px; height:24px; cursor:pointer;}	
	
	.sx_hc_comments_re_maopao{width:100%; float:left; height:auto;}
	
	.sx_comments_button .sx_gaizhang{width:auto;float:right;padding-left:5px;padding-top:3px;}	
	.sx_comments_button .sx_gaizhang a{width:21px;height:25px; background:url(<?php echo base_url();?>assets/images/prop-ico.png) no-repeat 0px 2px; display:inline-block;}
	
	.sx_comments_button .sx_caiyicai{width:auto;float:right;padding-left:5px; padding-right:15px;padding-top:5px;}
	.sx_comments_button .sx_caiyicai a{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/cai.png) 0px 2px no-repeat; display:inline-block; padding-left:20px; text-decoration:none;color:#999;}
	.sx_comments_button .sx_caiyicai a:hover{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/cai-active.png) 0px 2px no-repeat; display:inline-block; padding-left:20px; text-decoration:none;color:#4398ed;}
	.sx_comments_button .sx_caiyicai .sx_clicked1{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/cai-active.png) 0px 2px no-repeat; display:inline-block; padding-left:20px; text-decoration:none;color:#4398ed;}
	
	.sx_comments_button .sx_dingding{width:auto;float:right;padding-left:5px; padding-right:15px; position:relative; padding-top:5px;}
	.sx_comments_button .sx_dingding a{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/ding.png) 0px 2px no-repeat; display:inline-block;text-decoration:none;color:#999;padding-left:20px;}
	.sx_comments_button .sx_dingding a:hover{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/ding-active.png) 0px 2px no-repeat; display:inline-block;text-decoration:none;color:#4398ed;padding-left:20px;}
	
	.sx_comments_button .sx_dingding .sx_clicked1{width:auto;height:25px; background:url(<?php echo base_url();?>assets/images/ding-active.png) 0px 2px no-repeat; display:inline-block;text-decoration:none;color:#4398ed;padding-left:20px;}
	
	.sx_comments_button .sx_retext{width:auto;float:right;padding-left:5px; padding-right:15px; padding-top:7px;}
	.sx_comments_button .sx_retext a{font-size:12px; text-decoration:none;color:#666;}
	.sx_comments_button .sx_retext a:hover{font-size:12px; text-decoration:none;color:#4398ed;}
	
	.sx_re_comments_inner{ display:none;}
	
	.sx_comments_img_lists{width:100%; float:left; height:auto; padding-top:15px;}
	.sx_comments_img_lists ul{padding:0; margin:0;padding-bottom:5px; float:left;}
	.sx_comments_img_lists ul li{ float:left; padding-right:10px; height:auto;}
	.sx_comments_img_lists ul li img{width:60px;height:60px; border:#e4e4e4 1px solid; }
	.sx_comments_img_lists .sx_img_zooms{width:100%; float:left; height:auto; background:#f5f5f5; display:none;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars{width:180px; padding-left:20px; padding-top:15px;color:#ccc;font-size:12px;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars .sx_shouqilai a{width:auto; background:url(<?php echo base_url();?>assets/images/pack-up.png) 0px 2px no-repeat; height:20px; padding-left:18px;font-size:12px; text-decoration:none;color:#999; display:inline-block;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars .sx_shouqilai a:hover{width:auto; background:url(<?php echo base_url();?>assets/images/pack-up-active.png) 0px 2px no-repeat; height:20px; padding-left:18px;font-size:12px; text-decoration:none;color:#999; display:inline-block;color:#4398ed;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars span{display:inline-block; padding-left:10px; padding-right:10px;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars .sx_yuantulook a{width:auto; background:url(<?php echo base_url();?>assets/images/look-img.png) 0px 2px no-repeat; height:20px; padding-left:16px;font-size:12px; text-decoration:none;color:#999;display:inline-block;}
	.sx_comments_img_lists .sx_img_zooms .sx_bars .sx_yuantulook a:hover{width:auto; background:url(<?php echo base_url();?>assets/images/look-img-active.png) 0px 2px no-repeat; height:20px; padding-left:16px;font-size:12px; text-decoration:none;color:#999;display:inline-block;color:#4398ed;}
	.sx_imgzoomshow{width:100%; float:left; padding-top:20px; text-align:center; padding-bottom:40px;}
	.sx_imgzoomshow img{max-width:70%; height:auto; display:inline-block;}
	
	#youSelfInfoBtn{ display:none;}
	#mySelfInfoBtn{ display:none;}
	
	.sx_comments_you_inner{float:left;width:236px; height:100%; background:#FFF; display:none;}
	.sx_comments_you_inner .sx_box_members_infos{width:100%; float:left; height:auto; text-align:center; padding-top:30px;}
	.sx_comments_you_inner .sx_box_members_infos .sx_plugins_avatar{width:100%;height:auto;text-align:center; padding-top:10px; float:left;}
	.sx_comments_you_inner .sx_box_members_infos .sx_plugins_avatar img{width:80px; height:80px;border-radius:3px;}
	.sx_comments_you_inner .sx_box_members_infos .sx_plugins_nickname1{width:100%;height:auto;text-align:center; padding-top:10px; float:left;}
	.sx_yourNickname{width:100%; float:left; height:auto; line-height:40px; text-align:center;font-weight:bold;color:#F00;font-size:14px;}
	.sx_youOtherInfo{width:100%; float:left; height:40px; line-height:40px; border-bottom:#e4e4e4 1px solid;font-size:12px;}
	.sx_youOtherInfo .sx_lf{width:46%; float:left; text-align:left; padding-left:4%;color:#666;}
	.sx_youOtherInfo .sx_rt{width:46%; float:left; text-align:left; padding-left:4%;color:#666;}
	.sx_youOtherInfo .sx_rt span{color:#ccc;}
	
	.sx_msgCountShow{position:absolute;z-index:99999999;background:#F00;width:auto;height:22px;text-align:center;border-radius:50%;color:#FFF;font-size:8px;line-height:22px;min-width:22px;margin-left:28px;margin-top:5px; display:none;}
	
	.sx_msgNextBtn{width:100%; float:left; text-align:center; padding-top:18px;display:none; height:auto; display:inline-block;}
	.sx_msgNextBtn a{width:150px; border:#e4e4e4 1px solid;border-radius:5px; display:inline-block; height:26px; line-height:26px;color:#CCC; text-decoration:none;}
	.sx_msgNextBtn a:hover{width:150px; border:#e4e4e4 1px solid;border-radius:5px; display:inline-block; height:26px; line-height:26px;color:#ccc; text-decoration:none; background:#999;}
	
	.sx_msgNoBtn{width:100%; float:left; text-align:center; padding-top:18px; height:auto; display:none; display:inline-block;}
	.sx_msgNoBtn a{width:150px; border:#e4e4e4 1px solid;border-radius:5px; background:#f4f4f4;display:inline-block; height:26px; line-height:26px;color:#CCC; text-decoration:none;display:none;}
	
	
	.sx_comments_yin{position:relative;float:right;margin-right:242px; background:#FFF; display:none;}
	.sx_comments_yin a{color:#666; text-decoration:none;}
	.sx_comments_yin_box{width:240px; border:#CCC 1px solid;border-radius:5px; height:88px; background:#FFF; position:absolute;z-index:20; margin-top:-100px;}
	.sx_comments_yin_box .sx_left-bar{position:absolute;z-index:21; margin-top:25px;}
	.sx_comments_yin_box .sx_left-bar a{height:40px; line-height:40px;width:16px;color:#FFF;font-size:18px; background:#000; border-top-right-radius:4px;border-bottom-right-radius:4px; text-align:center;filter:alpha(opacity=10);Opacity:0.1;display:inline-block; text-decoration:none;}
	.sx_comments_yin_box .sx_left-bar a:hover{height:40px; line-height:40px;width:16px;color:#FFF;font-size:18px; background:#000; border-top-right-radius:4px;border-bottom-right-radius:4px; text-align:center;filter:alpha(opacity=40);Opacity:0.4;display:inline-block; text-decoration:none;}
	.sx_comments_yin_box .sx_right-bar{position:absolute;z-index:21; margin-top:25px; margin-left:224px;}
	.sx_comments_yin_box .sx_right-bar a{height:40px; line-height:40px;width:16px;color:#FFF;font-size:18px; background:#000; border-top-left-radius:4px;border-bottom-left-radius:4px; text-align:center;filter:alpha(opacity=10);Opacity:0.1;display:inline-block; text-decoration:none;}
	.sx_comments_yin_box .sx_right-bar a:hover{height:40px; line-height:40px;width:16px;color:#FFF;font-size:18px; background:#000; border-top-left-radius:4px;border-bottom-left-radius:4px; text-align:center;filter:alpha(opacity=40);Opacity:0.4;display:inline-block; text-decoration:none;}
	.sx_comments_yin_lists{padding-left:10px; padding-right:10px;width:238px;text-align:left;white-space:nowrap; display:inline-block;overflow:hidden; position:absolute;left:0;}
	.sx_comments_yin_lists .sx_zhang_ul{margin:0; padding:0;}
	.sx_comments_yin_box .sx_zhang_li{height:auto;display:inline-block; padding-top:10px; width:56px;}
	.sx_comments_yin_box .sx_zhang_li .sx_imgs{width:50px; height:45px;text-align:center;float:left;}
	.sx_comments_yin_box .sx_zhang_li .sx_inters{border:#e4e4e4 1px solid; height:22px; line-height:22px;width:38px; text-align:center;font-size:12px; margin-left:6px; margin-right:6px; float:left;}	
	
	.sx_commentsNickNm{position:absolute;height:auto;z-index:3;width:auto;}
	.sx_yinyins{position:absolute;height:auto;z-index:2;width:auto; padding-top:15px;}
	.sx_yinyins img{filter:alpha(opacity=80);Opacity:0.8;margin-left:5px; margin-top:5px;}
	
	.sx_commentsPageMore{width:100%; float:left; text-align:center; height:auto; padding-top:20px; display:none;}   
	.sx_commentsPageMore a{width:100%; float:left; background:#f4f4f4; height:35px; line-height:35px; border-bottom:#d1d1d1 1px solid; display:inline-block; text-decoration:none;color:#999;}     
	.sx_commentsPageLoad{width:100%; float:left; text-align:center; height:auto; padding-top:20px;display:none;}   
	.sx_commentsPageLoad a{width:100%; float:left; background:#f4f4f4; height:35px; line-height:35px; border-bottom:#d1d1d1 1px solid; display:inline-block; text-decoration:none;color:#ccc;}  
	.sx_commentsPageEnd{width:100%; float:left; text-align:center; height:auto; padding-top:20px;display:none;}   
	.sx_commentsPageEnd a{width:100%; float:left; background:#f4f4f4; height:35px; line-height:35px; border-bottom:#d1d1d1 1px solid; display:inline-block; text-decoration:none;color:#ccc;}      
		
	.sx_commentsAll a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsNoChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsAll a label{color:#333;cursor:pointer;}
	
	.sx_commentsAll1 a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsAll1 a label{color:#333;cursor:pointer;}
	
	.sx_commentsBest{margin-left:10px; display:inline-block;}
	.sx_commentsBest a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsNoChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsBest a label{color:#333;cursor:pointer;}
	
	.sx_commentsBest1{margin-left:10px; display:inline-block;}
	.sx_commentsBest1 a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsBest1 a label{color:#333;cursor:pointer;}
	
	.sx_commentsMedium{margin-left:10px; display:inline-block;}
	.sx_commentsMedium a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsNoChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsMedium1{margin-left:10px; display:inline-block;}
	.sx_commentsMedium a label{color:#333;cursor:pointer;}
	.sx_commentsMedium1 a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsMedium1 a label{color:#333;cursor:pointer;}
	
	.sx_commentsNegative{margin-left:10px; display:inline-block;}
	.sx_commentsNegative a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsNoChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsNegative a label{color:#333;cursor:pointer;}
	.sx_commentsNegative1{margin-left:10px; display:inline-block;}
	.sx_commentsNegative1 a{color:#999; text-decoration:none; display:inline-block;width:auto; background:url(<?php echo base_url();?>assets/images/commentsChoose.png) 0px 9px no-repeat; padding-left:16px; padding-right:10px; line-height:30px; height:30px;font-size:13px;}
	.sx_commentsNegative1 a label{color:#333;cursor:pointer;}	

	.sx_loginFormDiv{position:fixed;z-index:99999999; background:#fff; border:#e4e4e4 1px solid; min-height:500px; max-width:1000px; width:100%;top:0px; float:left; height:100%; display:none;}
	.sx_loginFormDiv .sx_topBar{width:100%; float:left; text-align:left; height:40px; border-bottom:#CCC 1px solid; background:#f4f4f4;}
	.sx_loginFormDiv .sx_topBar .sx_otherLoginTitle{float:left; width:140px; text-align:left; line-height:40px; padding-left:15px;font-size:16px;}
	.sx_loginFormDiv .sx_topBar .sx_otherLoginclose{float:right; text-align:right; padding-right:15px; line-height:40px;}
	.sx_loginFormDiv .sx_topBar .sx_otherLoginclose a{width:30px;height:30px; display:inline-block; text-decoration:none;color:#999;}
	.sx_loginFormIframe{width:100%; height:auto;font-size:14px;}
	.sx_loginFormIframe iframe{ border:none; overflow:hidden;width:100%;height:400px; float:left;}	
	
	
	*{ margin:0; padding: 0;}
	li,ul{ list-style: none;}
	.sx_plbox{max-width:620px; min-width:310px;margin: 0 auto; overflow: hidden; font-family: "微软雅黑";}
	.sx_plbox>ul>span>li,.sx_plbox .sx_spansss>li{ padding: 4% 0 3%; border-bottom: 8px #f5f6f6 solid; overflow: hidden;}
	.sx_plbt{ overflow: hidden; margin-left: 2.4%;}
	.sx_pltx{width: 40px; height:40px; border-radius:50%; float: left; margin-right: 2%;}
	.sx_mz{  float: left; font-size:14px; margin-top:2.4%; color: #4398ed; width:25%}
	.sx_plri{ float: right;margin-top:2.4%; width: 58%; }
	.sx_plri span{ text-align: right; display: block;}
	.sx_plri span img{ margin: 0% 0%;}
	.sx_plri i{ color: #b0adad; font-size: 14px; margin-left: 2.2%; float: right; font-style: normal;}
	.sx_plcont{ padding-bottom:3.5% ; border-bottom:1px #f5f6f6  dashed}
	.sx_plcont p{ font-size: 16px; line-height:1.75; color: #555; overflow: hidden; clear: both; margin: 2.4% 0 1% 2.4%;}
	.sx_plcont>p>a{ display: block; overflow: hidden;}
	.sx_plcont p a img{ width: 170px; float: left; margin-right: 1%; height: 113px;}
	.sx_click{ width: 100%; overflow:hidden; text-align: right;}
	.sx_click span{ color: #b2b2b2; padding-left: 1%; vertical-align:middle;}
	.sx_pl{ margin-right: 2.4%; margin-left: 9.6%; width:18px; height:18px}
	.sx_zan{ width:18px; height:18px;}
	.sx_plhf{width: 100%; height: auto; }
	.sx_plhf>div{ overflow: hidden; line-height:1.75;font-size: 16px; margin-left: 2.4%; color: #555;   }
	.sx_plhf>div:first-child{  margin-top: 3.5%;}
	.sx_plhf>div> .sx_plhfart{ float: left;}
	.sx_plhfart a{ color: #4398ed; font-size: 16px; text-decoration: none;}
	.sx_plhf>div p{  color: #555; font-size: 16px;}
	.sx_plhf>div>img{  position: relative; right: 0.4%; bottom: 20px; float: right;}
	.sx_plreply{ width: 96%; margin: 2% auto 0; overflow: hidden; display:none;}
	.sx_plreply>p{ margin:0 0 0 2.4% !important}
	.sx_plreply>p img{ float: left !important; width:18px !important; height:18px !important;}
	.sx_plreply>p a{ margin-bottom:0 !important}
	.sx_reply1{ width: 98%; border: 1px #4398ed solid; border-radius:5px;  height: 80px;font-size: 16px; color: #ccc; font-family: "微软雅黑"; padding-left: 5px; padding-top: 0;     margin-bottom: 3%;} 
	.sx_reply2{ color: #fff; background-color: #4398ed; border-radius:4px; width: 12%; padding: 1% 0; font-size:16px; float: right; border: 0;font-family: "微软雅黑";}
	

	
	
</style>
