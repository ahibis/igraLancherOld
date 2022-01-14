<?
session_start();
if ($_POST['type']=='login'){
	$_SESSION['inlogin']=true;
}else{
	unset($_SESSION['inlogin']);
}
