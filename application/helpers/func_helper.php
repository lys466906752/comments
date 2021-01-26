<?php

	//常规的帮助函数
	
	//jsonp输出处理
	if(! function_exists('jsonp_show'))
	{
		function jsonp_show($_array)
		{
			$callback=!empty($_GET['jsonpcallback'])?trim($_GET['jsonpcallback']):'';
			$_array=json_encode($_array);
			echo "{$callback}({$_array});";
			exit();				
		}	
	}
	
	//检测两者时间
	if(! function_exists('checkDotime'))
	{
		function checkDotime($time_a,$int)
		{
			if(time()-$time_a>$int)
			{
				return true;	
			}	
			
			return false;
		}	
	}
	
	//查询配置文件
	if(! function_exists('select_config'))
	{
		function select_config($file,$key='')
		{
			$file=FCPATH.'assets/config/'.$file.'.config.php';
							
			if(is_file($file))
			{
				require ($file);
	
				if($key=='')
				{
					return $_Conf;
				}
				
				if(isset($_Conf[$key]))
				{
					return $_Conf[$key];
				}
				
				return false;
			}
			
			return false;
		}	
	}
	
	//获取配置文件里面的某个参数的随机值
	if(! function_exists('select_config_rands'))
	{
		function select_config_rands($file,$key,$k='')
		{
			$res=select_config($file,$key);
			
			if(!$res)
			{
				return false;	
			}
			
			$array=explode('@',$res);
			if($k!='')
			{
				if(isset($array[$k]))
				{
					return $array[$k];	
				}	
			}
			
			$k=mt_rand(0,count($array)-1);
			return $array[$k];	
		}	
	}
	
	//获取IP地址信息
	if (! function_exists('get_ip'))
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
	if(! function_exists('user_agent'))
	{
		function user_agent()
		{
			return isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"]!="" ?$_SERVER["HTTP_USER_AGENT"]:"未知";
		}
	}	
	
	//获取Token信息
	if(! function_exists('get_token'))
	{
		function get_token()
		{
			return sha1(microtime().mt_rand(1000,9999)).sha1(uniqid());	
		}	
	}
	