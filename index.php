<?
session_start();
require 'basedate.php';
$url=explode('/',$_SERVER['REDIRECT_URL']);
if ($url[1]==''){
	if (isset($_SESSION['id'])){
		$usr=R::load('users',$_SESSION['id']*1);
		$self=1;
		require 'pages/accaunt.php';
	}elseif (isset($_SESSION['inlogin'])){
		require 'pages/login.php';
	}else{
		require 'pages/registration.php';
	}
}else{
	$usr=R::findone('users','login=?',array($url[1]));
	if (isset($usr)){
		$self=0;
		if ($usr->id==$_SESSION['id']*1){$self=1;}
		require 'pages/accaunt.php';
	}else{
		require 'pages/404.php';
	}
}
