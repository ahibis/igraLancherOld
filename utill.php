<?
/*
функции для php
*/
require "config.php";
function len($a){return mb_strlen($a);}
function ch($a,$b){return mb_substr($a, $b, 1);}
function sstr($a,$b,$c){return mb_substr($a, $b, $c);}
function protection($text){return preg_replace(array('/</','/>/'), array('&lt;','&gt;'), $text);}
function pecho($text){echo protection($text);}
function check_login($text){
	$alphabet="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
	$checkLetter=0;
	for ($i=0;$i<strlen($text);$i++){
		for ($k=0;$k<strlen($alphabet);$k+=1){
			if($text[$i]==$alphabet[$k]){
				$checkLetter+=1;
				break;
			}
		}
	}
	return $checkLetter==strlen($text)?True:False;
}
$myUrl=$_SERVER['HTTP_HOST'];

function vkMethod($metod,$params,$token=''){
	global $conf;
	$params['v']=$conf['vkVersion'];
	if ($token==''){$params['access_token']=$conf['vkToken'];}else{$params['access_token']=$token;}
	$get_params = http_build_query($params); //превращаем в строку
	return file_get_contents('https://api.vk.com/method/'.$metod.'?'.$get_params);
}
function vkMethod2($metod,$params,$token=''){
	return json_decode(vkMethod($metod,$params,$token));
}