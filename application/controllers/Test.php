<?php

	class Test extends CI_Controller
	{
		
		public function index()
		{
			$code=rand(1000,9999);
	
			send_msg("JSM42313-0001","15871422133","@1@=$code");			
		}
	}