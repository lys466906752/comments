<?php

	//后台小助手文件
	
	//定义后台的URL的路径
	if(! function_exists('admin_url'))
	{
		function admin_url()
		{
			return base_url().'index.php/webadmin/';	
		}	
	}
	
	//定义前台的URL地址
	if(! function_exists('http_url'))
	{
		function http_url()
		{
			return base_url().'index.php/';	
		}	
	}
	
	//定义后台模块管理员的地址
	if(! function_exists('masters_url'))
	{
		function masters_url()
		{
			return base_url().'index.php/webmaster/';
		}	
	}
	
	
	//获取配置文件的信息
	if(! function_exists('select_config'))
	{
		function select_config($url)
		{
			if(is_file(FCPATH.'assets/config/'.$url.'.config.php'))
			{
				return require FCPATH.'assets/config/'.$url.'.config.php';
			}
			return false;
		}
	}
	
	//ajax数据提交返回
	if (!function_exists('ajaxs'))
	{
		function ajaxs($code,$msg)
		{
			$msg = str_replace("|","",$msg);
			$code = str_replace("|","",$code);
			echo $code."|".$msg;exit();
		}
	}
	

	//frame输出
	if(!function_exists('iframeshow'))
	{
		function iframeshow($number,$desc,$funcs=null)
		{
			if($funcs=="")
			{
				$funcs="stopUpload";
			}
			echo '<script language="javascript" type="text/javascript">window.parent.window.'.$funcs.'("'.$number.'|'.$desc.'");</script>';exit();
		}
	}
	
	//获取IP地址信息
	if ( ! function_exists('get_ip'))
	{
		function get_ip()
		{
			if (getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			}
			elseif (getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_X_FORWARDED')) {
				$ip = getenv('HTTP_X_FORWARDED');
			}
			elseif (getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR');
			
			}
			elseif (getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
			}
			else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;	
		}
	}
	
	//获取发布者的浏览器信息
	if(!function_exists('user_agent'))
	{
		function user_agent()
		{
			return isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"]!="" ?$_SERVER["HTTP_USER_AGENT"]:"未知";
		}
	}	
	
	//Post或者Get数据操作
	if(! function_exists('P'))
	{
		function P($key)
		{
			return isset($_POST[$key])?htmlspecialchars(trim($_POST[$key])):"";
		}	
	}
	
	//成功提示跳转
	if(! function_exists('success'))
	{
		function success($text,$url=null,$time=null)
		{
			require FCPATH."assets/views/success.php";
		}
	}
	
	//错误提示跳转
	if(! function_exists('error'))
	{
		function error($text,$url=null,$time=null)
		{
			require FCPATH."assets/views/error.php";
		}
	}
	
	//写入配置信息
	if( ! function_exists('write_config'))
	{
		function write_config($file_name,$result)
		{
			$file=fopen(FCPATH."assets/config/".$file_name.".config.php","w");
			$contents="<?php";
			$contents.="\n";
			$contents.="//auth:recson";
			$contents.="\n";
			$contents.="//config PHP";
			$contents.="\n";
			$contents.='	$_Conf='."array(";
			$contents.="\n";
			foreach($result as $k=>$v)
			{
				$contents.='		"'.$k.'"=>';
				$contents.='"'.$v.'",';
				$contents.="\n";
			}
			$contents.=");";
			$contents.="\n";
			$contents.="?>";
			//$file=fopen(FCPATH."100.php","w");
			fwrite($file,$contents);
			fclose($file);
			return true;
		}
	}
	
	
	//清理缓存
	if(! function_exists('CacheClear'))
	{
		function CacheClear($dirs)
		{
			//先删除目录下的文件：
			if(is_dir($dirs))
			{
				return DirDels($dirs);	
			}
			return true;
		}	
	}
	
	//删除文件夹及以下的文件
	if(! function_exists('DirDels'))
	{
		function DirDels($dir)
		{
			$dh=opendir($dir);
			while ($file=readdir($dh)) 
			{
				if($file!="." && $file!="..") 
				{
					
					$fullpath=$dir."/".$file;
					
					if(!is_dir($fullpath))
					{
						unlink($fullpath);
					} 
					else
					{
						DirDels($fullpath);
					}
					
				}
			}
			closedir($dh);
			//删除当前文件夹：
			if(rmdir($dir))
			{
				return true;
			}
			else
			{
				return false;
			}				
		}	
	}