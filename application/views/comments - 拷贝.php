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
<meta name="renderer" content="webkit">
<?php
	require 'comments.js.php';
	require 'comments.css.php';
?>
</head>


<div style="clear:both;"></div>     
    <div class="hs_comments" >

		<div class="hs_comments_center_pad" >
        <div class="hs_box">
    
       
            <div class="hs_forms">
                <div class="hs_forms_login_avatar" onClick="hc_login_state_show();"></div>
                <div class="hs_forms_login_nickname"></div>
                <div class="hs_forms_login" onClick="hc_login_show();">登录</div>
                <div class="hs_forms_login_down"></div>
                <div class="hs_forms_login_down_bg"></div>
            </div>
            
            <div class="input">
                <textarea id="csrf_input_index" onFocus="clear_input_index();" onBlur="rev_input_index();">有事没事说两句...</textarea>
                <input type="hidden" id="comments_csrf" name="comments_csrf" value="<?php echo get_csrfToken($this->encrypt,$this->session);?>" >
                <input type="hidden" id="comments_sid" name="comments_sid" value="<?php echo $comments_sid;?>">
            </div>
     
            <div class="hs_box">
                <div class="hs_forms_face">
                    <div id="hs_forms_face_position">
                        <ul>
                        <?php
                            foreach($face->result_array() as $faces)
                            {
                        ?>
                            <li><img src="<?php echo base_url().$faces['file'];?>" onClick="inserttag('[<?php echo $faces['name'];?>',']');"></li>
                        <?php
                            }
                        ?>
                        </ul>
                        <div class="hc_upload_file"> 
                                        
                        <span onClick="upload_comments_file_a();" class="hash">+</span>  
                        
                        <label id="upload_success_inners">
                        
                        </label>
                        </div>
                    </div>
                    <a href="javascript:hc_comments_show_face();"></a>
                </div>
                <div class="comments_submit">
                
                    <a href="javascript:hc_comments_sub();"></a>
                
                </div>
                
                
                
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
       
    
    	<div class="hs_comments_lists">
    
                <div class="item_title"> 评 论 </div>
    
                <div class="item_line">
                    
                    <strong><?php echo $comments_join;?></strong> 人参与 ， <strong id="commentAllInner"><?php echo $comments_counts;?></strong> 条评论
    
                </div>             

                <div class="hs_comments_start">
                      <span class="commentsAll1" id="commentsAlls"><a href="javascript:readCommentsSelect(1);">全部 <label id="commentsAll"><?php echo $res['counts'];?></label></a></span>
                      <span class="commentsBest" id="commentsBests"><a href="javascript:readCommentsSelect(2);">好评 <label id="commentsBest"><?php echo $res['best'];?></label></a></span> 
                      <span class="commentsMedium" id="commentsMediums"><a href="javascript:readCommentsSelect(3);">中评 <label id="commentsMedium"><?php echo $res['medium'];?></label></a></span> 
                      <span class="commentsNegative" id="commentsNegatives"><a href="javascript:readCommentsSelect(4);">差评 <label id="commentsNegative"><?php echo $res['negative'];?></label></a></span>  
                </div>
    
                <div class="hs_box">
                	<ul class="commentsListAll">
                    	<span id="comments_page_new"></span>
                    	<span id="comments_page_1">
                   		</span>
                	</ul>
       
                    <span class="commentsPageMore">
                    	<a href="javascript:jsonpReadComments();"> 点 击 加 载 更 多 </a>
                    </span>
                    
                    <span class="commentsPageLoad">
                    	<a href="javascript:void(0);" style=""> 正 在 加 载 数 据 ， 请 稍 等 ... </a>
                    </span>
                    
                    <span class="commentsPageEnd">
                    	<a> 没 有 更 多 数 据 了 哦 </a>
                    </span>
            </div>
            	
    
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
                <td align="right"><span style="float:left; padding-left:3px;"><input type="password" placeholder="密码" id="comments_login_passwd"></span></td>
                <td align="left" class="get_passwds" style="padding-right:5px;"><a href="javascript:comments_get_passwd();">获取新密码</a></td>
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
                    <a href="javascript:qqLogin();"></a>
                </span>
                <span class="sina">
                    <a href="javascript:sinaLogin();"></a>
                </span>
                <span class="phone">
                    <a href="javascript:void();"></a>
                </span>
            </div>
            <div class="comments_login_history">
                登录过的用户请沿用之前的登录方式
            </div>
        </div>
    </div>
    
    
    <div class="hc_member_nav">
    
        <div class="close"><a href="javascript:close_hc_login_box();">×</a></div>
        
        <div style="width:44px; float:left; height:100%; background:#000;">
    
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;">
              <tr>
              <td valign="top" style="padding-top:20px;">
					<label id="youSelfInfoBtn">
                    	<span class="comments_login_my1">
                        	<a>我的</a>
                        </span>
                    </label>
              		<label id="mySelfInfoBtn">
                        <span class="comments_login_my1" id="comments_login_my">
                        	<a href="javascript:ch_show_my();">我的</a>
                        </span>
                        <span class="comments_login_task" id="comments_login_task">
                        	<a href="javascript:ch_show_task();">任务</a> 
                        </span>
                        
                        <span id="comments_login_msg" class="comments_login_msg">
                        
                        	<div class="msgCountShow">  </div>
                            
                        	<a href="javascript:ch_show_msg();">消息</a>    
                            
                        </span>
                    </label>
                </td>
              </tr>
              <tr>
                <td align="center" valign="bottom"  style="color:#FFF;padding-bottom:10px;color:#999;text-align:center;">军颐</td>
              </tr>
            </table>
        </div>
        
        <div class="comments_you_inner">
            <div class="box">
                <div class="plugins_avatar">
                    <img id="member_avatars1">
                </div>
                <div class="yourNickname"></div>
                <div class="youOtherInfo">
                	<div class="lf">回复：<strong id="youCommentsCounts"></strong> 条</div>
                    <div class="rt">活跃：<span id="youEndTimeShow">刚刚</span></div>
                </div>
                
            </div>
        </div>
        
        <div class="comments_my_inner">
            <div class="box">
                <div class="plugins_avatar" onClick="show_avatar_window();">
                    <div class="avatar_fly">
                        <div style="width:80px;height:80px;line-height:80px; text-align:center;color:#FFF;font-size:18px;cursor:pointer;">
                            修改头像
                        </div>
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
            
            <div class="bars"><input type="checkbox" onClick="choose_hc_msg_all();"  name="hc_sx" > <a href="javascript:deleteMsg();"> 删 除 </a></div>
            
            <div class="msg_list">
                <ul id="msgPageInner">
                
                </ul>


                <span class="msgNextBtn"><a href="">点击加载下一页</a></span>
                
                <span class="msgNoBtn"><a>没数据啦...</a></span>
            </div>
        </div>
    
 
    
    </div>
<div style="clear:both;"></div> 
</html>