<?php

	//站点对应的控制器
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Sites extends Ci
	{

		public $ajaxLoginArray=['del','inserts','updates'];
		
		public $IframeLoginArray=['avatar_upload'];		
		
		public function __construct()
		{
			parent::__construct();
			
			$this->authLogin();	
		}
		
		public function index()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			$this->load->view('masters/sites/index.php',$data);	
		}
		
		public function index_ajax()
		{
			$pagesize=12;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`s`.`name`='$keywords' or `s`.`url`='$keywords' or `s`.`appkey`='$keywords')";
			}
			
			$sql="select `s`.* from `cc_sites` as `s`  where `s`.`id`>0 ".$where." order by `s`.`id` desc";
			
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$this->load->view("masters/sites/index.ajax.php",$data);	
		}
		
		public function add()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):$data["pageindex"]=1;
			
			$data['tmp']=$this->db->query("select * from `cc_template`");
			
			$this->load->view('masters/sites/add.php',$data);	
		}
		
		public function inserts()
		{
			
			$changeSession=false;
			$query=$this->db->query("select * from `cc_sites` where `uid`='".$this->adminInfos['id']."' limit 1");
			if($query->num_rows()<=0)
			{
				$changeSession=true;	
			}
			
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			
			isset($_POST['name']) && trim($_POST['name'])!=''?$name=$_POST['name']:ajaxs(300,'参数错误');
			isset($_POST['url']) && trim($_POST['url'])!=''?$url=$_POST['url']:ajaxs(300,'参数错误');	
			isset($_POST['temp']) && trim($_POST['temp'])!=''?$temp=$_POST['temp']:ajaxs(300,'参数错误');	
			$as=explode('_',$temp);
			$temp=$as[0];
			$query=$this->db->query("select * from `cc_template` where `id`='$temp'");
			if($query->num_rows()<=0)
			{
				ajaxs(300,'模板信息读取出错');	
			}
			$res=$query->row_array();
			$template=['id'=>$res['id'],'name'=>$res['name'],'color'=>$res['color']];
			$template=json_encode($template);
			//echo $template;die();
			
			$_array=array(
				"name"=>$name,
				"uid"=>$this->adminInfos['id'],
				"appkey"=>uniqid(),
				"url"=>$url,
				"join"=>0,
				"counts"=>0,
				"best"=>0,
				"medium"=>0,
				"negative"=>0,
				"time"=>time(),
				"template"=>$template
			);
			$this->db->insert("sites",$_array);
			$id=$this->db->insert_id();
			
			$this->db->query("update `cc_members` set `site`=`site`+1 where `id`='".$this->adminInfos['id']."'");//更新对应下面的站点信息
			
			$createTableA="CREATE TABLE `cc_comments_a".$id."` (
			 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论信息ID',
			 `nickname` varchar(20) NOT NULL COMMENT '用户昵称',
			 `avatar` varchar(80) NOT NULL COMMENT '用户头像',
			 `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
			 `star` enum('1','2','3','4','5') NOT NULL COMMENT '评分',
			 `fulltext` text NOT NULL COMMENT '回复内容',
			 `files` text COMMENT '上传的图片，Jason格式',
			 `ok` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '大拇指的数量',
			 `re` bigint(20) unsigned NOT NULL COMMENT '回复Ta的数量',
			 `time` int(10) unsigned NOT NULL COMMENT '发布的时间戳',
			 `ip` varchar(15) DEFAULT NULL COMMENT 'IP地址',
			 PRIMARY KEY (`id`),
			 KEY `uid` (`uid`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='评论表".$id."'";
			
			$this->db->query($createTableA);
			
			$createTableB="CREATE TABLE `cc_comments_clicked_".$id."` (
			 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID主键',
			 `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
			 `cid` int(10) unsigned NOT NULL COMMENT '对应的信息ID',
			 `act` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1.踩一踩2.大拇指',
			 `time` int(10) unsigned NOT NULL COMMENT '操作时间',
			 PRIMARY KEY (`id`),
			 KEY `uid` (`uid`,`cid`,`act`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='踩一踩和大拇指表".$id."'";
			$this->db->query($createTableB);
			
			$createTableC="CREATE TABLE `cc_comments_count_".$id."` (
			 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID主键',
			 `count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论条数',
			 `count1` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论条数',
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='用户对每个站的评论总记录".$id."'";
			$this->db->query($createTableC);
			
			$createTableD="	CREATE TABLE `cc_comments_join_".$id."` (
			 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID主键',
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='是否参与表".$id."'";
			$this->db->query($createTableD);
			
			$createTableE="	CREATE TABLE `cc_comments_r".$id."` (
			 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '回复表ID',
			 `official` TINYINT(1) unsigned NULL DEFAULT '1' COMMENT '是否官方回复1.否2.是',
			 `aid` int(10) unsigned NOT NULL COMMENT '对应的评论ID',
			 `upid` int(10) unsigned NOT NULL COMMENT '对应的评论信息ID',
			 `uid` int(10) unsigned NOT NULL COMMENT '对应的用户ID',
			 `uname` varchar(20) DEFAULT NULL COMMENT '发布人的昵称',
			 `rid` int(11) DEFAULT '0' COMMENT '被回复人的ID',
			 `rname` varchar(20) DEFAULT NULL COMMENT '被回复人的昵称',
			 `fulltext` varchar(100) NOT NULL COMMENT '回复内容',
			 `time` int(11) NOT NULL COMMENT '回复的时间',
			 `ip` varchar(15) DEFAULT NULL COMMENT 'IP地址',
			 PRIMARY KEY (`id`),
			 KEY `upid` (`aid`,`upid`,`uid`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='回复表信息".$id."'";
			$this->db->query($createTableE);
			
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				
				//用户没有站点的时候进行补位
				if($changeSession)
				{
					$pcAuth=json_decode($this->session->userdata('pcAuth'),true);
					$pcAuth['siteId']=$id;
					$this->session->set_userdata('pcAuth',json_encode($pcAuth));
				}
				
				ajaxs(100,'创建成功');	    
			}
			else
			{
				$this->db->trans_rollback();
				$_ajaxs(300,'创建失败，请稍后再试');	
			}			
		}
		
		public function edit()
		{
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$data["keywords"]=trim($_REQUEST["keywords"]):$data["keywords"]="";
			isset($_REQUEST["pageindex"]) && trim($_REQUEST["pageindex"])!=""?$data["pageindex"]=trim($_REQUEST["pageindex"]):			$data["pageindex"]=1;
			
			$data['tmp']=$this->db->query("select * from `cc_template`");
			
			$id=intval($this->uri->segment(4));
			$query=$this->db->query("select * from `cc_sites` where `id`='$id' and `uid`='".$this->adminInfos['id']."'");
			if($query->num_rows()>0)
			{
				$data['result']=$query->row_array();
				$this->load->view('masters/sites/edit.php',$data);
			}
			else
			{
				error('抱歉：没有找到要修改的信息');exit();	
			}	
		}
		
		public function updates()
		{
			$id=intval($this->uri->segment(4));
			isset($_POST['name']) && strlen($_POST['name'])<=100?$name=$_POST['name']:ajaxs(300,'参数错误');
			isset($_POST['url']) && trim($_POST['url'])!=''?$url=$_POST['url']:ajaxs(300,'参数错误');
			isset($_POST['joins']) && trim($_POST['joins'])!='' && is_numeric($_POST['joins'])?$join=intval($_POST['joins']):ajaxs(300,'参数错误');
			isset($_POST['counts']) && trim($_POST['counts'])!='' && is_numeric($_POST['counts'])?$counts=intval($_POST['counts']):ajaxs(300,'参数错误');
			isset($_POST['best']) && trim($_POST['best'])!='' && is_numeric($_POST['best'])?$best=intval($_POST['best']):ajaxs(300,'参数错误');
			isset($_POST['medium']) && trim($_POST['medium'])!='' && is_numeric($_POST['medium'])?$medium=intval($_POST['medium']):ajaxs(300,'参数错误');
			isset($_POST['negative']) && trim($_POST['negative'])!='' && is_numeric($_POST['negative'])?$negative=intval($_POST['negative']):ajaxs(300,'参数错误');
			isset($_POST['temp']) && trim($_POST['temp'])!=''?$temp=$_POST['temp']:ajaxs(300,'参数错误');	
			$as=explode('_',$temp);
			$temp=$as[0];
			$query=$this->db->query("select * from `cc_template` where `id`='$temp'");
			if($query->num_rows()<=0)
			{
				ajaxs(300,'模板信息读取出错');	
			}
			$res=$query->row_array();
			$template=['id'=>$res['id'],'name'=>$res['name'],'color'=>$res['color']];
			$template=json_encode($template);
			
			
			
			$query=$this->db->query("select `id` from `cc_sites` where `id`='$id' and `uid`='".$this->adminInfos['id']."'");	
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
					"template"=>$template
				);
				$this->db->update('sites',$_array,array('id'=>$id));
				ajaxs(100,'更新成功');
			}
			else
			{
				ajaxs(300,'没有找到当前信息');	
			}				
		}
		
		public function del()
		{
			$id=trim($this->input->post('id'),',');
			$arr=explode(',',$id);
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			foreach($arr as $i)
			{
				if($this->db->query("delete from `cc_sites` where `id`='$i' and `uid`='".$this->adminInfos['id']."'"))
				{
					$this->db->query("drop table `cc_comments_a".$i."`");
					$this->db->query("drop table `cc_comments_clicked_".$i."`");
					$this->db->query("drop table `cc_comments_count_".$i."`");
					$this->db->query("drop table `cc_comments_join_".$i."`");	
				}	
			}	
			
			$query=$this->db->query("select `id` from `cc_sites` where `uid`='".$this->adminInfos['id']."'");
			$this->db->query("update `cc_members` set `site`='".$query->num_rows()."' where `id`='".$this->adminInfos['id']."'");//查询出当前会员下面的站点信息，并更新到对应的会员信息中
			
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
		
		//下载映射文件
		public function downloads()
		{
			$file = FCPATH.'junyiSay.php';
			
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
	}