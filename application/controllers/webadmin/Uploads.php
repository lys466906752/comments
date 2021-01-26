<?php

	//后台上传
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Uploads extends Ci
	{
		
		public $ajaxLoginArray=[];
		
		public $IframeLoginArray=['facesub'];		
		
		public function __construct()
		{
			parent::__construct();
		
			$this->authLogin();	
		}
		
		//表情包上传
		public function facesub()
		{
			$this->load->library("imgsclass");
			$file=$this->imgsclass->upload($_FILES['files'],$msg,'',array("cutState"=>false));	
			if($file)
			{
				iframeshow(100,$file);
			}
			else
			{
				iframeshow(300,$msg);	
			}
		}
		
	}