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

		//获取当前站点的ID信息
		protected function authFindBySiteId()
		{
			if($this->adminInfos)
			{
				//print_r($this->adminInfos);die();
				$site=$this->adminInfos['siteId'];
				
				$query=$this->db->query("select `id` from `cc_sites` where `id`='$site' and `uid`='".$this->adminInfos['id']."'");
				if($query->num_rows()>0)
				{
					return $site;	
				}
				
				return false;
			}	
			
			return false;
		}
		
		//获取对应的admin信息
		protected function authFindByIdentity($array,&$result)
		{
			
			if(!isset($array['siteId']))
			{
				return false;	
			}
			
			$this->load->model('Members_model','m');
			
			if($result=$this->m->select_members_for_id($array['id']))
			{
				$result=array_merge($array,$result);
				
				return $array;	
			}
			
			return false;
		}
		
		//检测admin数据是否合法
		protected function checkAdmin()
		{
			
			if(!$this->session->has_userdata('pcAuth')){return false;}
			
			if(!$this->authFindByIdentity(json_decode($this->session->userdata('pcAuth'),true),$result))
			{
				$this->session->unset_userdata('pcAuth');
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