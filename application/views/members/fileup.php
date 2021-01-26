<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/layer_pc/layer.js"></script>
<script src="<?php echo base_url();?>assets/js/canvas-to-blob.js"></script>
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
	
	function show()
	{
		
		$("#files").click();
		
	}
	
	function sub_upload()
	{
		if(userAgent==1)
		{
			if(uploads==0)
			{
				document.form1.submit();
			}
		}
	}
	
	function uploadOver(code,show)
	{
		var hideUlr=$("#hideUlr").val();
		location=hideUlr + "?func=commentupBack&code=" + code + '&str=' + show;
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
				var maxWidth = 600, maxHeight = 600;
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
								if(xhr.responseText=='max')
								{
									stops=0;
									var hideUlr=$("#hideUlr").val();
									var code=300;
									location=hideUlr + "?func=commentupBack&code=" + code + '&str=最多可上传3张';
									
								}
								else
								{
									stops=0;
									var hideUlr=$("#hideUlr").val();
									var code=100;
									location=hideUlr + "?func=commentupBack&code=" + code + '&str=' + xhr.responseText;
									
								}
								
							}
						}
					};
					// 开始上传
					xhr.open("POST", '<?php echo base_url();?>index.php/uploads/filess/2?count=<?php echo $nows;?>', true);
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
<form action="<?php echo base_url();?>index.php/uploads/filess/1?count=<?php echo $nows;?>" method="post" enctype="multipart/form-data" name="form1" id="form1" target="upload_target1" style="display:none;">
<input type="hidden" id="hideUlr" name="hideUlr" value="<?php echo $_GET['url'];?>/junyiSay.php" >
  <input type="file" name="files" id="files" onChange="sub_upload();" accept="image/*" />
</form>

<a href="javascript:show();" style="width:38px;height:38px; display:inline-block;font-size:30px; line-height:38px;color:#333; text-align:center; text-decoration:none;">+</a>
</body>
</html>