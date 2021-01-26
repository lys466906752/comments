<?php

	//后台站点普通会员管理控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Members extends Ci
	{
		
		public $ajaxLoginArray=['index_ajax','inserts','updates'];
		
		public $IframeLoginArray=['avatar_upload'];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
		
		public function edit()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$id=intval($this->uri->segment(4));
			$data['act']=$this->uri->segment(5);
			$query=$this->db->query("select * from `cc_members` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$this->load->view('admin/members/edit.php',$data);
			}	
			else
			{
				error('抱歉：没有找到对应会员信息');	
			}
		}
		
		public function index()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			isset($_REQUEST["state"]) && trim($_REQUEST["state"])!=""?$data["state"]=trim($_REQUEST["state"]):$data["state"]='';
			$this->load->view('admin/members/index.php',$data);	
		}
		
		public function index_ajax()
		{
			$pagesize=12;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			isset($_REQUEST["state"]) && trim($_REQUEST["state"])!=""?$state=trim($_REQUEST["state"]):$state="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`mobile`='$keywords' or `nickname`='$keywords')";
			}
			if(in_array($state,array(1,2)))
			{
				$where.=" and `state`='$state'";	
			}
			
			$sql="select * from `cc_members` where `identity`=1 ".$where." order by `login_time` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);	
			
			$this->load->view("admin/members/index.ajax.php",$data);	
		}
		
		public function add()
		{
			
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('admin/members/add.php',$data);
				
		}
		
				
		//添加管理员程序处理
		public function inserts()
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
					'identity'=>1,
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
		
		public function updates()
		{
			$id=intval($this->uri->segment(4));
			isset($_POST['mobile_b'])?$mobile=htmlspecialchars(trim($_POST['mobile_b'])):ajaxs(300,'参数错误');	
			isset($_POST['nickname_b']) && strlen($_POST['nickname_b'])<=20?$nickname=$_POST['nickname_b']:ajaxs(300,'参数错误');
			isset($_POST['money']) && is_numeric($_POST['money']) && intval($_POST['money'])>=0?$money=intval($_POST['money']):ajaxs(300,'参数错误');	
			isset($_POST['avatar'])?$avatar=htmlspecialchars(trim($_POST['avatar'])):ajaxs(300,'参数错误');
			isset($_POST['state'])?$state=htmlspecialchars(trim($_POST['state'])):ajaxs(300,'参数错误');
			
			$passwd='';
			if(isset($_POST['passwd_b']) && strlen($_POST['passwd_b'])>=6 && strlen($_POST['passwd_b'])<=16)
			{
				$passwd=htmlspecialchars(trim($_POST['passwd_b']));	
			}
			
			$id=intval($this->uri->segment(4));
			if($mobile!='')
			{
				$query=$this->db->query("select `id` from `cc_members` where `id`!='$id' and `mobile`='$mobile' limit 1");
				if($query->num_rows()>0)
				{
					ajaxs(300,'当前手机号被被占用，请更换');
				}
			}
			$_array=array(
				'nickname'=>$nickname,
				'mobile'=>$mobile,
				'avatar'=>$avatar,
				'money'=>$money,
				'state'=>$state,
			);
			
			if($passwd!='')
			{
				$_array['passwd']=$passwd;	
			}
			
			$this->db->update('members',$_array,array("id"=>$id));
			ajaxs(100,'更新成功');
		}
		
		//删除所选的会员信息
		public function del()
		{
			$id=trim($this->input->post('id'),',');
			$arr=explode(',',$id);
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			$array=array();
			foreach($arr as $i)
			{
				$query=$this->db->query("select `id` from `cc_members` where `id`='$i'");
				if($query->num_rows()>0)
				{
					$result=$query->row_array();
					$array[]=$result['id'];
					$this->db->query("delete from `cc_members` where `id`='$i'");
				}
			}
			$querys=$this->db->query("select `id` from `cc_sites`");
			foreach($querys->result_array() as $arrays)
			{
				$siteid=$arrays["id"];
				$table_a='cc_comments_a'.$arrays["id"];
				$table_b='cc_comments_clicked_'.$arrays["id"];
				$table_c='cc_comments_count_'.$arrays["id"];
				$table_d='cc_comments_join_'.$arrays["id"];
				$table_e='cc_comments_r'.$arrays["id"];
				foreach($array as $k=>$uid)
				{
					$this->db->query("delete from `".$table_a."` where `uid`='$uid'");	
					$this->db->query("delete from `".$table_b."` where `uid`='$uid'");
					$this->db->query("delete from `".$table_c."` where `id`='$uid'");
					$this->db->query("delete from `".$table_d."` where `id`='$uid'");
					$this->db->query("delete from `".$table_e."` where `uid`='$uid'");
					$this->db->query("delete from `".$table_e."` where `rid`='$uid'");
					
					//查询出对应的uid发布的信息，并根据uid删除对应的消息
					$qy=$this->db->query("select `id` from `".$table_a."` where `uid`='$uid'");
					foreach($qy->result_array() as $res)
					{
						$this->delItem($res['id'],$siteid);	
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
		
		//单条删除
		private function delItem($id,$siteid)
		{
			$this->db->query("delete from `cc_comments_r".$siteid."` where `aid`='$id'");
		}
		
		public function avatar_upload()
		{
			if(isset($_FILES['files']['name']) && $_FILES['files']['name']!='')
			{
				$this->load->library("imgsclass");		

				$file=$this->imgsclass->upload($_FILES['files'],$msg,'',array("cutState"=>true,'cutMaxWidth'=>100,'cutMaxHeight'=>100,'uploadExtName'=>array('gif','png','jpg')));	
				if($file)
				{
					
					iframeshow("100",$file);

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
		
	}