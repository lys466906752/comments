<?php

	//后台表情包管理
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Awards extends Ci
	{
		
		public $ajaxLoginArray=['ajax_index','del','index_update'];
		
		public $IframeLoginArray=[];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
	
		public function index()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$data['query']=$this->db->query("select * from `cc_awards`");
			$this->load->view('admin/awards/index.php',$data);	
		}	
		
		public function edit()
		{
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_awards` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$this->load->view('admin/awards/edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}							
		}
		
		public function index_update()
		{
			$id=intval($this->uri->segment(4));	
			$query=$this->db->query("select * from `cc_awards` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$_array=array(
					'award'=>intval($this->input->post('award')),
				);
				$this->db->update('awards',$_array,array('id'=>$id));
				ajaxs(100,'更新成功');
			}
			else
			{
				ajaxs(300,'没有找到对应信息');
			}
		}
	}