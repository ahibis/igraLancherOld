<?
//добавить проверку offset и count на число
session_start();
require '../basedate.php';
$json=new stdClass();
$json->status='error';
if (empty($_POST['page_id'])){$json->error="вы не ввели id страницы";}
$offset=isset($_POST['offset'])?$_POST['offset']:9999999999;
$count=isset($_POST['count'])?$_POST['count']:20;

if (empty($json->error)){
	$json->status='success';
	$posts=R::getAll("SELECT * FROM `posts` WHERE `id`<$offset ORDER BY `id` DESC LIMIT $count");
	$json->posts=array();
	foreach ($posts as $post) {
		$new_post=new stdClass();
		foreach ($post as $key => $value) {
			$new_post->$key=$value;
		}
		array_push($json->posts,$new_post);
	}
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>