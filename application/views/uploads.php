<html lang="en-US" manifest=""><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Expires" content="-1">
<title>上传图片</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="<?php echo base_url();?>assets/css/show.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/layer_pc/layer.js"></script>
<style type="text/css">
body,td,th {
	font-family: "微软雅黑";
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

</style>
<script>

	var uploads=0;
	
	var userAgent=1;
	
	if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
		try{
			if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
				var userAgent=2;
			}
		}catch(e){}
	}
	
	function choose_file()
	{
		$("#files").click();	
	}
	
	function sub_upload()
	{
		if(userAgent==1)
		{
			if(uploads==0)
			{
				var z=0;
				$("#quanxian label").each(function(){
					z=parseInt(z)+1;
				});
				if(z<5)
				{
					document.form1.submit();	
				}
				else
				{
					alert('最多允许上传3张！');	
				}
				
				
			}
		}
	}
	
	var imgs='';
	var maxH=10000;
	function uploadOver(code,show)
	{
		//layer.closeAll();
		
		if(code==100)
		{
			//alert(show);
			//layer.msg('头像上传成功');
			//组合数据
			maxH=parseInt(maxH)+1;
			imgs=$("#success_img_inner").html();
			$("#success_img_inner").show();
			$("#success_img_inner").html(imgs + '<span id="aaa_' + maxH + '" onclick=delete_img("' + show + '","' + maxH + '");><img src="<?php echo base_url();?>' + show + '" style="width:45px;height:45px;margin-right:15px;border:#e4e4e4 1ps solid; border-radius:5px;"></span>');
		}
		else
		{
			alert(show);
			//layer.msg(show);	
		}
	}
	
	var loads=1;
	function delete_img(url,id)
	{
		//alert(url);
		if(loads==1)
		{
			loads=2;
			$.ajax({url:"<?php echo base_url();?>index.php/members/deletes/<?php echo $id;?>", 
			type: 'POST', 
			data:{url:url}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					loads=1;
				},
				beforeSend:function(){
				
				},
				success:function(result){
					loads=1;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result=="success")
					{
						$("#aaa_" + id).remove();
					}				
				} 
			});	
		}
	}
</script>
<script>
	var stops=0;
	if(userAgent==2)
	{
		$(document).ready(function() {
		
	
			var eleFile = document.querySelector('#files');
			// 压缩图片需要的一些元素和对象
			var reader = new FileReader(), img = new Image();
			// 选择的文件对象
			var file = null;
			// 缩放图片需要的canvas
			var canvas = document.createElement('canvas');
			var context = canvas.getContext('2d');
			// base64地址图片加载完毕后
			img.onload = function () {
				// 图片原始尺寸
				var originWidth = this.width;
				var originHeight = this.height;
				// 最大尺寸限制
				var maxWidth = 100, maxHeight = 100;
				// 目标尺寸
				var targetWidth = originWidth, targetHeight = originHeight;
				// 图片尺寸超过400x400的限制
				if (originWidth > maxWidth || originHeight > maxHeight) {
					if (originWidth / originHeight > maxWidth / maxHeight) {
						// 更宽，按照宽度限定尺寸
						targetWidth = maxWidth;
						targetHeight = Math.round(maxWidth * (originHeight / originWidth));
					} else {
						targetHeight = maxHeight;
						targetWidth = Math.round(maxHeight * (originWidth / originHeight));
					}
				}
					
				// canvas对图片进行缩放
				canvas.width = targetWidth;
				canvas.height = targetHeight;
				// 清除画布
				context.clearRect(0, 0, targetWidth, targetHeight);
				// 图片压缩
				context.drawImage(img, 0, 0, targetWidth, targetHeight);
				// canvas转为blob并上传
				canvas.toBlob(function (blob) {
					// 图片ajax上传
		
					var xhr = new XMLHttpRequest();
					// 文件上传成功
					xhr.onreadystatechange = function() {
						if (xhr.status == 200) {
							// xhr.responseText就是返回的数据
							//alert('成功');
							stops=parseInt(stops)+1;
							if(stops==2)
							{
								stops=0;
								parent.msg_show('头像上传成功');
								parent.changeAvatar(xhr.responseText);
							}
						}
					};
					// 开始上传
					xhr.open("POST", '<?php echo base_url();?>index.php/uploads/caches/2', true);
					xhr.send(blob);    
				}, file.type || 'image/png');
			};
			
			// 文件base64化，以便获知图片原始尺寸
			reader.onload = function(e) {
				img.src = e.target.result;
			};
			eleFile.addEventListener('change', function (event) {
				file = event.target.files[0];
				// 选择的文件是图片
				if (file.type.indexOf("image") == 0) {
					reader.readAsDataURL(file);    
				}
			});
		
		
	});	
	}
</script>
</head>

<body>
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff; display:none;"></iframe>
<form action="<?php echo base_url();?>index.php/uploads/caches/1?day=<?php echo $day;?>&id=<?php echo $id;?>" method="post" enctype="multipart/form-data" name="form1" id="form1" target="upload_target1" style="display:none;">
  <input type="file" name="files" id="files" onChange="sub_upload();" />
</form>
<div style="width:330px;height:100px;margin:0 auto;text-align:center;">
	<div style="width:330px;text-align:center;padding-top:20px;padding-bottom:15px;border-bottom:#CCC 1px solid; display:block;" id="success_img_inner">
    <?php
		for($i=0;$i<count($fulls);$i++)
		{
	?>
    <span id="aaa_<?php echo $i+1;?>" onClick="delete_img('<?php echo $fulls[$i]['img'];?>','<?php echo $i+1;?>');"><img src="<?php echo base_url().$fulls[$i]['img'];?>" style="width:45px;height:45px;margin-right:15px;border:#e4e4e4 1ps solid; border-radius:5px;"></span>
    <?php
		}
	?>
    </div>
    <div style="width:330px;text-align:center;padding-top:20px;padding-bottom:15px;">
    	<a href="javascript:choose_file();" style="width:auto; padding-left:30px; padding-right:30px; height:34px; line-height:34px; background:#06C;color:#fff; text-align:center; display:inline-block; text-decoration:none;border-radius:8px;"> 选 择 图 片 上 传 </a>
    </div>
</div>
</body>
</html>