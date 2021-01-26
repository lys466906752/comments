<?php
	@session_start();
	
	include_once(FCPATH.'weibos/config.php');
	include_once(FCPATH.'weibos/saetv2.ex.class.php');
	
	$o = new SaeTOAuthV2( WB_AKEY,WB_SKEY );
	
	$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
	header("location:".$code_url);
?>
