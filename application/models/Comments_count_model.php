<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Comments_count_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();	
		}	
		
		//获取用户对应站点的评论条数
		public function get_samcount($uid,$sid,&$count1)
		{
			//echo "select `count`,`count1` from `cc_comments_count_".$sid."` where `id`='$uid' limit 1";die();
			$query=$this->db->query("select `count`,`count1` from `cc_comments_count_".$sid."` where `id`='$uid' limit 1");
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				$count1=$result['count1'];
				//echo $count1;die();
				$count1=="" || empty($count1)?$count1=0:$count1=$count1;
				return $result['count'];	
			}	
			else
			{
				$count1=0;
				return 0;	
			}
		}
	}