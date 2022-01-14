<?
session_start();
require '../basedate.php';
require '../utill.php';
$json=new stdClass();
$json->status='error';

$email=$_POST['email'];
$pass=$_POST['password'];
$usr=R::getRow("SELECT * FROM `users` WHERE `email`='$email' LIMIT 1");

if ($email==''){$json->error='вы не указали email';}
elseif ($pass==''){$json->error='вы не указали пароль';}
elseif (empty($usr['email'])){$json->error='Пользователь с таким email не зарегистрирован';}
elseif (password_verify($usr['password'],$pass)){$json->error='Пароль неверный';}
elseif ($usr['email_confirm']!=1){$json->error='вы не подтвердили email';}

if (empty($json->error)){
	$json->status="success";
	foreach ($usr as $key => $value) {
		$_SESSION[$key]=$value;
	}
}

echo json_encode($json,JSON_UNESCAPED_UNICODE);