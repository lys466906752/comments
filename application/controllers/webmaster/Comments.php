<?php

	//站点管理员控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Comments extends Ci
	{
		
		public $ajaxLoginArray=['index_ajax','truncates','del','updates','outres'];
		
		public $IframeLoginArray=['tupian_uploads','backinsert'];		
		
		public function __construct()
		{
			parent::__construct();
			
			$this->authLogin();	
		}
		
		public function res()
		{
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			isset($_REQUEST["reId"]) && trim($_REQUEST["reId"])!=""?$data["reId"]=trim($_REQUEST["reId"]):$data["reId"]='';
			$this->load->view('masters/comments/res.php',$data);	
		}
		
		public function res_ajax()
		{
			$pagesize=30;
			$siteId=intval($this->uri->segment(4));
			$pageindex=intval($this->uri->segment(5));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			isset($_REQUEST["reId"]) && trim($_REQUEST["reId"])!=""?$reId=trim($_REQUEST["reId"]):$reId="";
			
			$where="";
			
			if($reId!='' && is_numeric($reId))
			{
				$where.=" and `aid`='$reId' ";	
			}
			if($keywords!="")
			{
				$where.=" and (`uname`='$keywords' or `rname`='$keywords' or `fulltext` like '%$keywords%')";
			}
			
			$sql="select * from `cc_comments_r".$siteId."`  where `id`>0 ".$where." order by `id` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("masters/comments/res.ajax.php",$data);		
		}
		
		//修改
		public function re_edit()
		{
			$id=intval($this->uri->segment(4));	
			$siteid=intval($this->uri->segment(5));	
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			isset($_REQUEST["reId"]) && trim($_REQUEST["reId"])!=""?$data["reId"]=trim($_REQUEST["reId"]):$data["reId"]='';
			
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_comments_r".$siteid."` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$data['siteid']=$siteid;
				$this->load->view('masters/comments/re_edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}				
		}
		
		//修改提交
		public function res_updates()
		{
			$id=intval($this->uri->segment(4));
			$siteid=intval($this->uri->segment(5));	
			$_array=array(
				"uid"=>$this->input->post("uid"),
				"uname"=>$this->input->post("uname"),
				"fulltext"=>$this->input->post("fulltext"),
				"rid"=>$this->input->post("rid"),
				"rname"=>$this->input->post("rname")
			);	
			
			$this->db->update("comments_r".$siteid,$_array,array("id"=>$id));
			ajaxs(100,'更新成功');				
		}
		
		//删除回复信息
		public function rs_del()
		{
			isset($_POST['id']) && trim($_POST['id'])!=''?$id=trim($_POST['id']):ajaxs(300,'参数错误');
			isset($_POST['siteid']) && trim($_POST['siteid'])!=''?$siteid=intval($_POST['siteid']):ajaxs(300,'参数错误');
			$this->db->query("delete from `cc_comments_r".$siteid."` where `id` in (".$id.")");
			ajaxs(100,'删除成功');
		}
		
		public function index()
		{
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			$this->load->view('masters/comments/index.php',$data);	
		}
		
		public function index_ajax()
		{
			$pagesize=12;
			$siteId=intval($this->uri->segment(4));
			$pageindex=intval($this->uri->segment(5));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`nickname`='$keywords' or `fulltext` like '%$keywords%')";
			}
			
			$sql="select * from `cc_comments_a".$siteId."`  where `id`>0 ".$where." order by `time` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("masters/comments/index.ajax.php",$data);				
		}
		
		//修改数据
		public function edit()
		{
			$id=intval($this->uri->segment(4));	
			$siteid=intval($this->uri->segment(5));	
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_comments_a".$siteid."` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['sy']=$this->db->query("select * from `cc_yins`");
				$data['result']=$query->row_array();
				$data['siteid']=$siteid;
				$this->load->view('masters/comments/edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}				
		}
		
		//修改程序处理
		public function updates()
		{
			$id=intval($this->uri->segment(4));
			$siteid=intval($this->uri->segment(5));	
			$_array=array(
				"nickname"=>$this->input->post("nickname"),
				"star"=>$this->input->post("star"),
				"fulltext"=>$this->input->post("fulltext"),
				"ok"=>$this->input->post("ok")
			);	
			$files=$this->input->post("files");
			
			$files=explode(",",$files);
			$arr=array();
			foreach($files as $v)
			{
				if(trim($v)!='' && substr_count($v,'upload')>0)
				{
					$arr[]["img"]=$v;	
				}
				
			}
			$_array['files']=json_encode($arr);
			
			//print_r($_array);exit();
			
			$this->db->update("comments_a".$siteid,$_array,array("id"=>$id));
			ajaxs(100,'更新成功');
		}
		
		//上传配置
		public function tupian_uploads()
		{
			if(isset($_FILES['files']['name']) && $_FILES['files']['name']!='')
			{
				$this->load->library("imgsclass");		

				$file=$this->imgsclass->upload($_FILES['files'],$msg,'',array("cutState"=>true,'cutMaxWidth'=>600,'cutMaxHeight'=>600,'uploadExtName'=>array('gif','png','jpg')));	
				if($file)
				{
					
					iframeshow("100",$file."|1");

				}
				else
				{
					iframeshow(300,$msg);	
				}				
			}
			else
			{
				iframeshow(300,'请上传图片文件');		
			}				
		}
		
		//清空回复信息
		public function res_truncates()
		{
			isset($_POST['id']) && trim($_POST['id'])!=''?$id=intval($_POST['id']):ajaxs(300,'参数错误');
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			$this->db->query("truncate table `cc_comments_r".$id."`");
			
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				ajaxs(100,'清空成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'清空失败，请稍后再试');	
			}	
		}
		
		//清空数据
		public function truncates()
		{
			isset($_POST['id']) && trim($_POST['id'])!=''?$id=intval($_POST['id']):ajaxs(300,'参数错误');
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			$this->db->query("truncate table `cc_comments_a".$id."`");	
			$this->db->query("truncate table `cc_comments_clicked_".$id."`");
			$this->db->query("truncate table `cc_comments_count_".$id."`");
			$this->db->query("truncate table `cc_comments_join_".$id."`");
			$this->db->query("truncate table `cc_comments_r".$id."`");
			$this->db->query("update `cc_sites` set `join`='0',`counts`='0',`best`='0',`medium`='0',`negative`='0' where `id`='$id'");
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				ajaxs(100,'清空成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'清空失败，请稍后再试');	
			}
		}

		
		//删除信息
		public function del()
		{
			isset($_POST['id']) && trim($_POST['id'])!=''?$id=intval($_POST['id']):ajaxs(300,'参数错误');
			isset($_POST['siteid']) && trim($_POST['siteid'])!=''?$siteid=intval($_POST['siteid']):ajaxs(300,'参数错误');
			$id=trim($_POST['id']);
			$arr=explode(',',$id);
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			foreach($arr as $k=>$v)
			{
				$this->delItem($v,$siteid);	
			}	
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				
				//更新对应表的结果信息
				$query_a=$this->db->query("select `id` from `cc_comments_a".$siteid."` where `star`>3");
				$query_b=$this->db->query("select `id` from `cc_comments_a".$siteid."` where `star`=3");
				$query_c=$this->db->query("select `id` from `cc_comments_a".$siteid."` where `star`<3");
				
				$query_z=$this->db->query("select `id` from `cc_comments_a".$siteid."`");
				
				$_array=[
					'counts'=>$query_z->num_rows(),
					'best'=>$query_a->num_rows(),
					'medium'=>$query_b->num_rows(),
					'negative'=>$query_c->num_rows()
				];
				
				$this->db->update('sites',$_array,['id'=>$siteid]);
								
				ajaxs(100,'删除成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'删除失败，请稍后再试');	
			}
		}
		
		//单条删除
		private function delItem($id,$siteid)
		{
			$this->db->query("delete from `cc_comments_r".$siteid."` where `aid`='$id'");
			$this->db->query("delete from `cc_comments_a".$siteid."` where `id`='$id'");
		}
		
		//导出数据
		public function backout()
		{
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			$this->load->view('masters/comments/backout.php',$data);				
		}
		
		//导出数据程序操作
		public function outres()
		{
			set_time_limit(0);
			ini_set('max_execution_time',0);
			$siteid=$this->input->post("siteid");
			$query=$this->db->query("select * from `cc_comments_a".$siteid."`");
			
			$_array=[];
			$i=0;
			foreach($query->result_array() as $arrays)
			{
				$_array[$i]=$arrays;
				$_array[$i]['reAll']=$this->db->query("select * from `cc_comments_r".$siteid."` where `aid`='".$_array[$i]['id']."'")->result_array();
				$i++;
			}
			
			$array=json_encode($_array);
			$file=fopen(FCPATH.'assets/res/res_'.$siteid.'.sql','w');
			if(fwrite($file,$array))
			{
				ajaxs(100,'导出成功，您现在可以下载该文件');	
			}
			else
			{
				ajaxs(300,'下载失败，请确保目录权限为可写');					
			}
		}
		
		//下载导出数据
		public function downloads()
		{
			$siteid=$this->uri->segment(4);
			$file = FCPATH.'assets/res/res_'.$siteid.'.sql';
			
			if(file_exists($file)){
				header("Content-type:application/octet-stream");
				$filename = basename($file);
				header("Content-Disposition:attachment;filename = ".$filename);
				header("Accept-ranges:bytes");
				header("Accept-length:".filesize($file));
				readfile($file);
			}else{
				
				echo "<script>alert('文件不存在')</script>";
			}			
		}
		
		//上传数据
		public function backin()
		{
			$data['site_id']=$this->authFindBySiteId();
			if(!$data['site_id'])
			{
				error("站点不正确，请先切换或添加！",masters_url().'sites/add');exit();	
			}
			$this->load->view('masters/comments/backin.php',$data);	
		}
		
		//导入数据
		public function backinsert()
		{
			set_time_limit(0);
			ini_set('max_execution_time',0);
			$siteid=$this->uri->segment(4);
			$froms=$this->input->post("froms");
			if(isset($_FILES['files']['name']) && trim($_FILES['files']['name'])!='')
			{
				if(move_uploaded_file($_FILES['files']['tmp_name'],FCPATH.'assets/res/up_'.$siteid.'.sql'))
				{
					
					$text=file_get_contents(FCPATH.'assets/res/up_'.$siteid.'.sql');
					$arrays=json_decode($text,true);
					
					if($froms==1)
					{
						foreach($arrays as $array)
						{
							//print_r($array);die();
							set_time_limit(0);
							if(isset($array['id']) && isset($array['uid']) && isset($array['avatar']) && isset($array['nickname']) && isset($array['star']) && isset($array['fulltext']) && isset($array['files']) && isset($array['ok']) && isset($array['time']) && isset($array['ip']) && isset($array['re']))
							{
								$query=$this->db->query("select `id` from `cc_comments_a".$siteid."` where `id`='".$array['id']."'");
								if($query->num_rows()<=0)
								{
									$file=array();
									
									$array['files']=json_decode($array['files'],true);
									
									foreach($array['files'] as $k=>$v)
									{
										$file[]['img']=stripslashes($v['img']);	
									}
									
									
									$array['files']=json_encode($file);
									
									$reAll=$array['reAll'];
									
									unset($array['reAll']);
									
									$this->db->insert("cc_comments_a".$siteid,$array);
									
									for($i=0;$i<count($reAll);$i++)
									{
										//开始添加对应的评论信息
										$_array=[
											"id"=>$reAll[$i]['id'],
											"aid"=>$reAll[$i]['aid'],
											"upid"=>$reAll[$i]['upid'],
											"uid"=>$reAll[$i]['uid'],
											"uname"=>$reAll[$i]['uname'],
											"rid"=>$reAll[$i]['rid'],
											"rname"=>$reAll[$i]['rname'],
											"fulltext"=>$reAll[$i]['fulltext'],
											"time"=>$reAll[$i]['time'],
											"ip"=>$reAll[$i]['ip']
										];
										$this->db->insert("cc_comments_r".$siteid,$_array);	
									}
								}
							}	
							else
							{
								iframeshow(300,'文件格式有误，请检查后再试！');	
							}
						}	
						iframeshow(100,'数据导入成功');
					}
					else
					{
						$arrays=$arrays['comments'];
						$z=0;
						//来自畅言
						
						//先获取一下假会员信息
						$qy=$this->db->query("select * from `cc_members` where `mobile`='' and `qqId` is null and `sinaId` is null");
						$_arrs=[];
						$w=0;
						foreach($qy->result_array() as $ars)
						{
							$_arrs[$w]=$ars;
							$w++;
						}
						
						foreach($arrays as $array)
						{
							set_time_limit(0);
							if(isset($array['content']) && isset($array['ctime']))
							{
								$members=$this->randCreateMembers($z,$_arrs);
								
								if($members)
								{
									$_array=array(
										'uid'=>$members['id'],
										'avatar'=>$members['avatar'],
										'nickname'=>$members['nickname'],
										'star'=>4,
										'fulltext'=>$array['content'],
										'files'=>json_encode(array()),
										'ok'=>0,
										're'=>0,
										'time'=>strtotime($array['ctime']),
										'ip'=>get_ip()
									);
									$this->db->insert("cc_comments_a".$siteid,$_array);
								}
								
								$z++;
							}
							else
							{
								iframeshow(300,'文件格式有误，请检查后再试1！');		
							}
						}
						
						//更新一下对应表的统计数量
						$this->db->query("update `cc_sites` set `best`=`best`+'$z',`join`=`join`+'$z',`counts`=`counts`+'$z' where `id`='$siteid'");
						
						iframeshow(100,'数据导入成功');
					}
				}
				else
				{
					iframeshow(300,'文件上传失败，请稍后再试');	
				}		
			}
			else
			{
				iframeshow(300,'请上传数据文件');	
			}
		}
		
		//随机创建一个会员信息
		private function randCreateMembers($z='',$_array)
		{
			
			if(!empty($_array) && isset($_array[$z]))
			{
				return $_array[$z];
			}
			else
			{
				$nickname=select_config_rands('site','nicknameInit',$z);
				$avatar=select_config_rands('site','avatarInit',$z);
				
				$_arrary=array(
					"nickname"=>$nickname,
					'mobile'=>'',
					'passwd'=>mt_rand(100000000,999999999),
					'passwdtime'=>time(),
					'avatar'=>$avatar,
					'money'=>0,
					'identity'=>1,
					'state'=>1,
					'site'=>0,
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'avatar_time'=>time(),
					'comments_time'=>time(),
					're_time'=>time(),
					'token'=>get_token()
				);
				if($this->db->insert("members",$_arrary))
				{
					$_arrary['id']=$this->db->insert_id();
					return $_arrary;
				}
				return false;
			}
		}
		
	}