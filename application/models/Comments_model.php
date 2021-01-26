<?php

	//对应的评论控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Comments_model extends CI_Model
	{
			
		public function __construct()
		{
			parent::__construct();	
		}	
		
		//根据对应的appkey查询对应的站点信息
		public function select_site($id,$appkey='')
		{
			$query=$this->db->query("select * from `cc_sites` where `id`='$id' limit 1");
			if($query->num_rows()>0)
			{
				if($appkey!='')
				{
					$result=$query->row_array();
					if($result['appkey']==$appkey)
					{
						return $query->row_array();	
					}		
				}
				else
				{
					return $query->row_array();
				}
			}	
			return false;
		}
		
		//根据ID查询站点信息
		public function select_id_site($id)
		{
			$query=$this->db->query("select * from `cc_sites` where `id`='$id' limit 1");
			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	
			return false;
		}
		
		//做分表处理truncate table `cc_members`
		public function create_table($id)
		{
			
		}
		
		
	}