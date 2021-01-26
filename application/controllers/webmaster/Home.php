<?php

	//站点管理员控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Home extends Ci
	{
		
		public $ajaxLoginArray=['changes'];
		
		public $IframeLoginArray=[];		
		
		public function __construct()
		{
			parent::__construct();
			
			$this->authLogin();	
		}
		
		public function index()
		{
			$data['query']=$this->db->query("select * from `cc_sites` where `uid`='".$this->adminInfos['id']."'");
			$data['site_id']=$this->authFindBySiteId();
			$this->load->view('masters/index.php',$data);	
		}
		
		public function welcome()
		{
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			$query=$this->db->query("select count(`id`) as `alls` from `cc_comments_a".$data['site_id']."`");
			$result=$query->row_array();
			$data['alls']=$result['alls'];
			
			$query=$this->db->query("select count(`id`) as `today` from `cc_comments_a".$data['site_id']."` where `time`>'".strtotime(date('Y-m-d ').'00:00:00')."'");
			$result=$query->row_array();
			$data['today']=$result['today'];
			$this->load->view('masters/welcome.php',$data);	
		}
		
		public function changes()
		{
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_sites` where `id`='$id' and `uid`='".$this->adminInfos['id']."'");
			if($query->num_rows()>0)
			{
				$pcAuth=$this->session->userdata('pcAuth');
				$pcAuth=json_decode($pcAuth,true);
				$pcAuth['siteId']=$id;
		
				$this->session->set_userdata('pcAuth',json_encode($pcAuth));
				ajaxs(100,'切换成功');
			}	
			else
			{
				ajaxs(300,'没有找到相应站点');	
			}
		}
		
		//清理站点数据库垃圾和文件垃圾
		public function rubbishs()
		{
			
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			
			$this->load->helper('cache');
			
			clearFileCache(FCPATH.'caches/apis/'.$data['site_id']);
			
			ajaxs(100,'清理成功');
		}
		
	}