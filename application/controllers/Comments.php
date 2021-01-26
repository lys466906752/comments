<?php

	//对应的评论显示页面

	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Comments extends CI_Controller
	{
			
		public function __construct()
		{
			
			parent::__construct();	

		}
		
	
		//检测对应的信息
		protected function checkGo($_array,$comments_csrf='',$site_id='',$members='')
		{
			$returnMsg=true;
			//验证常规数组错误信息
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			//验证csrf信息
			if($comments_csrf!='' && !check_csrfToken($this->encrypt,$comments_csrf,$this->session))
			{
				$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
				jsonp_show($_array);
			}
			//检测站点id
			if($site_id!='')
			{
				$this->load->model('Comments_model','c');
				$res=$this->c->select_id_site($site_id);
				if(!$res)
				{
					$_array=array("code"=>300,"show"=>"站点信息有误，请联系管理员！");
					jsonp_show($_array);
				}
			}
			//检测对应会员信息
			if($members!='')
			{
				if($this->session->has_userdata('pcAuth'))
				{
					$members=json_decode($this->session->userdata('pcAuth'));
					$this->load->model('Members_model','m');
					$ress=$this->m->select_members_for_id($members->id);
					if($ress)
					{
						$returnMsg=$ress;
					}
					else
					{
						$_array=array("code"=>200,"show"=>"登录信息获取失败，请先登录！");
						jsonp_show($_array);		
					}
				}
				else
				{
					$_array=array("code"=>200,"show"=>"登录信息获取失败，请先登录！");
					jsonp_show($_array);		
				}
			}
			
			return $returnMsg;
		}		

		
		public static function getWebContents($szUrl)
		{
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $szUrl);
			curl_setopt($curl, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_ENCODING, '');
			$data = curl_exec($curl); 
			return $data;		
		}
		
		public function index()
		{
			$id=intval($this->uri->segment(3));
			$appKey=trim($this->uri->segment(4));
			$contents=str_replace("\r\n","",self::getWebContents(http_url()."comments/show/".$id."/".$appKey));

			echo "var result='".addslashes($contents)."'";
		}
		
		//Api的显示
		public function show()
		{
			$id=$this->uri->segment('3');
			$appKey=trim($this->uri->segment(4));
			$id=get_check($id);
			if(!$id)
			{
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'The application environment is not set correctly.';
				exit(1); // EXIT_ERROR
			}
			
			$this->load->model('Comments_model','c');
			$res=$this->c->select_site($id,$appkey='');
			if($res)
			{
				//针对对应的Api，做站点数据映射
				$this->c->create_table($id);
				
				$data['awards']=$this->db->query("select * from `cc_awards`");
				$data['comments_sid']=$res['id'];
				$data['comments_join']=$res['join'];
				$data['comments_counts']=$res['counts'];
				$data['face']=$this->db->query("select * from `cc_faces`");
				$data['res']=$res;
				
				$faceStr='';
				foreach($data['face']->result_array() as $arr)
				{
					if($faceStr=='')
					{
						$faceStr=$arr['name'].'____'.$arr['file'];
					}
					else
					{
						$faceStr=$faceStr.'===='.$arr['name'].'____'.$arr['file'];
					}
				}
				$data['faceStr']=$faceStr;
				
				$data['yins']=$this->db->query("select * from `cc_yins`");
				
				$yinStr='';
				foreach($data['yins']->result_array() as $arr)
				{
					if($yinStr=='')
					{
						$yinStr=$arr['name'].'____'.$arr['file'].'____'.$arr['money'].'____'.$arr['id'];
					}
					else
					{
						$yinStr=$yinStr.'===='.$arr['name'].'____'.$arr['file'].'____'.$arr['money'].'____'.$arr['id'];
					}
				}
				$data['yinStr']=$yinStr;
				
				$tmp=json_decode($res['template'],true);
				
				$this->load->view('use_'.$tmp['id'].'/comments.php',$data);
			}
			else
			{
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'The site is not found.';
				exit(1); // EXIT_ERROR	
			}
		}
		
		//获取单条的评论信息
		public function readitem()
		{
			$_array='';
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");	
			isset($_GET['site_id'])?$site_id=intval(trim($_GET['site_id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");	
			isset($_GET['id'])?$id=intval(trim($_GET['id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			$res=$this->checkGo($_array,$comments_csrf,$site_id,'');
			$this->load->helper('cache');
			$pagesize=10;
			$pageindex=intval($this->uri->segment(3));
			$sql="select * from `cc_comments_a".$site_id."` where `id`='$id'";
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$query=$this->db->query($sql);
			$data['array']=array();
			$a=0;
			$face=$this->db->query("select * from `cc_faces`");
			foreach($query->result_array() as $array)
			{
				$data['array'][$a]=$array;
				$data['array'][$a]['fulltext']=$this->createUbb($data['array'][$a]['fulltext'],$face);
				$data['array'][$a]['files']=json_decode($data['array'][$a]['files'],true);
				$data['array'][$a]['time']=self::createShowTime($data['array'][$a]['time']);
				$data['array'][$a]['retext']=$this->getReLists($data['array'][$a]['id'],$site_id,$face);
				$a++;	
			}
			
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$_array=array("code"=>100,"show"=>$data);
			jsonp_show($_array);
		}
		
		//读取对应的评论信息
		public function pages()
		{
			$_array='';
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");	
			isset($_GET['site_id'])?$site_id=intval(trim($_GET['site_id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");	
			isset($_GET['commentsTypeId']) && in_array($_GET['commentsTypeId'],array(0,1,2,3,4))?$commentsTypeId=htmlspecialchars(trim($_GET['commentsTypeId'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			$res=$this->checkGo($_array,$comments_csrf,$site_id,'');
			
			$where='';
			if($commentsTypeId==2)
			{
				$where.=" and `star`>3";	
			}
			elseif($commentsTypeId==3)
			{
				$where.=" and `star`=3";	
			}
			elseif($commentsTypeId==4)
			{
				$where.=" and `star`<3 and `star`>0";	
			}
			$pagesize=10;
			$pageindex=intval($this->uri->segment(3));
			$sql="select * from `cc_comments_a".$site_id."` where `id`>0 ".$where." order by `time` desc";
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$query=$this->db->query($sql);
			$data['array']=array();
			$a=0;
			$face=$this->db->query("select * from `cc_faces`");
			$this->load->helper('cache');
			foreach($query->result_array() as $array)
			{
				$data['array'][$a]=$array;
				$data['array'][$a]['fulltext']=$this->createUbb($data['array'][$a]['fulltext'],$face);
				$data['array'][$a]['files']=json_decode($data['array'][$a]['files'],true);
				$data['array'][$a]['time']=self::createShowTime($data['array'][$a]['time']);
				$data['array'][$a]['retext']=$this->getReLists($data['array'][$a]['id'],$site_id,$face);
				$a++;	
			}
			
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
					
			$_array=array("code"=>100,"show"=>$data);
			jsonp_show($_array);
			
		}
		
		//查询对应的评论信息
		private function getReLists($id,$site_id,$face)
		{
			
			$res=readFileCaches($id,$site_id,0);
			
			if($res)
			{
				return $res;
			}
			else
			{
				$res=$this->getForRe($id,0,$site_id,$face);
				$_array=[];
				for($i=0;$i<count($res);$i++)
				{
					$_array[$i]=$res[$i];
					$_array[$i]['reText']=$this->getForRe($id,$_array[$i]['id'],$site_id,$face);	
				}
				
				writeFileCacheContent($_array,$id,$site_id);
				return $_array;
			}
			
		}
		
		//递归查询对应的评论信息
		private function getForRe($id,$upid,$site_id,$face)
		{
			$query=$this->db->query("select * from `cc_comments_r".$site_id."` where `aid`='$id' and `upid`='$upid' order by `id` asc");
			$array=[];
			$i=0;
			
			foreach($query->result_array() as $arrays)
			{
				$array[$i]=$arrays;
				$array[$i]['fulltext']=$this->createUbb($array[$i]['fulltext'],$face);
				$i++;
			}
			
			return $array;
		}
		
		
		//查询对应的父级信息合集
		private function getRetext($id,$site_id,$face)
		{
			if(trim($id)=='')
			{
				return array();	
			}
			else
			{
				$array=array();
				$i=0;
				$query=$this->db->query("select `id`,`nickname`,`upid`,`pid`,`uid`,`avatar`,`star`,`fulltext`,`files`,`cai`,`ok`,`write`,`time` from `cc_comments_".$site_id."` where `id` in (".$id.") and `show`='2' order by `id` asc");
				foreach($query->result_array() as $arr)
				{
					$array[$i]=$arr;
					$array[$i]['files']=json_decode($array[$i]['files'],true);
					$array[$i]['write']=json_decode($array[$i]['write'],true);
					$array[$i]['fulltext']=$this->createUbb($array[$i]['fulltext'],$face);
					$i++;	
				}
				
				return $array;
			}	
		}
		
		//重新封装对应的输出json数据
		private function addCaiRes($array,$res)
		{
			$arr=array();
			
			for($i=0;$i<count($array);$i++)
			{
				$arr[$i]=$array[$i];
				$arr[$i]['retext']=self::selectCaiRes($array[$i]['retext'],$res);
			}
			
			return $arr;
		}
		
		public static function selectCaiRes($array,$res)
		{
			$arr=array();

			for($i=0;$i<count($array);$i++)
			{
				$arr[$i]=$array[$i];
				$id=$arr[$i]['id'];
				$arr[$i]['cai']=0;
				$arr[$i]['ok']=0;
				if(isset($res[$id]['id']) && isset($res[$id]['cai']) && isset($res[$id]['ok']))
				{
					$arr[$i]['cai']=$res[$id]['cai'];
					$arr[$i]['ok']=$res[$id]['ok'];	
				}	
			}	
			return $arr;
		}
		
		//根据对应的json串查询其中包含的ID信息
		private function getIds($json,$selectId)
		{
			$array=json_decode($json,true);
			$id='';
			
			$arr=array();
			if(trim($selectId,',')!='')
			{
				$arr=explode(',',trim($selectId,','));
			}
			
			if(is_array($array) && !empty($array))
			{
				for($i=0;$i<count($array);$i++)
				{
					if(!in_array($array[$i]['id'],$arr))
					{
						$id.=$array[$i]['id'].',';
					}
				}		
			}
			
			return $id;
		}
		
		//根据对应的ID查询对应的踩和大拇指的数据信息
		private function getCaiUp($id,$tableName)
		{
			
			$arr=array();
					
			if(trim($id,',')!='')
			{
				$query=$this->db->query("select `id`,`cai`,`ok` from `".$tableName."` where `id` in (".$id.")");
				
				foreach($query->result_array() as $array)
				{
					$id=$array['id'];
					$arr[$id]['id']=$id;
					$arr[$id]['cai']=$array['cai'];
					$arr[$id]['ok']=$array['ok'];
				}
			}
			return $arr;
		}
		
		//匹配对应的时间
		private function createShowTime($time)
		{
			if(date('Y-m-d')==date('Y-m-d',$time))
			{
				return '今天'.date(' H:i',$time);	
			}	
			else
			{
				return date('m-d H:i',$time);	
			}
		}
		
		//匹配对应的数组里面的所有表情
		private function createUbbAll($json,$faces)
		{
			$array=json_decode($json,true);
			$arr=array();
			$a=0;
			for($i=0;$i<count($array);$i++)
			{
				$arr[$a]=$array[$i];
				$arr[$a]['fulltext']=$this->createUbb($arr[$a]['fulltext'],$faces);
				$a++;
			}
			
			return $arr;	
		}
		
		//匹配对应的表情
		private function createUbb($contents,$faces)
		{
			foreach($faces->result_array() as $face)
			{
				$contents=str_replace('['.$face['name'].']','<img src="'.base_url().$face['file'].'">',$contents);	
			}
			return $contents;	
		}
		
		//提交踩一踩信息
		public function clicked()
		{
			
			$_array='';
		
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['cid']) && is_numeric($_GET['cid'])?$site_id=htmlspecialchars(trim($_GET['cid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['id']) && is_numeric($_GET['id'])?$id=htmlspecialchars(trim($_GET['id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['act']) && is_numeric($_GET['act']) && in_array($_GET['act'],array(1,2))?$act=htmlspecialchars(trim($_GET['act'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			$res=$this->checkGo($_array,$comments_csrf,$site_id,1);
			
			$this->db->trans_strict(false);
            $this->db->trans_begin();
			
			$query=$this->db->query("select * from `cc_comments_clicked_".$site_id."` where `uid`='".$res['id']."' and `cid`='$id' limit 1");
			
			if($query->num_rows()>0)
			{
				$this->db->trans_rollback();
				$_array=array("code"=>400,"show"=>"您已经点过赞，无需重复操作！");
				jsonp_show($_array);
			}
			else
			{
				$_array=array(
					'uid'=>$res['id'],
					'act'=>$act,
					'cid'=>$id,
					'time'=>time()
				);
				$this->db->insert('cc_comments_clicked_'.$site_id,$_array);
				
				$curd="`ok`=`ok`+1";
				$this->db->query("update `cc_comments_a".$site_id."` set ".$curd." where `id`='$id'");	
				
				if($this->db->trans_status()===true)
				{
					$this->db->trans_commit();
					$_array=array("code"=>100,"show"=>"success！");
					jsonp_show($_array);     
				}
				else
				{
					$this->db->trans_rollback();
					$_array=array("code"=>300,"show"=>"服务器连接出错啦，请稍后再试！");
					jsonp_show($_array);
				}
			}
			
		}
		

		
		//提交评论信息
		public function insert()
		{
				
			$_array='';
						
			isset($_GET['csrf_input_index']) && strlen($_GET["csrf_input_index"])<=1000?$csrf_input_index=htmlspecialchars(trim($_GET['csrf_input_index'])):$_array=array("code"=>300,"show"=>"说的内容有点多了，请控制下！");
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['cacheId'])?$upload_cache_id=htmlspecialchars(trim($_GET['cacheId'])):$upload_cache_id='';
			isset($_GET['xingXing']) && is_numeric($_GET['xingXing']) && in_array($_GET['xingXing'],array(1,2,3,4,5))?$hc_comments_show_id=htmlspecialchars(trim($_GET['xingXing'])):$hc_comments_show_id=4;
			isset($_GET['cid']) && is_numeric($_GET['cid'])?$site_id=intval(trim($_GET['cid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");

			
			$res=$this->checkGo($_array,$comments_csrf,$site_id,1);
			
			if($res['state']==2)
			{
				$_array=array("code"=>300,"show"=>"您已经被禁用，无法继续操作！");
				jsonp_show($_array);	
			}
			
			$csrf_input_index=clearBom($csrf_input_index);

			$this->db->trans_strict(false);
			$this->db->trans_begin();
			
			$_array=[
				'uid'=>$res['id'],
				'nickname'=>$res['nickname'],
				'avatar'=>$res['avatar'],
				'star'=>$hc_comments_show_id,
				'fulltext'=>$csrf_input_index,
				'files'=>json_encode($this->get_success_file($upload_cache_id)),
				're'=>0,
				'ok'=>0,
				'time'=>time(),
				'ip'=>get_ip()
			];
			
			$this->db->insert("comments_a".$site_id,$_array);
			$insertId=$this->db->insert_id();
			//信息添加成功
			
			//是否参与过，人数处理
			$join_updates='';
			
			$join=$this->db->query("select * from `cc_comments_join_".$site_id."` where `id`='".$res['id']."'");
			if($join->num_rows()<=0)
			{
				//没参与过，设置更新条件
				$_arrays=array(
					"id"=>$res['id']
				);
				$this->db->insert('cc_comments_join_'.$site_id,$_arrays);
				//插入到新的参与表中
				$join_updates=' ,`join`=`join`+1 ';
				
			}
			
			$type_updates='';
			if($hc_comments_show_id>3)
			{
				$type_updates=" ,`best`=`best`+1 ";	
			}
			elseif($hc_comments_show_id==3)
			{
				$type_updates=" ,`medium`=`medium`+1 ";	
			}
			elseif($hc_comments_show_id<3 && $hc_comments_show_id>0)
			{
				$type_updates=" ,`negative`=`negative`+1 ";	
			}
			//更新对应的站点表信息
			$this->db->query("update `cc_sites` set `counts`=`counts`+1 ".$join_updates.$type_updates." where `id`='$site_id'");
			
			//更新自己在当前站里面的评论总数
			$comments=$this->db->query("select * from `cc_comments_count_".$site_id."` where `id`='".$res['id']."'");
			if($comments->num_rows()<=0)
			{
				//新插入
				$_arrays=array(
					'id'=>$res['id'],
					'count'=>1,
					'count1'=>0
				);
				$this->db->insert('cc_comments_count_'.$site_id,$_arrays);
			}
			else
			{
				//更新
				$this->db->query("update `cc_comments_count_".$site_id."` set `count`=`count`+1 where `id`='".$res['id']."'");	
			}

			//设置好事务，并提交
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				$_array=array("code"=>100,"show"=>$insertId);
				jsonp_show($_array);     
			}
			else
			{
				$this->db->trans_rollback();
				$_array=array("code"=>300,"show"=>"服务器连接出错啦，请稍后再试！");
				jsonp_show($_array);
			}
				
		}
		
		//针对某条信息做回复
		public function resave()
		{
			$_array='';
			isset($_GET['contents']) && strlen($_GET["contents"])<=400?$contents=htmlspecialchars(trim($_GET['contents'])):$_array=array("code"=>300,"show"=>"您说的话有点多，请精简点吧！");
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$site_id=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['id']) && is_numeric($_GET['id'])?$id=intval(trim($_GET['id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['sendId']) && is_numeric($_GET['sendId'])?$sendId=intval(trim($_GET['sendId'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['upid']) && is_numeric($_GET['upid'])?$upid=intval(trim($_GET['upid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			$res=$this->checkGo($_array,$comments_csrf,$site_id,1);
			
			if($res['state']==2)
			{
				$_array=array("code"=>300,"show"=>"您已经被禁用，无法继续操作！");
				jsonp_show($_array);	
			}
			
			$official=1;
			if($res['site']==$site_id)
			{
				$official=2;	
			}
			
			$msgText='';
			$msgUid='';
			
			$state=$this->checkItemRes($id,$site_id,1);
			
			if(!$state)
			{
				$_array=array("code"=>300,"show"=>"没有找到要回复的信息，无法继续操作！");
				jsonp_show($_array);	
			}
			$msgUid=$state['uid'];
			$msgText=$state['fulltext'];
			
			$this->db->trans_strict(false);
			$this->db->trans_begin();
			
			$_array=[
				'official'=>$official,
				'aid'=>$id,
				'upid'=>0,
				'uid'=>$res['id'],
				'uname'=>$res['nickname'],
				'rid'=>0,
				'rname'=>'',
				'fulltext'=>$contents,
				'time'=>time(),
				'ip'=>get_ip()
			];
			
			if($sendId>0)
			{
				$state=$this->checkItemRes($sendId,$site_id,2);	
				if(!$state)
				{
					$_array=array("code"=>300,"show"=>"没有找到要回复的信息，无法继续操作！");
					jsonp_show($_array);	
				}
				else
				{
					$_array['upid']=$state['id'];
					if($upid!='' && $upid>0)
					{
						$_array['upid']=$upid;	
					}
					$_array['rid']=$state['uid'];
					$_array['rname']=$state['uname'];
					$msgUid=$state['uid'];
					$msgText=$state['fulltext'];	
				}
			}
			
			//执行添加操作
			$this->db->insert("comments_r".$site_id,$_array);
			$insertId=$this->db->insert_id();
			
			$this->db->query("update `cc_comments_a".$site_id."` set `re`=`re`+1 where `id`='$id'");
			
			
			//是否参与过，人数处理
			$join_updates='';
			
			$join=$this->db->query("select * from `cc_comments_join_".$site_id."` where `id`='".$res['id']."'");
			
			if($join->num_rows()<=0)
			{
				//没参与过，设置更新条件
				$_arrays=array(
					"id"=>$res['id']
				);
				$this->db->insert('cc_comments_join_'.$site_id,$_arrays);
				
				//插入到新的参与表中
				$join_updates=' `join`=`join`+1 ';
			
				$this->db->query("update `cc_sites` set ".$join_updates." where `id`='$site_id'");
			}
			
			//更新自己在当前站里面的评论总数
			$comments=$this->db->query("select * from `cc_comments_count_".$site_id."` where `id`='".$res['id']."'");
			if($comments->num_rows()<=0)
			{
				$_arrays=array(
					'id'=>$res['id'],
					'count'=>0,
					'count1'=>1
				);
				$this->db->insert('cc_comments_count_'.$site_id,$_arrays);
			}
			else
			{
				$this->db->query("update `cc_comments_count_".$site_id."` set `count1`=`count1`+1 where `id`='".$res['id']."'");	
			}
			
			//设置好事务，并提交
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				
				$array=array(
					array(
						"id"=>date('YmdHis').substr(microtime(),2,8),
						'nickname'=>$res['nickname'],
						'time'=>time(),
						'showText'=>$contents,
						'yousText'=>$msgText,
					)
				);
				writeMsg($site_id,$msgUid,$array);
				$_array=array("code"=>100,"show"=>$insertId);
				
				$this->load->helper('cache');
				clearFileCachePHP($site_id,$id);//清除一下这个缓存文件
				
				jsonp_show($_array);     
			}
			else
			{
				$this->db->trans_rollback();
				$_array=array("code"=>300,"show"=>"亲，服务器好忙，请稍后再试试！");
				jsonp_show($_array);
			}
			
			
		}
		
		//检测对应的评论信息是否存在
		private function checkItemRes($id,$site_id,$act)
		{
			$sql="select * from `cc_comments_a".$site_id."` where `id`='$id'";
			if($act==2)
			{
				$sql="select * from `cc_comments_r".$site_id."` where `id`='$id'";	
			}
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				return $query->row_array();
			}
			return false;	
		}
		
		
		//获取回复之上的Jason数据
		private function getUpJson($res)
		{
			$array=array(
				'id'=>$res['id'],
				'uid'=>$res['uid'],
				'nickname'=>$res['nickname'],
				'avatar'=>$res['avatar'],
				'star'=>$res['star'],
				'fulltext'=>$res['fulltext'],
			);	
			
			$Jsons=json_decode($res['retext'],true);
			
			if(is_array($Jsons) && !empty($Jsons))
			{
				$Jsons[]=$array;
				
				return json_encode($Jsons);
			}

			
			return json_encode(array($array));
			
		}
		
		//获取对应的图片信息
		private function get_success_file($id='')
		{
			if($id!='')
			{
				$array=array();
				$arr=explode(",",$id);
				$a=0;
				foreach($arr as $k=>$v)
				{
					if(trim($v)!='')
					{
						$res=self::move_file($v);
						if($res)
						{	
							$array[$a]['img']=$res;	
							$a++;
						}
					}	
				}
				return $array;	
			}
			else
			{
				return array();	
			}
		
		}
		
		
			
	}
	




