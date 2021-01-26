<?php

	//后台管理员控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Admins extends Ci
	{
		
		public $ajaxLoginArray=['passwd_update'];
		
		public $IframeLoginArray=[];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
		
		//修改密码主界面
		public function passwd()
		{
			$this->load->view('admin/admins/passwd.php');	
		}
		
		//修改密码程序处理
		public function passwd_update()
		{
			$passwd=P('passwd');
			$passwd==""?ajaxs(300,'参数错误'):"";
			$_array=array();
			if($passwd!='')
			{
				$_array['salts']=mt_rand(100000,999999);
				$_array['passwd']=sha1(sha1($passwd).$_array['salts']);
			}
			if($this->db->update('admins',$_array,array('id'=>$this->adminInfos['id'])))
			{
				ajaxs(100,'修改成功');	
			}
			ajaxs(300,'服务器连接失败，请稍后再试！');
		}
		
		//欢迎页面
		public function welcome()
		{
			$query=$this->db->query("select count(`id`) as `alls` from `cc_members`");
			$result=$query->row_array();
			$data['member']=$result['alls'];
			
			$query=$this->db->query("select count(`id`) as `alls` from `cc_sites`");
			$result=$query->row_array();
			$data['sites']=$result['alls'];
			
			$query=$this->db->query("select count(`id`) as `alls` from `cc_members` where `identity`=2");
			$result=$query->row_array();
			$data['siteMember']=$result['alls'];
			
			$this->load->view('admin/welcome.php',$data);		
		}
		
	}