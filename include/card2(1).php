<?php
require_once "cardSDK.php";
	function cart(){//企业大礼包
		 $nonce_str=createNonceStr();
		//var_dump($nonce_str);
		 $timestamp=time();
		$Ticket = getApi();	
		
			$signature = new Signature();
			$signature->add_data($timestamp);
			$signature->add_data($nonce_str);
			$signature->add_data($Ticket);
			$signature->add_data("pU1V3wB6E4mtw7PAO5Q2XMv3VLjI");
			//$signature->add_data( "55555" );
			$sign = $signature->get_signature();//卡卷签名
			
			$card['signature'] = $sign;
			$card['timestamp'] = $timestamp;
			$card['nonce_str'] = $nonce_str;
			/* var_dump($timestamp);
			var_dump($nonce_str);
			var_dump($Ticket);
			var_dump("p9mncw0oxlnZnU2FtoRGONx2iHtM"); */
			echo json_encode($card);
	}
	function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }
  
  function getApi(){
		if(exists_token()){
			if(exprise_token()){
				$token = getTick();
				unlink('Api.txt');
				file_put_contents("Api.txt",$token);
			}
			else{
				$token = file_get_contents('Api.txt');
			}
		}
		else{
			$token = getTick();
			file_put_contents("Api.txt",$token);
		}
		//var_dump($token);exit;
		return $token;
	}
	  function exists_token(){
		 if(file_exists('Api.txt')){
			 return true;
		 }
		 else{
			 return false;
		 }
	 }
	  function exprise_token(){
		 $ctime = filectime('Api.txt');
		 if((time()-$ctime) >=7000){
			 //var_dump('bbbbb');exit;
			 return true;
		 }
		 else{
			 return false;
		 }
	 }
  
 function getAccessToken()
{
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxe7d3d729db3b2686&secret=d2637dffd0d30573c468613c071c6ec0';
    	
    	$ch = curl_init();
    	curl_setopt($ch,CURLOPT_URL,$url);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	$jsoninfo = json_decode($output,true);
    	$token = $jsoninfo["access_token"];
		//var_dump($token);exit;
    	return $token;
    
}
	function getTick(){
	 	$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.getAccessToken().'&type=wx_card';
		
		$ch = curl_init();
    	curl_setopt($ch,CURLOPT_URL,$url);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	$jsoninfo = json_decode($output,true);
    	$token = $jsoninfo["ticket"];
		//var_dump($output);exit;
    	return $token;
	 }
	

  
	cart();
	
	
	