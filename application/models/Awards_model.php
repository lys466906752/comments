<?php

	//对应的奖励表model信息
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Awards_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();	
		}	
		
		//获取对应的积分信息
		public function getAwards($id)
		{
			$query=$this->db->query("select * from `cc_awards` where `id`='$id'");
			if($query->result_array())
			{
				$res=$query->row_array();
				return $res['award'];	
			}	
			
			return 0;
		}
		
	}