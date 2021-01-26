<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<script>
	function success(id)
	{
		window.parent.window.wulala(id);	
	}
</script>
<body>
<iframe id="upload_target1" name="upload_target1" src="#" style="width:0;height:0;border:0px solid #fff; display:none;"></iframe>
<form action="http://127.0.0.4/index.php/test/uploads" method="post" enctype="multipart/form-data" name="form1" id="form1" target="upload_target1">
  <input type="file" name="files" id="files" />
  <input type="submit" name="button" id="button" value="提交" />
</form>
</body>
</html>