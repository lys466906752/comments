<script>
	
    function showOrHideRe(id)
    {
		if(document.getElementById('sx_reply_' + id).style.display=='block')
		{
    		$('#sx_reply_' + id).hide();
		}
		else
		{
			$('#sx_reply_' + id).show();	
		}
   	}
	
	var praiseAll=''; 
	
	function addPraise(id)
	{
		if(praiseAll!='' && praiseAll.indexOf('{' + id + '}')>=0)
		{
			layer.open({
				content: "您已点赞，无需重复操作！"
				,skin: 'msg'
				,time: 2
			});	
		}	
		else
		{
			if(members_info=='')
			{
				hc_login_show();	
			}
			else
			{
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
							var cai=$("#praiseInner_" + id).html().replace(/(^\s*)|(\s*$)/g,"");
							cai=parseInt(cai)+1;
							$('#praiseInner_' +  + id).html(cai);
							praiseAll=praiseAll + '{' + id + '}';
						}
						else if(data.code==200)
						{
							hc_login_show();
						}
						else if(data.code==400 || data.code==300)
						{
							layer.open({
							content: data.show
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
	}
	
	function subReplyItem(id)
	{
		subReplyItemDo(id,0,0);
	}
	
	function subReItemOne(id,aid)
	{
		subReplyItemDo(aid,id,0);	
	}
	
	function subReItemTow(id,aid,upid)
	{
		subReplyItemDo(aid,id,upid);	
	}
	
	function subReplyItemDo(id,sendId,upid)
	{
		var contents='';
		if(sendId==0)
		{
			contents=$('#replyItem_' + id).val().replace(/(^\s*)|(\s*$)/g,"");	
		}	
		else
		{
			contents=$('#sxTow_' + sendId + 'b_c' + id).val().replace(/(^\s*)|(\s*$)/g,"");		
		}
		
		if(contents=='')
		{
			layer.open({
				content: '请说点什么吧！'
				,skin: 'msg'
				,time: 2
			});		
		}
		else if(contents.length>100)
		{
			layer.open({
				content: '您说的话有点多，请精简点吧！'
				,skin: 'msg'
				,time: 2
			});		
		}
		else
		{
			if(insert_do==1)
			{
				insert_do=2;
				var comments_csrf=$("#comments_csrf").val().replace(/(^\s*)|(\s*$)/g,"");
				var comments_sid=$("#comments_sid").val().replace(/(^\s*)|(\s*$)/g,"");
				$.ajax({  
					url : "<?php echo base_url();?>index.php/comments/resave",  
					dataType:"jsonp",  
					data:{  
					   "comments_sid":comments_sid,
					   "comments_csrf":comments_csrf,
					   "id":id,
					   'sendId':sendId,
					   'contents':contents,
					   'upid':upid,
					},  
					type:"GET",  
					jsonp:"jsonpcallback",  
					timeout: 6000,  
					success:function(data){
						insert_do=1;
						if(data.code==100)
						{
							  layer.open({
								content: '亲：发表成功啦！'
								,skin: 'msg'
								,time: 2
							  });
							  
							  showNewItems(id);
							  
							if(sendId==0)
							{
								$('#sx_face_box_' + id).hide(); 
								$('#replyItem_' + id).val("");	 
							}
							else
							{
								$('#sxTowHtml_' + sendId + 'b_c' + id).hide();
								$('#sxTow_' + sendId + 'b_c' + id).val("");	
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
			else
			{
				layer.open({
				content: '亲，系统太忙，稍等片刻吧！'
				,skin: 'msg'
				,time: 2
				});	
			}
		}
	}
	
	function showFaceDiv(id)
	{
		$('#sx_face_box_' + id).show();
	}
	
	function createFaceHtml(id)
	{
		var Jsons='<?php echo $faceStr;?>';
		arr=Jsons.split('====');
		var returnStr='';
		var returnStart='<div class="sx_hs_forms_face_re_position1" id="sx_face_box_' + id + '" ><ul>';
		var returnEnd='</ul></div>';
		for(var i=0;i<arr.length;i++)
		{
			array=arr[i].split('____');
			returnStr=returnStr + '<li><img src="<?php echo base_url();?>' + array[1] + '" onClick=inserttag_rere("[' + array[0] + '","]","' + id + '")></li>';	
		}
		
		return returnStart + returnStr + returnEnd;
	}
	
	function createFaceHtmlOne(id,aid)
	{
		var Jsons='<?php echo $faceStr;?>';
		arr=Jsons.split('====');
		var returnStr='';
		var returnStart='<div class="sx_hs_forms_face_re_position1" id="sx_face_box_' + id + '_one_' + aid + '" ><ul>';
		var returnEnd='<div style=\'clear:both\'></div></ul></div>';
		for(var i=0;i<arr.length;i++)
		{
			array=arr[i].split('____');
			returnStr=returnStr + '<li><img src="<?php echo base_url();?>' + array[1] + '" onClick=inserttag_reOne("[' + array[0] + '","]","' + id + '","' + aid + '")></li>';	
		}
		
		return returnStart + returnStr + returnEnd;
	}
	
	function inserttag_reOne(topen,tclose,id,aid)
	{
		var themess = document.getElementById('sxTow_' + id + 'b_c' + aid);
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
	
	function showReInputs(id,aid)
	{
		if(document.getElementById('sxTowHtml_' + id + 'b_c' + aid).style.display!='block')
		{
			$('#sxTowHtml_' + id + 'b_c' + aid).show();		
		}
		else
		{
			$('#sxTowHtml_' + id + 'b_c' + aid).hide();
		}
	}
	
	function showFaceOne(id,aid)
	{
		$('#sx_face_box_' + id + '_one_' + aid).show();		
	}
	
	function createReItem(obj)
	{
		var returnHtml='';
		for(var i=0;i<obj.length;i++)
		{
			returnHtml=returnHtml + '<div><article class="sx_plhfart"><a href="javascript:show_members_infos(\'' + obj[i].uid + '\');">' + obj[i].uname + '</a>' + createOfficial(obj[i].official) + '：</article><p>' + obj[i].fulltext + ' </p><img src="<?php echo base_url();?>assets/images/sxpl.png" class="sx_pl" alt="" onclick="showReInputs(\'' + obj[i].id + '\',\'' + obj[i].aid + '\')" /></div><div class="sx_plreply" id="sxTowHtml_' + obj[i].id + 'b_c' + obj[i].aid + '"><textarea placeholder="就医体验如何？把感受告诉更多人"  class="sx_reply1" id="sxTow_' + obj[i].id + 'b_c' + obj[i].aid + '"/></textarea>' + createFaceHtmlOne(obj[i].id,obj[i].aid) + '<p><a href="javascript:showFaceOne(\'' + obj[i].id + '\',\'' + obj[i].aid + '\');"><img src="<?php echo base_url();?>assets/images/face.png" alt="" /></a><input type="submit" value="发表" class="sx_reply2" onclick="subReItemOne(\'' + obj[i].id + '\',\'' + obj[i].aid + '\')" /></p></div>';	
			var htmlRes=createReItemEnd(obj[i].reText);
			returnHtml=returnHtml + htmlRes;			
		}	
		
		return returnHtml;
	}
	
	function createOfficial(type)
	{
		if(type==2)
		{
			return '&nbsp;&nbsp;<img src="<?php echo base_url();?>assets/images/guanfang.jpg">&nbsp;';	
		}	
		return '';
	}
	
	function createReItemEnd(obj)
	{
		var returnHtml='';
		for(var i=0;i<obj.length;i++)
		{
			returnHtml=returnHtml + '<div><article class="sx_plhfart"><a href="javascript:show_members_infos(\'' + obj[i].uid + '\');">' + obj[i].uname + '</a> ' + createOfficial(obj[i].official) + ' <span> 回复 </span><a href="javascript:show_members_infos(\'' + obj[i].rid + '\');">' + obj[i].rname + '</a>：</article><p>' + obj[i].fulltext + ' </p><img src="<?php echo base_url();?>assets/images/sxpl.png" class="sx_pl" alt="" onclick="showReInputs(\'' + obj[i].id + '\',\'' + obj[i].aid + '\')" /></div><div class="sx_plreply" id="sxTowHtml_' + obj[i].id + 'b_c' + obj[i].aid + '"><textarea placeholder="就医体验如何？把感受告诉更多人"  class="sx_reply1" id="sxTow_' + obj[i].id + 'b_c' + obj[i].aid + '"/></textarea>' + createFaceHtmlOne(obj[i].id,obj[i].aid) + '<p><a href="javascript:showFaceOne(\'' + obj[i].id + '\',\'' + obj[i].aid + '\');"><img src="<?php echo base_url();?>assets/images/face.png" alt="" /></a><input type="submit" value="发表" class="sx_reply2" onclick="subReItemTow(\'' + obj[i].id + '\',\'' + obj[i].aid + '\',\'' + obj[i].upid + '\')" /></p></div>';			
		}	
		
		return returnHtml;	
	}
	
	function bigImgShow(url)
	{
		$("#zoomImageInner").html('<img src="' + url + '" style="max-width:600px;min-width:300px;max-height:450px;min-height:100px;" />');
		whileBigImgDo();
	}
	
	function whileBigImgDo()
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

		if(document.getElementById("zoomsShow").style.display!="block")
		{
			$("#zoomsShow").show();
		}

		var div_h=document.getElementById("zoomsShow").offsetHeight;
		var div_w=document.getElementById("zoomsShow").offsetWidth;
		
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
		
		
		document.getElementById("zoomsShow").style.left=parseInt(web_width-div_w)/2 + "px";
		document.getElementById("zoomsShow").style.top=parseInt((web_height-div_h))/2 + "px";
		
		document.body.style.overflow="auto";
	
	}
</script>