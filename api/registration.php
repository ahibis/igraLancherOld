<?
session_start();
require '../basedate.php';
require '../utill.php';
$json=new stdClass();
$json->status='error';
$fields=array('name','sname','login','email','captcha','country','region','city','password','password2');//список полей для проверки
$fields2=array('name','sname','login','email','country','region','city','city_fias_id','city_kladr_id','geo_lat','geo_lon','address');//список полей для регистрации
foreach ($fields as  $field) {
	if (empty($_POST[$field])||($_POST[$field]=='')){
		switch($field){
			case "name": $json->error="Вы не ввели имя"; break;
			case "sname": $json->error="Вы не ввели фамилию"; break;
			case "login": $json->error="Вы не ввели логин"; break;
			case "email": $json->error="Вы не ввели email"; break;
			case "data": $json->error="Вы не ввели дату рождения"; break;
			case "city": $json->error="Вы не ввели город"; break;
			case "password": $json->error="Вы не ввели пароль"; break;
			case "password2": $json->error="Вы не повторили пароль"; break;
		}
		break;
	}
}
$ekey=rand(1E6,1E8);
$email=$_POST['email'];

$prlog=R::findone('users','login=?',array($_POST['login']));
$premail=R::findone('users','email=?',array($_POST['email']));
if (empty($json->error)){
	if ($_POST['password']!=$_POST['password2']){$json->error="пароли не совпадают";}
	elseif (len($_POST['password'])<6){$json->error="пароль должен содержать хотя бы 6 букв";}
	elseif (!check_login($_POST['login'])){$json->error="логин содержит не допустимые знаки";}
	elseif (len($_POST['login'])<6){$json->error="логин должен содержать хотя бы 6 букв";}
	elseif (is_numeric($_POST['login'])){$json->error="логин не может быть числом";}
	elseif ($_SESSION['captcha']["code"]!=$_POST['captcha']){$json->error="вы ввели не правильно капчу";}
	elseif (isset($prlog->login)){$json->error="пользователь с данным логином уже существует";}
	elseif (isset($premail->email)){$json->error="пользователь с данным email уже существует";}
}

if (empty($json->error)){
	$json->status='success';
	$usr= R::dispense('users');
	foreach ($fields2 as  $field) {
		$usr->$field=$_POST[$field];
	}
	$usr->password=password_hash($_POST['password'],PASSWORD_DEFAULT);
	$usr->emailConfirm=false;
	$usr->emailKey=$ekey;
	$usr->birthday='';
	$usr->registerDate=time();
	$usr->money=0;
	$usr->typeAcc=0;
	$usr->aboutMe='';
	$usr->src="";
	$usr->photos="[]";

	mail($_POST['email'],"подтвердите регистрацию на igra.media","<a href='http://$url/confirm/?u=$email&k=$ekey>'>для подтверждения почты нажмите сюда</a>");
	$_SESSION['inlogin']=true;
	R::store($usr);
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>