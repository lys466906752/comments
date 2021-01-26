<?php

	//后台系统配置
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Systems extends Ci
	{
		
		public $ajaxLoginArray=['avatar_ajax','avatar_del','rubbishs'];
		
		public $IframeLoginArray=['avatar_uploads'];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
		
		public function index()
		{
			$data['config']=select_config('site');
			$this->load->view('admin/systems/index.php',$data);	
		}
		
		public function index_update()
		{
			$_array=array(
				"captchaMax"=>$this->input->post("captchaMax"),
				"nicknameInit"=>$this->input->post("nicknameInit"),
				"maxMsgCountSave"=>$this->input->post("maxMsgCountSave")
			);
			$site_config=select_config("site");
			$result=array_merge($site_config,$_array);
			if(write_config("site",$result))
			{
				ajaxs("100","更新成功！");
			}
			else
			{
				ajaxs("300","抱歉：当前程序出了点故障，我们已经抓紧处理了，请您稍后再试！");		
			}		
		}
		
		public function avatar()
		{
			
			$this->load->view('admin/systems/avatar.php');		
		}
		
		public function avatar_ajax()
		{
			$data['config']=select_config('site');
			$this->load->view('admin/systems/avatar.ajaxs.php',$data);	
		}
		
		public function avatar_del()
		{
			isset($_POST['pic']) && trim($_POST['pic'])!=''?$pic=trim($_POST['pic']):ajaxs(300,'没有找到对应图片数据');
			$site_config=select_config("site");
			
			$avatarNewValue=str_replace($pic.'@','',$site_config['avatarInit']);
			$avatarNewValue=str_replace('@'.$pic,'',$avatarNewValue);
			$avatarNewValue=str_replace($pic,'',$avatarNewValue);
			
			$_array=array(
				"avatarInit"=>$avatarNewValue
			);
			$site_config=select_config("site");
			$result=array_merge($site_config,$_array);
			if(write_config("site",$result))
			{
				ajaxs("100","更新成功！");
			}
			else
			{
				ajaxs("300","抱歉：当前程序出了点故障，我们已经抓紧处理了，请您稍后再试！");		
			}			
		}
		
		public function avatar_uploads()
		{
			if(isset($_FILES['files']['name']) && $_FILES['files']['name']!='')
			{
				$this->load->library("imgsclass");			
				
				$picName='assets/images/avatar/'.date('YmdHis').substr(microtime(),2,8).'png';
				
				$file=$this->imgsclass->upload($_FILES['files'],$msg,$picName,array("cutState"=>true,'cutMaxWidth'=>100,'cutMaxHeight'=>100,'uploadExtName'=>array('gif','png','jpg')));	
				if($file)
				{
					$site_config=select_config("site");
					$_array=array(
						"avatarInit"=>trim($file.'@'.$site_config['avatarInit'],'@')
					);
					$site_config=select_config("site");
					$result=array_merge($site_config,$_array);
					if(write_config("site",$result))
					{
						iframeshow("100","更新成功！");
					}
					else
					{
						iframeshow("300","抱歉：当前程序出了点故障，我们已经抓紧处理了，请您稍后再试！");		
					}
				}
				else
				{
					iframeshow(300,$msg);	
				}
			}		
			else
			{
				iframeshow(300,'请上传图片文件');	
			}		
		}
		
		
		//清理站点数据库垃圾和文件垃圾
		public function rubbishs()
		{
			$time=time()-3600*48;//一天前的数据都清理掉
			
			$query=$this->db->query("delete from `cc_uploads` where `time`<='$time'");//清理掉一天前的图片数据
			
			//删除两天前的图片数据	
			for($i=2;$i<=365;$i++)
			{
				$cacheDir=FCPATH.'upload/cache/'.date('Y-m-d',time()-3600*24*$i);	
				if(is_dir($cacheDir))
				{
					CacheClear($cacheDir);
				}
			}
			
			$this->load->helper('cache');
			
			clearFileCache(FCPATH.'caches/apis');
			
			ajaxs(100,'清理成功');
		}
	}