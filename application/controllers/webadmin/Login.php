<?php

	//后台登录页面
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Login extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();		
		}
		
		//登录主页
		public function indexs()
		{
			$this->load->view('admin/login.php');	
		}	
		
		//登录程序处理
		public function subs()
		{
			$username=P('username');
			$passwd=P('passwd');
			$captcha=P('captcha');
			$pc_csrf=P('pc_csrf');
			$username==""?ajaxs(300,'参数错误'):"";
			$passwd==""?ajaxs(300,'参数错误'):"";
			$captcha==""?ajaxs(300,'参数错误'):"";
			$pc_csrf==""?ajaxs(300,'参数错误'):"";
			
			if(check_csrfToken($this->encrypt,$pc_csrf,$this->session))
			{
				$codes=$this->session->userdata('adminLogin');
				
				if(strtolower($codes)==strtolower($captcha))
				{
					//结合model做数据处理
					$this->load->model('admin/Admins_model','admins');
					if($this->admins->login($username,$passwd))
					{
						ajaxs(100,1);
					}
					else
					{
						$this->load->model('Members_model','members');
						$res=$this->members->select_members_for_mobile($username);
						if($res)
						{
							if($res['passwd']==$passwd)
							{
								
								$_array=array(
									'login_time'=>time(),
									'login_ip'=>get_ip(),
									'token'=>get_token()							
								);
								$this->members->updateOneRow($_array,$res['id']);
								
								$_array['siteId']=0;
								$site_query=$this->db->query("select `id` from `cc_sites` where `uid`='".$res['id']."' limit 1");
								if($site_query->num_rows()>0)
								{
									$site_result=$site_query->row_array();
									$_array['siteId']=$site_result['id'];	
								}
								
								$this->session->set_userdata('pcAuth',json_encode(array_merge($res,$_array)));
								ajaxs(100,2);
									
							}	
							else
							{
								ajaxs(300,'管理员账号或密码错误！');		
							}
						}	
						else
						{
							ajaxs(300,'管理员账号或密码错误！');	
						}
					}	
					
				}
				
				ajaxs(300,'验证码有误');
			}
			
			ajaxs(300,'系统错误！');
				
		}
		
		//退出会员系统
		public function outs()
		{
			@session_start();
			unset($_SESSION['PC_Auth_Identity']);
			unset($_SESSION['pcAuth']);
			header('location:'.admin_url().'login/indexs');
			exit();	
		}
	}