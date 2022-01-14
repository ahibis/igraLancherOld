<?
require '../basedate.php';
$json=new stdClass();
$json->status='error';
$notField=array('password','password2');
if (empty($_POST['user_id'])){$json->error="вы не ввели id пользователя";}

if (empty($json->error)){
	$json->status="success";
	$user_id=$_POST['user_id'];
	$usr=R::getRow("SELECT * FROM `users` WHERE `id`=$user_id LIMIT 1");
	$json->user=new stdClass();
	foreach ($usr as $key => $value) {
		if (!in_array($key,$notField)){
			$json->user->$key=$value;
		}
	}
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);