<?
session_start();
require '../basedate.php';
require '../utill.php';
$json=new stdClass();
$json->status='error';
$fields=array('name','sname','login','country','region','сity','aboutMe','birthday','type_acc','city_fias_id','city_kladr_id','geo_lat','geo_lon','address','src');
if (empty($_SESSION["id"])){$json->error="Вы не вошли в аккаунт";}
if (empty($json->error)){
	$json->status='success';
	$json->cnanges=new stdClass();
	$usr=R::load('users',$_SESSION["id"]);
	foreach ($_POST as $key => $value) {
		if (in_array($key,$fields)){
			$usr->$key=$value;
			$json->cnanges->$key=$value;
		}
	}
	R::store($usr);
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>