<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Members_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();	
		}	
		
		//根据手机号查询对应的用户信息
		public function select_members_for_mobile($mobile)
		{
			$query=$this->db->query("select * from `cc_members` where `mobile`='$mobile' limit 1");
			if($query->num_rows()>0)
			{
				return $query->row_array();
			}
			
			return false;
		}	
		
		//根据ID查询对应的用户信息
		public function select_members_for_id($id)
		{
			$query=$this->db->query("select * from `cc_members` where `id`='$id' limit 1");
			if($query->num_rows()>0)
			{
				return $query->row_array();
			}
			
			return false;
		}	
		
		//根据密码生成对应的用户信息
		public function passwd($passwd,$mobile,$nickname,$avatar,$id='')
		{
			if(is_numeric($id))
			{
				$_array=array('passwd'=>$passwd);	
			}
			else
			{
				$_array=array(
					'nickname'=>$nickname,
					'passwd'=>$passwd,
					'passwdtime'=>time(),
					'mobile'=>$mobile,
					'avatar'=>$avatar,
					'login_time'=>0,
					'login_ip'=>get_ip(),
					'token'=>get_token()
				);	
			}
			if(isset($_array['nickname']) && $_array['nickname']!='')
			{
				if($this->db->insert('members',$_array))
				{
					return true;	
				}	
				return false;
			}
			else
			{
				if($this->db->update('members',$_array,array('id'=>$id)))
				{
					return true;	
				}	
				return false;	
			}
		}
		
		//根据三方的信息生成会员信息
		public function reg($passwd,$nickname,$avatar,$openId,$act,&$res)
		{
			$_array=array(
				'nickname'=>$nickname,
				'passwd'=>$passwd,
				'passwdtime'=>time(),
				'avatar'=>$avatar,
				'login_time'=>time(),
				'login_ip'=>get_ip(),
				'token'=>get_token(),
				'money'=>0,
				'mobile'=>'',
				'identity'=>1,
				'state'=>1,
				'avatar_time'=>0,
				'comments_time'=>0,
				're_time'=>0
			);	
			if($act==1)
			{
				$_array['qqId']=$openId;
				$_array['sinaId']='';	
			}
			else
			{
				$_array['qqId']='';
				$_array['sinaId']=$openId;	
			}
			if($this->db->insert('members',$_array))
			{
				$_array['id']=$this->db->insert_id();
				$res=$_array;
				return $_array;	
			}	
			return false;
		}
		
		//修改表的一行数据
		public function updateOneRow($array,$id)
		{
			
			if($this->db->update('members',$array,array('id'=>$id)))
			{
				return true;	
			}	
			
			return false;
		}
	}