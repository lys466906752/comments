<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/canvas-to-blob.js"></script>
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

	function chooseFile()
	{
		
		$("#files").click();	
	}
	
	function avatarUploads()
	{
		if(userAgent==1)
		{
			if(uploads==0)
			{
				document.commentsAvatarForm.submit();
			}
		}
	}
	
	function uploadOver(code,show)
	{
		var hideUlr=$("#hideUlr").val();
		location=hideUlr + "?func=avatarBacks&code=" + code + '&str=' + show;
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
				//alert("开始压缩");
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
				//alert("压缩完成");
				// canvas对图片进行缩放
				canvas.width = targetWidth;
				canvas.height = targetHeight;
				// 清除画布
				context.clearRect(0, 0, targetWidth, targetHeight);
				// 图片压缩
				context.drawImage(img, 0, 0, targetWidth, targetHeight);
				//alert("准备好了哦！");
				
				//alert(canvas);
				// canvas转为blob并上传
				canvas.toBlob(function (blob) {
					/// 图片ajax上传
					//alert("开始创建组件，准备上传");
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
								var hideUlr=$("#hideUlr").val();
								var code=100;
								location=hideUlr + "?func=avatarBacks&code=" + code + '&str=' + xhr.responseText;
							}
						}
					};
					// 开始上传
					xhr.open("POST", '<?php echo http_url();?>uploads/avatar/2', true);
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
<style type="text/css">
body,td,th {
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

<a href="javascript:chooseFile();" style="width:80px;height:80px; display:inline-block; background:#000;color:#FFF;">点我上传</a>

<iframe name="commentsAvatarFrame" style="width:200px;height:200px;display:none;" frameborder="0"></iframe>
<form id="commentsAvatarForm" name="commentsAvatarForm" enctype="multipart/form-data" action="<?php echo http_url();?>uploads/avatar/1" target="commentsAvatarFrame" method="post" style="display:none;">
	<input type="hidden" id="hideUlr" name="hideUlr" value="<?php echo $_GET['url'];?>/junyiSay.php" >
    <input type="file" id="files" name="files" value="" onChange="avatarUploads();" accept="image/*">
</form>