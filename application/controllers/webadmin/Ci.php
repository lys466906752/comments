<?php

	//后台总控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Ci extends CI_Controller
	{
		
		public $adminInfos=false;
		
		public $ajaxLoginArrays=[];
		
		public $IframeLoginArrays=[];
		
		public function __construct()
		{
			parent::__construct();		
		}
		
		//获取对应的admin信息
		public function authFindByIdentity($string,&$result)
		{
			if(substr_count($string,'|')!=3){return false;}
			$array=explode('|',$string);
			$this->load->model('admin/Admins_model','admin');
			
			if($result=$this->admin->getOneForAdmin($array))
			{
				return $result;	
			}
			
			return false;
		}
		
		//检测admin数据是否合法
		protected function checkAdmin()
		{
			if(!$this->session->has_userdata('PC_Auth_Identity')){return false;}
			
			if(!$this->authFindByIdentity($this->encrypt->decode($this->session->userdata('PC_Auth_Identity')),$result))
			{
				$this->session->unset_userdata('PC_Auth_Identity');
				return false;
			}
			
			return $result;
		}
		
		//做入口检测
		protected function authLogin()
		{
			
			$this->ajaxLoginArrays=array_merge($this->ajaxLoginArrays,$this->ajaxLoginArray);
			$this->IframeLoginArrays=array_merge($this->IframeLoginArrays,$this->IframeLoginArray);

			$controller=strtolower($this->uri->segment(2));
			$function=strtolower($this->uri->segment(3));	
			
			$this->adminInfos=$this->checkAdmin();
			
			$checkRom=$controller.'@'.$function;
			foreach($this->ajaxLoginArrays as $k=>$v)
			{
				$this->ajaxLoginArrays[$k]=strtolower($controller."@".$v);	
			}
			if(in_array($checkRom,$this->ajaxLoginArrays))
			{
				if(!$this->adminInfos)
				{
					ajaxs(200,'login failed');
				}
				return true;
			}
			
			foreach($this->IframeLoginArrays as $k=>$v)
			{
				$this->IframeLoginArrays[$k]=strtolower($controller."@".$v);	
			}
			if(in_array($checkRom,$this->IframeLoginArrays))
			{
				if(!$this->adminInfos)
				{
					iframeshow(200,'login failed');
				}
				return true;
			}
			
			if(!$this->adminInfos)
			{
				header("location:".admin_url()."login/indexs");
			}
			return true;
			
		}
		
	}