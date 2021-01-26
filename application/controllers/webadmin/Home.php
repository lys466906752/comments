<?php

	//后台主界面
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require 'Ci.php';
	
	class Home extends Ci
	{
		
		public $ajaxLoginArray=[];
		
		public $IframeLoginArray=[];		
		
		public function __construct()
		{
			parent::__construct();
			
			$this->authLogin();	
		}
		
		public function index()
		{
			$this->checkAdmin();
			$this->load->view('admin/index.php');	
		}
		
	}