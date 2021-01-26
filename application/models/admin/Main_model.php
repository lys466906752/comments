<?php

	/***后台核心model**/
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Main_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();	
		}
		
		//生成对应的后台校验信息
		protected function createAuthKey($array)
		{
			$hashValue=$this->encrypt->encode($array['id'].'|'.$array['username'].'|'.$array['token'].'|'.time());
			setcookie('PC_Auth_Identity',$hashValue,time()+3600,'/');
			$this->session->set_userdata('PC_Auth_Identity',$hashValue);		
			return true;
		}
		
	}