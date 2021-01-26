<?php

	/***管理员表model**/
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require_once 'Main_model.php';
	
	class Admins_model extends Main_model
	{
		public function __construct()
		{
			parent::__construct();	
		}
		
		//生成对应的后台校验信息
		protected function createAuthKey($array)
		{
			$hashValue=$this->encrypt->encode($array['id'].'|'.$array['username'].'|'.$array['token'].'|'.time());
			$this->session->set_userdata('PC_Auth_Identity',$hashValue);		
			return true;
		}	
		
		//管理员登录数据处理
		public function login($username,$passwd)
		{
            /*$u = $username;
            $a = sha1(sha1($passwd).'219466');
            print_r($a);die;*/
			$query=$this->db->query("select * from `".$this->db->dbprefix."admins` where `username`='$username' limit 1");
			if($query->num_rows()>0)
			{
				$result=$query->row_array();

				if(sha1(sha1($passwd).$result['salts'])==$result['passwd'])
				{

					//更新对应的数据信息
					$_array=array(
						'login_time'=>time(),
						'login_ip'=>get_ip(),
						'last_time'=>$result['login_time'],
						'last_ip'=>$result['login_ip'],
						'token'=>sha1(microtime().uniqid()).sha1(mt_rand(100000,999999))
					);
					if($this->db->update('admins',$_array,array('id'=>$result['id'])))
					{
						//生成对应的校验信息
						$this->createAuthKey(array_merge($result,$_array));
						return true;	
					}
					
					return false;
				}
				
				return false;	
			}	
			
			return false;
		}
		
		//查询一条对应的管理员信息
		public function getOneForAdmin($array)
		{
			$query=$this->db->query("select * from `".$this->db->dbprefix."admins` where `id`='".$array[0]."'");
			if($query->num_rows()>0)
			{
				
				$result=$query->row_array();
				
				if(trim($result['username'])==trim($array[1]) && trim($result['token'])==trim($array[2]))
				{
					$this->createAuthKey($result);
					return $result;	
				}
				
				return false;
			}
			
			return false;
		}
	}