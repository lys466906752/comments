<?php

	//资料对应的控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Members extends Ci
	{
		
		public $ajaxLoginArray=[];
		
		public $IframeLoginArray=['avatar_upload'];		
		
		public function __construct()
		{
			parent::__construct();
			
			$this->authLogin();	
		}
		
		public function passwd()
		{
			$this->checkAdmin();
			$this->load->view('masters/members/passwd.php');	
		}
		
		public function updates()
		{
			isset($_POST['nickname_b']) && strlen($_POST['nickname_b'])<=20?$nickname=$_POST['nickname_b']:ajaxs(300,'参数错误');
			isset($_POST['money']) && is_numeric($_POST['money']) && intval($_POST['money'])>=0?$money=intval($_POST['money']):ajaxs(300,'参数错误');	
			isset($_POST['avatar'])?$avatar=htmlspecialchars(trim($_POST['avatar'])):ajaxs(300,'参数错误');
			
			$passwd='';
			if(isset($_POST['passwd_b']) && strlen($_POST['passwd_b'])>=6 && strlen($_POST['passwd_b'])<=16)
			{
				$passwd=htmlspecialchars(trim($_POST['passwd_b']));	
			}
			
			$id=intval($this->uri->segment(4));
			
			$_array=array(
				'nickname'=>$nickname,
				'avatar'=>$avatar,
				'money'=>$money,
			);
			
			if($passwd!='')
			{
				$_array['passwd']=$passwd;	
			}
			
			$this->db->update('members',$_array,array("id"=>$this->adminInfos['id']));
			ajaxs(100,'更新成功');				
		}
		
		public function avatar_upload()
		{
			if(isset($_FILES['files']['name']) && $_FILES['files']['name']!='')
			{
				$this->load->library("imgsclass");		

				$file=$this->imgsclass->upload($_FILES['files'],$msg,'',array("cutState"=>true,'cutMaxWidth'=>100,'cutMaxHeight'=>100,'uploadExtName'=>array('gif','png','jpg')));	
				if($file)
				{
					
					iframeshow("100",$file);

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
		
	}