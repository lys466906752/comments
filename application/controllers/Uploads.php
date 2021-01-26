<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Uploads extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();		
		}
		
		//更新头像
		public function avatar()
		{
			$act=intval($this->uri->segment(3));
			
			if(!isset($_SESSION['pcAuth']))
			{
				echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("200","登录状态已失效");</script>';	exit();
			}
			
			if($act==1)
			{
				$this->load->library("imgsclass");
				$file=$this->imgsclass->upload($_FILES['files'],$msg,'',array("cutState"=>true,'cutMaxWidth'=>100,'cutMaxHeight'=>100));	
				if($file)
				{
					$members=json_decode($this->session->userdata('pcAuth'));
					$this->load->model('Members_model','m');
					$this->m->updateOneRow(array('avatar'=>$file),$members->id);
					$this->avatarReAward($members->id);
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("100","'.$file.'");</script>';exit();
				}
				else
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("300","'.$msg.'");</script>';exit();
				}
			}
			elseif($act==2)
			{
				if(!is_dir(FCPATH.'upload'))
				{
					mkdir(FCPATH.'upload');	
				}
				if(!is_dir(FCPATH.'upload/'.date('Ymd')))
				{
					mkdir(FCPATH.'upload/'.date('Ymd'));	
				}	
				
				$input = file_get_contents('php://input'); 
				$file='upload/'.date('Ymd').'/'.date('YmdHis').substr(microtime(),2,8).'.jpg';
				$fl=fopen(FCPATH.$file,'w');
				fwrite($fl,$input);
				fclose($fl);	
				$members=json_decode($this->session->userdata('pcAuth'));
				$this->load->model('Members_model','m');
				$this->m->updateOneRow(array('avatar'=>$file),$members->id);
				$this->avatarReAward($members->id);
				echo $file;exit();
			}
		}
		
		//上传评论时候的图片
		public function filess()
		{
			$act=intval($this->uri->segment(3));
			$count=intval($_GET['count']);
			
			
			
			if($act==1)
			{
				if($count>=3)
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("300","最多可上传3张");</script>';	exit();	
				}
				if(!isset($_SESSION['pcAuth']))
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("200","登录状态已失效");</script>';	exit();
				}
				$this->load->library("imgsclass");
				isset($_GET['day'])?$day=trim($_GET['day']):$day=date('Y-m-d');
				isset($_GET['id'])?$id=trim($_GET['id']):$id=date('YmdHis').substr(microtime(),2,8).uniqid();
				$file=$this->imgsclass->upload_file($_FILES['files'],$day,$id,$msg,array("cutState"=>true,'cutMaxWidth'=>500,'cutMaxHeight'=>500));	
				if($file)
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("100","'.$file.'");</script>';exit();
					
				}
				else
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("300","'.$msg.'");</script>';exit();
				}
			}
			elseif($act==2)
			{
				if($count>=3)
				{
					echo 'max';exit();	
				}
				if(!isset($_SESSION['pcAuth']))
				{
					echo 'login';exit();
				}
				if(!is_dir(FCPATH.'upload'))
				{
					mkdir(FCPATH.'upload');	
				}
				if(!is_dir(FCPATH.'upload/'.date('Ymd')))
				{
					mkdir(FCPATH.'upload/'.date('Ymd'));	
				}	
				
				$input = file_get_contents('php://input'); 
				$file='upload/'.date('Ymd').'/'.date('YmdHis').substr(microtime(),2,8).'.jpg';
				$fl=fopen(FCPATH.$file,'w');
				fwrite($fl,$input);
				fclose($fl);	
				echo $file;exit();
			}	
		}
		
		//上传对应的图片到对应的目录中
		public function caches()
		{
			$act=intval($this->uri->segment(3));
			
			if(!isset($_SESSION['pcAuth']))
			{
				echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("200","登录状态已失效");</script>';	exit();
			}
			
			if($act==1)
			{
				$this->load->library("imgsclass");
				isset($_GET['day'])?$day=trim($_GET['day']):$day=date('Y-m-d');
				isset($_GET['id'])?$id=trim($_GET['id']):exit("参数错误");
				$file=$this->imgsclass->upload_file($_FILES['files'],$day,$id,$msg,array("cutState"=>true,'cutMaxWidth'=>500,'cutMaxHeight'=>500));	
				if($file)
				{
					
					$query=$this->db->query("select * from `cc_uploads` where `id`='$id' and `date`='$day' limit 1");
					if($query->num_rows()>0)
					{
						$result=$query->row_array();
						$fulls=json_decode($result['full'],true);
						if(count($fulls)>=5)
						{
							echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("300","最多可以上传5张");</script>';exit();	
						}
						$fulls[]=array("img"=>$file);
						$_array=array(
							"full"=>json_encode($fulls),
							'time'=>time()
						);
						$this->db->update('uploads',$_array,array('id'=>$result['id']));
					}
					else
					{
						$_arr=array();
						$_arr[]=array("img"=>$file);
						$_array=array(
							'id'=>$id,
							"full"=>json_encode($_arr),
							"date"=>$day,
							'time'=>time()
						);
						$this->db->insert('uploads',$_array);	
					}
					
					
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("100","'.$file.'");</script>';exit();
				}
				else
				{
					echo '<script language="javascript" type="text/javascript">window.parent.window.uploadOver("300","'.$msg.'");</script>';exit();
				}
			}	
		}
			
		
		//上传头像的奖励
		private function avatarReAward($id)
		{
			$this->load->model('Members_model','m');
			$res=$this->m->select_members_for_id($id);
			if($res)
			{	
				if(date('Y-m-d',$res['avatar_time'])!=date('Y-m-d'))
				{
					//加豆豆积分
					$this->load->model('Awards_model','a');
					$inters=$this->a->getAwards(4);
					$this->db->query("update `cc_members` set `money`=`money`+'$inters',`avatar_time`='".time()."' where `id`='$id'");	
						
				}
			}
			return false;
		}			
		
	}