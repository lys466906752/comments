<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Members extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();		
		}
		

		//远程获取对应的图片信息
		public function get_avatar($urls,$pic)
		{
			if($urls=="")
			{
				return $pic;
			}
			$ch=curl_init();
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_URL, $urls );
			ob_start();
			curl_exec( $ch );
			$return_content = ob_get_contents ();
			ob_end_clean();
			if(!is_null($return_content))
			{
				$dir=FCPATH.'upload/'.date('Ymd');
				if(!is_dir($dir))
				{
					mkdir($dir);
				}
				
				$dir=$dir.'/'.date('d');
				if(!is_dir($dir))
				{
					mkdir($dir);
				}
			
				$pic=$dir."/".date("YmdHis").substr(microtime(),2,8).'.png';
				$file=fopen($pic,'w');
				fwrite($file,$return_content);
				fclose($file);
				return str_replace(FCPATH,'',$pic);
					
			}			
			return $pic;
		}
		
		//qq登录
		public function qq()
		{
			if($this->session->has_userdata('pcAuth'))
			{
				unset($_SESSION['pcAuth']);
				//errorDomainSay(200,$url,'sanfangLogin','登录状态已失效');	
			}
			$url=htmlspecialchars($_GET['url'])."/junyiSay.php";
			
			$_SESSION['urlGo']=$url;
			unset($_SESSION['backurl']);
				
			if(isset($_GET['backurl']) && trim($_GET['backurl'])!='')
			{
				$_SESSION['backurl']=trim($_GET['backurl']);	
			}
			
		
			$this->load->view("members/qq.php");	
		}
		
		//qq登录回调
		public function backqq()
		{
			require_once(FCPATH."API/qqConnectAPI.php");
			$qc = new QC();				
			
			$urls=$_SESSION['urlGo'];
			unset($_SESSION['urlGo']);
			
			$urlback="";
			if(isset($_SESSION['backurl']))
			{
				$urlback=$_SESSION['backurl'];
				unset($_SESSION['backurl']);	
			}
			$tokens=$qc->qq_callback();
			$users["openid"]=$qc->get_openid();
	
			$qc1 = new QC($tokens,$users["openid"]);
			
			$msgs = $qc1->get_user_info();
			$this->load->model('Members_model','m');
			$query=$this->db->query("select * from `cc_members` where `qqId`='".$users["openid"]."' limit 1");
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				///echo '<pre>';
				///print_r($res);die();
				$_array=array(
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'token'=>get_token()							
				);
				$this->m->updateOneRow($_array,$res['id']);	
				
				$res['commentCount']=0;//获取对应的评论条数
				
				$this->session->set_userdata('pcAuth',json_encode(array_merge($res,$_array)));
				
				//开始做一个登录检测操作，然后送分
				if(date('Y-m-d',$res['login_time'])!=date('Y-m-d'))
				{
					$this->load->model('Awards_model','a');
					$inters=$this->a->getAwards(3);
					$this->db->query("update `cc_members` set `money`=`money`+'$inters' where `id`='".$res['id']."'");
				}							
				
				
				//echo $urls;die();
				//登录成功，开始做页面关闭处理		
				//echo '<pre>';
				//print_r($_SESSION);exit();
				header("location:".$urls."?func=sanfangLogin&code=100&str=success&urlback=".$urlback);exit();
				
			}	
			else
			{
				//开始注册数据，并登录
				$passwd=mt_rand(100000,999999);

				$nickname=select_config_rands('site','nicknameInit');
				if(isset($msgs["nickname"]) && trim($msgs["nickname"])!='')
				{
					$nickname=$msgs["nickname"];		
				}
				
				$avatar=select_config_rands('site','avatarInit');
				if(isset($msgs['figureurl_1']) && trim($msgs['figureurl_1'])!='')
				{
					$avatar=$this->get_avatar($msgs['figureurl_1'],$avatar);
				}
				
				//echo $avatar."_______".$nickname;die();
				
				$this->load->model('Members_model','m');
				if($this->m->reg($passwd,$nickname,$avatar,$users["openid"],1,$res))
				{
					$this->session->set_userdata('pcAuth',json_encode($res));
					
					$this->load->model('Awards_model','a');
					$inters=$this->a->getAwards(3);
					$this->db->query("update `cc_members` set `money`=`money`+'$inters' where `id`='".$res['id']."'");
					//header("location:".http_url());exit();
					header("location:".$urls."?func=sanfangLogin&code=100&str=success&urlback=".$urlback);exit();
				}
				else
				{
					header("location:".$urls."?func=sanfangLogin&code=100&str=登录失败，请过五分钟后再试&urlback=".$urlback);exit();
				}					
			}
		}
		
		//新浪登录
		public function sina()
		{
			if($this->session->has_userdata('pcAuth'))
			{
				unset($_SESSION['pcAuth']);
				//errorDomainSay(200,$url,'sanfangLogin','登录状态已失效');	
			}
			$url=htmlspecialchars($_GET['url'])."/junyiSay.php";
			$_SESSION['urlGo']=$url;
			unset($_SESSION['backurl']);
			if(isset($_GET['backurl']) && trim($_GET['backurl'])!='')
			{
				$_SESSION['backurl']=trim($_GET['backurl']);	
			}
			
			$this->load->view("members/sina.php");	
		} 
		
		//新浪登录成功回调
		public function backsina()
		{
			include_once( FCPATH.'weibos/config.php' );
			include_once( FCPATH.'weibos/saetv2.ex.class.php' );
			$urls=$_SESSION['urlGo'];
			unset($_SESSION['urlGo']);
			$urlback="";
			if(isset($_SESSION['backurl']))
			{
				$urlback=$_SESSION['backurl'];
				unset($_SESSION['backurl']);	
			}
			$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
			$this->load->model('Members_model','m');
			$web_key=WB_AKEY;
			$web_sec=WB_SKEY;
			if (isset($_REQUEST['code'])) {
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = WB_CALLBACK_URL;
				try {
					$token = $o->getAccessToken( 'code', $keys ) ;
					$_SESSION['token'] = $token;
				} catch (OAuthException $e) {
				}
			}
			
			if ($token)
			{
				$c = new SaeTClientV2($web_key,$web_sec,$token['access_token']);
				$ms =$c->home_timeline();
				$uid_get = $c->get_uid();//获取u_id
				$uid = $uid_get['uid'];
				
				$user_message = $c->show_user_by_id($uid);//获取用户信息
				$users["openid"]=$uid;
				$query=$this->db->query("select * from `cc_members` where `sinaId`='".$users["openid"]."' limit 1");
				if($query->num_rows()>0)
				{
					$res=$query->row_array();
					$_array=array(
						'login_time'=>time(),
						'login_ip'=>get_ip(),
						'token'=>get_token()							
					);
					$this->m->updateOneRow($_array,$res['id']);	

					
					$res['commentCount']=0;//获取对应的评论条数
					
					$this->session->set_userdata('pcAuth',json_encode(array_merge($res,$_array)));
					
					//开始做一个登录检测操作，然后送分
					if(date('Y-m-d',$res['login_time'])!=date('Y-m-d'))
					{
						$this->load->model('Awards_model','a');
						$inters=$this->a->getAwards(3);
						$this->db->query("update `cc_members` set `money`=`money`+'$inters' where `id`='".$res['id']."'");
					}							
					
					header("location:".$urls."?func=sanfangLogin&code=100&str=success&urlback=".$urlback);exit();
					//登录成功，开始做页面关闭处理
					/*echo "<script>window.opener=null;window.open('','_self');window.close();</script>";exit();*/
				}
				else
				{
					//开始注册数据，并登录
					$passwd=mt_rand(100000,999999);
					
					$nickname=select_config_rands('site','nicknameInit');
					if(isset($user_message['name']) && trim($user_message['name'])!='')
					{
						$nickname=$user_message['name'];		
					}
					
					$avatar=select_config_rands('site','avatarInit');
					if(isset($user_message['avatar_hd']) && trim($user_message['avatar_hd'])!='')
					{
						$avatar=$this->get_avatar($user_message['avatar_hd'],$avatar);
					}
					
					if($this->m->reg($passwd,$nickname,$avatar,$users["openid"],2,$res))
					{
						$this->session->set_userdata('pcAuth',json_encode($res));
						
						$this->load->model('Awards_model','a');
						$inters=$this->a->getAwards(3);
						$this->db->query("update `cc_members` set `money`=`money`+'$inters' where `id`='".$res['id']."'");
						header("location:".$urls."?func=sanfangLogin&code=100&str=success&urlback=".$urlback);exit();
						/*echo "window.opener=null;window.open('','_self');window.close();";exit();*/	
					}
					else
					{
						header("location:".$urls."?func=sanfangLogin&code=100&str=登录失败，请过五分钟后再试&urlback=".$urlback);exit();
					}						
				}
				
			}
			else
			{
				header("location:".$urls."?func=sanfangLogin&code=100&str=获取新浪官方授权数据失败，请过五分钟后再试&urlback=".$urlback);exit();
			}				
		}
		
		
		//发送登录的密码
		public function captcha()
		{
			$_array='';
			
			isset($_GET['comments_login_mobile']) && preg_match("/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/",$_GET["comments_login_mobile"],$m)?$comments_login_mobile=htmlspecialchars(trim($_GET['comments_login_mobile'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			if($this->session->has_userdata('pcCaptchaTime'))
			{
				if(!checkDotime($this->session->userdata('pcCaptchaTime'),select_config('site','captchaMax')))
				{
					$_array=array("code"=>300,"show"=>"您发送的频率太快，请稍后再试！");
				}
			}
			
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					$this->load->model('Members_model','m');	
					$res=$this->m->select_members_for_mobile($comments_login_mobile);
					if($res)
					{
						if(checkDotime($res['passwdtime'],select_config('site','captchaMax')))
						{
							
							$passwd=mt_rand(100000,999999);
							if($this->m->passwd($passwd,$comments_login_mobile,'','',$res['id']))
							{
								$this->session->set_userdata('pcCaptchaTime',time());
								
								send_msg("JSM42313-0001",$comments_login_mobile,"@1@=$passwd");
								
								$_array=array("code"=>100,"show"=>"密码已经发送成功！");
								jsonp_show($_array);	
							}
							else
							{
								$_array=array("code"=>300,"show"=>"网络连接失败，请您稍后再试！");
								jsonp_show($_array);	
							}
							
						}
						else
						{
							$_array=array("code"=>300,"show"=>"您发送的频率太快，请稍后再试！");
							jsonp_show($_array);
						}
					}
					else
					{
						$passwd=mt_rand(100000,999999);
						
						$nickname=select_config_rands('site','nicknameInit');
						
						$avatar=select_config_rands('site','avatarInit');
						
						if($this->m->passwd($passwd,$comments_login_mobile,$nickname,$avatar))
						{
							$this->session->set_userdata('pcCaptchaTime',time());
							
							send_msg("JSM42313-0001",$comments_login_mobile,"@1@=$passwd");
							
							$_array=array("code"=>100,"show"=>"密码已经发送成功！");
							jsonp_show($_array);	
						}
						else
						{
							$_array=array("code"=>300,"show"=>"网络连接失败，请您稍后再试！");
							jsonp_show($_array);	
						}	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);
				}
			}
			
		}
		
		//用户登录
		public function login()
		{
			$_array='';
			
			isset($_GET['comments_login_mobile']) && preg_match("/^(13[0-9]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|4|5|6|8|9|7]|17[0|1|2|3|4|5|6|8|9|7])\d{8}$/",$_GET["comments_login_mobile"],$m)?$comments_login_mobile=htmlspecialchars(trim($_GET['comments_login_mobile'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['comments_login_passwd']) && strlen($_GET["comments_login_passwd"])>=6 && strlen($_GET["comments_login_passwd"])<=18?$comments_login_passwd=htmlspecialchars(trim($_GET['comments_login_passwd'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$sid=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					$this->load->model('Members_model','m');
					$res=$this->m->select_members_for_mobile($comments_login_mobile);
					if($res)
					{
						if($res['passwd']==$comments_login_passwd)
						{
							$_array=array(
								'login_time'=>time(),
								'login_ip'=>get_ip(),
								'token'=>get_token()							
							);
							$this->m->updateOneRow($_array,$res['id']);
							
							$this->load->model('Comments_count_model','c');
							
							$res['commentCount']=$this->c->get_samcount($res['id'],$sid,$count1);//获取对应的评论条数
							
							$this->session->set_userdata('pcAuth',json_encode(array_merge($res,$_array)));
							
							//开始做一个登录检测操作，然后送分
							if(date('Y-m-d',$res['login_time'])!=date('Y-m-d'))
							{
								$this->load->model('Awards_model','a');
								$inters=$this->a->getAwards(3);
								$this->db->query("update `cc_members` set `money`=`money`+'$inters' where `id`='".$res['id']."'");
							}
							
							
							$_array=array("code"=>100,"show"=>"登录成功！");
							jsonp_show($_array);	
						}
						else
						{
							$_array=array("code"=>300,"show"=>"您登录的账号或密码不正确！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>300,"show"=>"您登录的账号或密码不正确！");
						jsonp_show($_array);
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);
				}
				
			}
				
		}
		
		//读取其他会员的信息
		public function infodata()
		{
			$_array='';
			
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['id']) && is_numeric($_GET['id'])?$id=intval(trim($_GET['id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['sid']) && is_numeric($_GET['sid'])?$sid=intval(trim($_GET['sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
		
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					
					$query=$this->db->query("select `id`,`nickname`,`avatar`,`login_time` from `cc_members` where `id`='$id'");
					if($query->num_rows()>0)
					{
						$result=$query->row_array();
						$this->load->model('Comments_count_model','c');
						$result['count']=$this->c->get_samcount($id,$sid,$count1);//获取对应的评论条数
						$result['count1']=$count1;
						$result['login_time']=self::getEndTimeShow($result['login_time']);
						$_array=array("code"=>100,"show"=>$result);
						jsonp_show($_array);
					}
					else
					{
						$_array=array("code"=>300,"show"=>"抱歉：没有找到会员信息，请稍后再试！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);	
				}
			}
		}
		
		//获取最后的登录时间
		public static function getEndTimeShow($time)
		{
			if($time<=0 || time()-$time<=300)
			{
				return '刚刚';	
			}	
			elseif(date('Y-m-d',$time)==date('Y-m-d'))
			{
				return '今天 '.date('H:i',$time);		
			}
			elseif(date('Y-m-d',$time)==date('Y-m-d',time()-3600*24*24))
			{
				return '昨天 '.date('H:i',$time);		
			}
			else
			{
				return date('m-d',$time);	
			}
		}
		
		//读取对应的会员登录状态信息
		public function infos()
		{
			$_array='';
			
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$sid=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			if(is_array($_array))
			{
				jsonp_show($_array);
			}	
			else
			{
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					if($this->session->has_userdata('pcAuth'))
					{
						$members=json_decode($this->session->userdata('pcAuth'));
						$this->load->model('Members_model','m');
						$res=$this->m->select_members_for_id($members->id);
						if($res)
						{
							$this->load->model('Comments_count_model','c');
							$res['commentCount']=$this->c->get_samcount($res['id'],$sid,$count1);//获取对应的评论条数
							$res['count1']=$count1;
							$res['msgCount']=getMsgCount($sid,$res['id']);//获取一下用户的未读消息数量
							$_array=array("code"=>100,"show"=>$res);
							jsonp_show($_array);	
						}
						else
						{
							$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);	
				}
			}
		}
		
		//修改用户昵称
		public function nickname()
		{
			$_array='';
			
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['nickname']) && strlen($_GET['nickname'])<30?$nickname=htmlspecialchars(trim($_GET['nickname'])):$_array=array("code"=>300,"show"=>"字数太长，请稍后再试！");
			
			if(is_array($_array))
			{
				jsonp_show($_array);
			}	
			else
			{
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					if($this->session->has_userdata('pcAuth'))
					{
						$members=json_decode($this->session->userdata('pcAuth'));
						$this->load->model('Members_model','m');
						$res=$this->m->select_members_for_id($members->id);
						if($res)
						{
							$this->m->updateOneRow(array('nickname'=>$nickname),$members->id);
							$_array=array("code"=>100,"show"=>'昵称信息修改成功');
							jsonp_show($_array);	
						}
						else
						{
							$_array=array("code"=>200,"show"=>"登录信息已失效！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>200,"show"=>"登录信息已失效！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);	
				}				
			}	
		}
		
		//修改头像的过度页面
		public function avatar()
		{
			if(isset($_SESSION['pcAuth']))
			{
				$members=json_decode($this->session->userdata('pcAuth'));
				$this->load->model('Members_model','m');
				$res=$this->m->select_members_for_id($members->id);
				if($res)
				{
					$this->load->view("avatar.php",array('member'=>$res));	
				}
				else
				{
					$_array=array("code"=>200,"show"=>"登录信息已失效！");
					echo json_encode($_array);
				}
			}
			else
			{
				$_array=array("code"=>200,"show"=>"登录信息已失效！");
				echo json_encode($_array);	
			}	
		}
		
		//上传相关图片
		public function uploads()
		{
			if(isset($_SESSION['pcAuth']))
			{
				isset($_GET['id'])?$id=trim($_GET['id']):$id='';
				isset($_GET['day'])?$day=trim($_GET['day']):$day='';
				if($id=='' || $day=='')
				{
					$_array=array("code"=>200,"show"=>"参数错误！");
					echo json_encode($_array);exit();	
				}
				if(!in_array($day,array(date('Y-m-d'),date('Y-m-d',time()-3600*24),date('Y-m-d',time()+3600*24))))
				{
					$_array=array("code"=>200,"show"=>"参数错误！");
					echo json_encode($_array);exit();	
				}
				
				$members=json_decode($this->session->userdata('pcAuth'));
				$this->load->model('Members_model','m');
				$res=$this->m->select_members_for_id($members->id);
				if($res)
				{
					$fulls=array();
					$query=$this->db->query("select * from `cc_uploads` where `id`='$id' and `date`='$day' limit 1");
					if($query->num_rows()>0)
					{
						$result=$query->row_array();
						$fulls=json_decode($result['full'],true);
							
					}
					$this->load->view("uploads.php",array('member'=>$res,'id'=>$id,'day'=>$day,'fulls'=>$fulls));	
				}
				else
				{
					$_array=array("code"=>200,"show"=>"登录信息已失效！");
					echo json_encode($_array);exit();	
				}
			}
			else
			{
				$_array=array("code"=>200,"show"=>"登录信息已失效！");
				echo json_encode($_array);exit();		
			}	
		}
		
		//删除对应的图片
		public function deletes()
		{
			$id=$this->uri->segment(3);
			$query=$this->db->query("select * from `cc_uploads` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				$fulls=json_decode($result['full'],true);
				$array=array();
				$a=0;
				$url=htmlspecialchars(trim($_POST['url']));
			
				for($i=0;$i<count($fulls);$i++)
				{
					if($fulls[$i]['img']!=$url)
					{
						$array[$a]=array('img'=>$fulls[$i]['img']);
						$a++;
					}	
				}
			
				$_array=array(
					"full"=>json_encode($array),
					'time'=>time()
				);
				$this->db->update('uploads',$_array,array('id'=>$result['id']));
					
			}
			echo 'success';	
		}
		
		//读取用户当前区段上传的临时相片
		public function redimg()
		{
			$id=htmlspecialchars(trim($_GET['upload_cache_id']));
			$query=$this->db->query("select * from `cc_uploads` where `id`='$id'");
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				$fulls=json_decode($result['full'],true);
				$_array=array("code"=>100,"show"=>$fulls);
				jsonp_show($_array);
			}
		}
		
		//删除对应的图片
		public function imgdel()
		{
			$url=htmlspecialchars($_GET['url']);
			@unlink(FCPATH.$url);
			$_array=array("code"=>100,"show"=>'success');
			jsonp_show($_array);
		}
		
		//清空会员消息的数量
		public function msgclear()
		{
			$_array='';
		
			isset($_GET['comments_csrf'])?$comments_csrf=htmlspecialchars(trim($_GET['comments_csrf'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$comments_sid=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
						
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{	
				if(check_csrfToken($this->encrypt,$comments_csrf,$this->session))
				{
					//验证站点
					$this->load->model('Comments_model','c');
					$res=$this->c->select_id_site($comments_sid);
					if($res)
					{

						if($this->session->has_userdata('pcAuth'))
						{
							$members=json_decode($this->session->userdata('pcAuth'));
							$this->load->model('Members_model','m');
							$ress=$this->m->select_members_for_id($members->id);
							if($ress)
							{
								writeMsgCount($comments_sid,$members->id,0);
								$_array=array("code"=>100,"show"=>"success");
								jsonp_show($_array);
							}
							else
							{
								$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
								jsonp_show($_array);	
							}
						}
						else
						{
							$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>300,"show"=>"站点信息有误，请联系管理员！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"您可能长时间没操作页面，请刷新重试！");
					jsonp_show($_array);	
				}
			}						
		}
		
		//读取会员的所有消息
		public function msgall()
		{
			$_array='';
	
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$comments_sid=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['page']) && is_numeric($_GET['page'])?$page=intval(trim($_GET['page'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
						
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{	
		
				$this->load->model('Comments_model','c');
				$res=$this->c->select_id_site($comments_sid);
				if($res)
				{

					if($this->session->has_userdata('pcAuth'))
					{
						$members=json_decode($this->session->userdata('pcAuth'));
						$this->load->model('Members_model','m');
						$ress=$this->m->select_members_for_id($members->id);
						if($ress)
						{
							$face=$this->db->query("select * from `cc_faces`");
							
							$array['lists']=selectMsgPagination($face,$comments_sid,$members->id,$page,12,$pageall,$pagecount);
							$array['counts']=$pagecount;
							
							if($page>$pagecount)
							{
								$_array=array("code"=>400,"show"=>'no page show');
								jsonp_show($_array);	
							}
							else
							{
								$_array=array("code"=>100,"show"=>$array);
								jsonp_show($_array);	
							}
							
						}
						else
						{
							$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"站点信息有误，请联系管理员！");
					jsonp_show($_array);	
				}

			}				
		}
		
		//删除对应的消息
		public function msgdelete()
		{
			$_array='';
	
			isset($_GET['comments_sid']) && is_numeric($_GET['comments_sid'])?$comments_sid=htmlspecialchars(trim($_GET['comments_sid'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
			
			isset($_GET['id'])?$id=htmlspecialchars(trim($_GET['id'])):$_array=array("code"=>300,"show"=>"参数错误，请稍后再试！");
						
			if(is_array($_array))
			{
				jsonp_show($_array);
			}
			else
			{	
		
				$this->load->model('Comments_model','c');
				$res=$this->c->select_id_site($comments_sid);
				if($res)
				{

					if($this->session->has_userdata('pcAuth'))
					{
						$members=json_decode($this->session->userdata('pcAuth'));
						$this->load->model('Members_model','m');
						$ress=$this->m->select_members_for_id($members->id);
						if($ress)
						{
							deleteMsg($comments_sid,$id,$members->id);
							$_array=array("code"=>100,"show"=>'success');
							jsonp_show($_array);
							
						}
						else
						{
							$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
							jsonp_show($_array);	
						}
					}
					else
					{
						$_array=array("code"=>200,"show"=>"没有登录状态信息可以获取！");
						jsonp_show($_array);	
					}
				}
				else
				{
					$_array=array("code"=>300,"show"=>"站点信息有误，请联系管理员！");
					jsonp_show($_array);	
				}

			}
		}
		
		//头像显示页面
		public function avatarshow()
		{
			$url=$_GET["url"];//获取一下客户端的URL地址
			if(isset($_SESSION['pcAuth']))
			{
				$members=json_decode($this->session->userdata('pcAuth'));
				$this->load->model('Members_model','m');
				$res=$this->m->select_members_for_id($members->id);
				if($res)
				{
					$this->load->view("members/avatars.show.php",array('member'=>$res));	
				}
				else
				{
					//直接跳转到显示错误新页面
					errorDomainSay(200,$url,'avatarBacks','登录状态已失效');
				}
			}
			else
			{
				//直接跳转到显示错误新页面
				errorDomainSay(200,$url,'avatarBacks','登录状态已失效');
			}
			
		}
		
		//上传评论图片
		public function fileup()
		{
			$url=$_GET["url"];//获取一下客户端的URL地址
			isset($_GET['nows']) && is_numeric($_GET['nows'])?$nows=intval($_GET['nows']):$nows=5;
			$data['nows']=$nows;
			
			$this->load->view("members/fileup.php",array('nows'=>$nows));	

		}

		
		//退出登录
		public function logout()
		{
			$this->session->unset_userdata('pcAuth');
			$_array=array("code"=>100,"show"=>'success');
			jsonp_show($_array);
		}
		
		
		//根据地址获取百度的经纬度
		public function getBaidu()
		{
			isset($_GET['address']) && trim($_GET['address']!='')?$address=$_GET['address']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			$url ="http://api.map.baidu.com/geocoder?address=".trim($address)."&output=json&key=vqXoIAjaiGEb2REGzjzygjgm&city="; 
			$ch = curl_init();
			//设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			//执行并获取HTML文档内容
			$output = curl_exec($ch);
			//释放curl句柄
			curl_close($ch);
			$array=json_decode($output,true);
			//print_r($array); 
			if(isset($array['status']) && trim($array['status'])=='OK' && isset($array['result']['location']['lng']) && $array['result']['location']['lng']!='' && isset($array['result']['location']['lat']) && $array['result']['location']['lat']!='')
			{
				jsonp_show(['code'=>100,'show'=>['lat'=>$array['result']['location']['lat'],'lng'=>$array['result']['location']['lng']]]);
			}
			else
			{
				jsonp_show(['code'=>300,'show'=>'百度数据获取失败']);
			}
		}
		
		//根据经纬度获取当前地址
		public function getBaiduAddress()
		{
			isset($_GET['lat']) && trim($_GET['lat']!='')?$lat=$_GET['lat']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			isset($_GET['lng']) && trim($_GET['lng']!='')?$lng=$_GET['lng']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			$url ="http://api.map.baidu.com/geocoder/v2/?ak=vqXoIAjaiGEb2REGzjzygjgm&location=".$lng.",".$lat."6&output=json&pois=1"; 
			$ch = curl_init();
			//设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			//执行并获取HTML文档内容
			$output = curl_exec($ch);
			//释放curl句柄
			curl_close($ch);
			$array=json_decode($output,true);
			if(isset($array['status']) && trim($array['status'])=='0' && isset($array['result']['pois'][0]['addr']) && $array['result']['pois'][0]['addr']!='' && isset($array['result']['pois'][0]['name']) && $array['result']['pois'][0]['name']!='')
			{
				jsonp_show(['code'=>100,'show'=>$array['result']['pois'][0]['addr'].$array['result']['pois'][0]['name']]);
			}
			else
			{
				jsonp_show(['code'=>300,'show'=>'百度数据获取失败']);
			}
		}
		
		//根据经纬度获取两点之间的距离
		public function getDT()
		{
			isset($_GET['lng1']) && trim($_GET['lng1']!='')?$lng1=$_GET['lng1']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			isset($_GET['lat1']) && trim($_GET['lat1']!='')?$lat1=$_GET['lat1']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			isset($_GET['lng2']) && trim($_GET['lng2']!='')?$lng2=$_GET['lng2']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			isset($_GET['lat2']) && trim($_GET['lat2']!='')?$lat2=$_GET['lat2']:jsonp_show(['code'=>300,'show'=>'参数错误']);
			$l=$this->getdistance($lng1, $lat1, $lng2, $lat2);
			jsonp_show(['code'=>100,'show'=>$l]);
		}
		
		private function getdistance($lng1, $lat1, $lng2, $lat2) {
			// 将角度转为狐度
			$radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
			$radLat2 = deg2rad($lat2);
			$radLng1 = deg2rad($lng1);
			$radLng2 = deg2rad($lng2);
			$a = $radLat1 - $radLat2;
			$b = $radLng1 - $radLng2;
			$s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
			return intval($s);
		} 
			
	}
