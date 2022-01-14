<?
session_start();
require '../basedate.php';
$json=new stdClass();
$json->status='error';
$text=isset($_POST['text'])?$_POST['text']:"";
$photos=isset($_POST['photos'])?$_POST['photos']:"[]";
if (empty($_SESSION['id'])){$json->error="вы не вошли в аккаунт";}
elseif (empty($_POST['page_id'])){$json->error="вы не указали page_id";}
elseif ($text==""&&$photos=="[]"){$json->error="вы не можете опубликовать пустой пост";}

if (empty($json->error)){
	$json->status='success';
	$usr=R::dispense('posts');
	$usr->page_id=$_POST['page_id'];
	$usr->from_id=$_SESSION['id'];
	$usr->photos=$photos;
	$usr->text=$text;
	$usr->likes='';
	$usr->time=time();
	R::store($usr);
	$json->posts=array();
	$post=new stdClass();
	$post->post_id=$usr->id;
	$post->page_id=$_POST['page_id'];
	$post->from_id=$_SESSION['id'];
	$post->text=$text;
	$post->photos=$photos;
	$post->time=$usr->time;
	$post->likes='';
	array_push($json->posts,$post);
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>