<?php

	//后台站点管理会员配置控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Masters extends Ci
	{
		
		public $ajaxLoginArray=['index_ajax','inserts','sites_updates'];
		
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
			$this->load->view('admin/masters/index.php',$data);
				
		}
		
		public function index_ajax()
		{
			$pagesize=12;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`mobile`='$keywords' or `nickname`='$keywords')";
			}
			
			$sql="select * from `cc_members` where `identity`=2 ".$where." order by `login_time` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("admin/masters/index.ajax.php",$data);				
		}
		
		//添加管理员信息
		public function add()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('admin/masters/add.php',$data);
		}

		
		//处理会员添加程序
		public function inserts()
		{
			isset($_POST['act']) && in_array($_POST['act'],array(1,2))?$act=$_POST['act']:ajaxs(300,'参数错误');
			if($act==1)
			{
				//老会员直接录入
				isset($_POST['mobile_a']) && preg_match("/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/",$_POST["mobile_a"],$m)?$mobile=htmlspecialchars(trim($_POST['mobile_a'])):ajaxs(300,'参数错误');
				
				$query=$this->db->query("select `id`,`identity` from `cc_members` where `mobile`='$mobile' limit 1");	
				if($query->num_rows()>0)
				{
					$result=$query->row_array();
					if($result['identity']==1)
					{
						$this->db->query("update `cc_members` set `identity`='2' where `id`='".$result['id']."'");
						ajaxs(100,'设置成功');	
					}	
					else
					{
						ajaxs(300,'当前会员已是站点管理员身份，请勿重复设置');	
					}
				}
				else
				{
					ajaxs(300,'没有找到对应会员信息');	
				}
			}
			else
			{
				
				//新会员添加
				isset($_POST['mobile_b']) && preg_match("/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/",$_POST["mobile_b"],$m)?$mobile=htmlspecialchars(trim($_POST['mobile_b'])):ajaxs(300,'参数错误');	
				isset($_POST['nickname_b']) && strlen($_POST['nickname_b'])<=20?$nickname=$_POST['nickname_b']:ajaxs(300,'参数错误');
				isset($_POST['passwd_b']) && strlen($_POST['passwd_b'])>=6  && strlen($_POST['passwd_b'])<=16?$passwd=$_POST['passwd_b']:ajaxs(300,'参数错误');
				$query=$this->db->query("select `id` from `cc_members` where `mobile`='$mobile' limit 1");	
				if($query->num_rows()<=0)
				{
					$_array=array(
						'nickname'=>$nickname,
						'mobile'=>$mobile,
						'passwd'=>$passwd,
						'passwdtime'=>time(),
						'avatar'=>select_config_rands('site','avatarInit'),
						'money'=>0,
						'identity'=>2,
						'login_time'=>0,
						'login_ip'=>'',
						'avatar_time'=>0,
						'comments_time'=>0,
						're_time'=>0,
						'token'=>'',
					);
					$this->db->insert('members',$_array);
					ajaxs(100,'设置成功');
				}
				else
				{
					ajaxs(300,'当前会员已注册，请更换其他手机号');	
				}
				
 			}
		}
		
		//站点管理员删除
		public function del()
		{
			$id=trim($this->input->post('id'),',');
			$arr=explode(',',$id);
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			foreach($arr as $i)
			{
				if($this->db->query("delete from `cc_members` where `id`='$i'"))
				{
					$query=$this->db->query("select * from `cc_sites` where `uid`='$id'");
					foreach($query->result_array() as $array)
					{
						$ii=$array['id'];
						
						if($this->db->query("delete from `cc_sites` where `id`='$ii'"))
						{
							$this->db->query("drop table `cc_comments_".$ii."`");
							$this->db->query("drop table `cc_comments_clicked_".$ii."`");
							$this->db->query("drop table `cc_comments_count_".$ii."`");
							$this->db->query("drop table `cc_comments_join_".$ii."`");	
						}	
												
					}
				}	
			}
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				ajaxs(100,'删除成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'删除失败，请稍后再试');	
			}	
									
		}
		
		public function sites()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('admin/masters/sites.php',$data);	
		}
		
		public function sites_ajax()
		{
			$pagesize=12;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`s`.`name`='$keywords' or `s`.`url`='$keywords' or `s`.`appkey`='$keywords' or `m`.`mobile`='$keywords')";
			}
			
			$sql="select `s`.*,`m`.`mobile` from `cc_sites` as `s` left join `cc_members` as `m` on `s`.`uid`=`m`.`id` where `s`.`id`>0 ".$where." order by `s`.`id` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("admin/masters/sites.ajax.php",$data);	
		}
		
		public function sites_edit()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_sites` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$this->load->view('admin/masters/sites.edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}
			
		}
		
		public function sites_updates()
		{
			$id=intval($this->uri->segment(4));
			isset($_POST['name']) && strlen($_POST['name'])<=100?$name=$_POST['name']:ajaxs(300,'参数错误');
			isset($_POST['url']) && trim($_POST['url'])!=''?$url=$_POST['url']:ajaxs(300,'参数错误');
			isset($_POST['joins']) && trim($_POST['joins'])!='' && is_numeric($_POST['joins'])?$join=intval($_POST['joins']):ajaxs(300,'参数错误');
			isset($_POST['counts']) && trim($_POST['counts'])!='' && is_numeric($_POST['counts'])?$counts=intval($_POST['counts']):ajaxs(300,'参数错误');
			isset($_POST['best']) && trim($_POST['best'])!='' && is_numeric($_POST['best'])?$best=intval($_POST['best']):ajaxs(300,'参数错误');
			isset($_POST['medium']) && trim($_POST['medium'])!='' && is_numeric($_POST['medium'])?$medium=intval($_POST['medium']):ajaxs(300,'参数错误');
			isset($_POST['negative']) && trim($_POST['negative'])!='' && is_numeric($_POST['negative'])?$negative=intval($_POST['negative']):ajaxs(300,'参数错误');
			
			
			$query=$this->db->query("select `id` from `cc_sites` where `id`='$id'");	
			if($query->num_rows()>0)
			{
				$_array=array(
					'name'=>$name,
					'url'=>$url,
					'join'=>$join,
					'counts'=>$counts,
					'best'=>$best,
					'medium'=>$medium,
					'negative'=>$negative,
				);
				$this->db->update('sites',$_array,array('id'=>$id));
				ajaxs(100,'更新成功');
			}
			else
			{
				ajaxs(300,'没有找到当前信息');	
			}	
		}
		
		public function sites_del()
		{
			$id=trim($this->input->post('id'),',');
			$arr=explode(',',$id);
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			foreach($arr as $i)
			{
				if($this->db->query("delete from `cc_sites` where `id`='$i'"))
				{
					$this->db->query("drop table `cc_comments_a".$i."`");
					$this->db->query("drop table `cc_comments_clicked_".$i."`");
					$this->db->query("drop table `cc_comments_count_".$i."`");
					$this->db->query("drop table `cc_comments_join_".$i."`");	
					$this->db->query("drop table `cc_comments_r".$i."`");	
				}	
			}	
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				ajaxs(100,'删除成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'删除失败，请稍后再试');	
			}
		}
	}