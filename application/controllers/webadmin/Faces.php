<?php

	//后台表情包管理
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Faces extends Ci
	{
		
		public $ajaxLoginArray=['ajax_index','del','ups','downs'];
		
		public $IframeLoginArray=[];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
		
		//表情包首页
		public function index()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('admin/faces/index.php',$data);
		}	
		
		//表情包Ajax读取
		public function index_ajax()
		{
			$pagesize=12;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`name`='$keywords')";
			}
			
			$sql="select * from `cc_faces` where `id`>0 ".$where." order by `sort` asc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("admin/faces/index.ajax.php",$data);	
			
			
			
				
		}
		
		
		
		//添加表情
		public function add()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('admin/faces/add.php',$data);		
		}
		
		//程序处理添加表情信息
		public function index_insert()
		{
			$name=P('name');
			$name==""?iframeshow(300,'请填写表情名称'):"";
			$this->load->library("pinyinclass");	
			$staticClass=$this->pinyinclass;
			$ordName=str_replace(" ","",$staticClass::encode($name,'all'));
			$query=$this->db->query("select `id` from `cc_faces` where `name`='$name' limit 1");
			
			if($query->num_rows()<=0)
			{

				$this->load->library("imgsclass");			
				$file=$this->imgsclass->upload($_FILES['files'],$msg,'assets/images/face/'.$ordName.'.gif',array("cutState"=>false,'uploadExtName'=>array('gif','png','jpg')));	
				if($file)
				{
					$_array=array(
						'name'=>$name,
						'file'=>$file,
						'sort'=>0,
					);
					
					$this->db->insert('faces',$_array);
					$id=$this->db->insert_id();
					
					$_array=array(
						'sort'=>$id
					);
					$this->db->update('faces',$_array,array('id'=>$id));
					
					iframeshow(100,'success');
				}
				else
				{
					iframeshow(300,$msg);	
				}	
			
			}
			else
			{
				iframeshow(300,'抱歉：当前表情名称已存在，请更换！');	
			}
			
		}
		
		//修改表情信息
		public function edit()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_faces` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$this->load->view('admin/faces/edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}				
		}
		
		//修改程序处理
		public function index_update()
		{
			$id=intval($this->uri->segment(4));	
			$name=P('name');
			$name==""?iframeshow(300,'请填写表情名称'):"";
			$this->load->library("pinyinclass");	
			$staticClass=$this->pinyinclass;
			$ordName=str_replace(" ","",$staticClass::encode($name,'all'));
			$query=$this->db->query("select `id` from `cc_faces` where `name`='$name' and `id`!='$id' limit 1");
			
			if($query->num_rows()<=0)
			{
				$query=$this->db->query("select * from `cc_faces` where `id`='$id'");
				if($query->num_rows()>0)
				{
					$result=$query->row_array();
					if(isset($_FILES['files']['name']) && $_FILES['files']['name']!='')
					{
						$this->load->library("imgsclass");			
						$file=$this->imgsclass->upload($_FILES['files'],$msg,'assets/images/face/'.$ordName.'.gif',array("cutState"=>false,'uploadExtName'=>array('gif','png','jpg')));	
						if(!$file)
						{
							iframeshow(300,$msg);
						}
					}
					
					
					$this->db->query("update `cc_faces` set `name`='$name',`file`='assets/images/face/".$ordName.".gif' where `id`='$id'");
					
					if(!isset($_FILES['files']['name']) || $_FILES['files']['name']=="")
					{
						copy(FCPATH.$result['file'],FCPATH.'assets/images/face/'.$ordName.'.gif');	
					}
					iframeshow(100,'success');
				}
				else
				{
					iframeshow(300,'抱歉：没有找到对应信息，请更换！');	
				}

			}
			else
			{
				iframeshow(300,'抱歉：当前表情名称已存在，请更换！');	
			}
		}
		
		
		//删除对应的表情
		public function del()
		{
			$id=$this->input->post("id");
			$this->db->query("delete from `cc_faces` where `id` in (".$id.")");	
			ajaxs(100,"删除成功");	
	
		}
		
		//上移动
		public function ups()
		{
			$id=intval($this->input->post("id"));
			$sql="select * from `cc_faces` order by `sort` asc";
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				$result=$query->row_array();
				if($result["id"]==$id){
					//第一个id就是所选排序第一id，无需上移
					ajaxs(100,'success');
				}else{
					$i=0;
					$nid="";
					foreach($query->result_array() as $array){
						if($array["id"]!=$id){
							$nid=$array["id"];
							$this->db->query("update `cc_faces` set `sort`='$i' where `id`='".$array["id"]."'");	
						}else{
							//找到了对应的id信息了，前后的sort进行处理
							$i1=$i-1;
							$this->db->query("update `cc_faces` set `sort`='$i1' where `id`='".$array["id"]."'");
							$this->db->query("update `cc_faces` set `sort`='$i' where `id`='".$nid."'");	
							$nid=$array["id"];
						}
						$i++;	
					}
					ajaxs(100,'success');	
				}
			}
		}
		
		public function downs($id)
		{
			$id=intval($this->input->post("id"));
			$sql="select * from `cc_faces` order by `sort` desc";
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				$result=$query->row_array();
				if($result["id"]==$id){
					//第一个id就是所选排序第一id，无需上移
					ajaxs(100,'success');
				}else{
					$i=$query->num_rows();
					$nid="";
					foreach($query->result_array() as $array){
						if($array["id"]!=$id){
							$nid=$array["id"];
							$this->db->query("update `cc_faces` set `sort`='$i' where `id`='".$array["id"]."'");	
						}else{
							//找到了对应的id信息了，前后的sort进行处理
							$i1=$i+1;
							$this->db->query("update `cc_faces` set `sort`='$i1' where `id`='".$array["id"]."'");
							$this->db->query("update `cc_faces` set `sort`='$i' where `id`='".$nid."'");	
							$nid=$array["id"];
						}
						$i--;	
					}
					ajaxs(100,'success');	
				}
			}		
		}
		
	}