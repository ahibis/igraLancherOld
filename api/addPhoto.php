<?
session_start();
require '../basedate.php';
$json=new stdClass();
$json->status='error';
$fileDict="../photos/";
$types=array('jpg','jpeg','png','bmp','ico');
if (empty($_SESSION['login'])){$json->error="вы не вошли в аккаунт";}
if (empty($_SESSION['id'])){$json->error="вы не вошли в аккаунт";}
if(empty($_POST['my_file_upload'])){$json->error="неизвестная ошибка";}  
if(empty($json->error)){
	if (!is_dir($fileDict.$_SESSION['id'])){mkdir($fileDict.$_SESSION['id']);}
	$fileDict=$fileDict.$_SESSION['id']."/";
	$json->status="success";
	$files=$_FILES; // полученные файлы
    $fileList=array();
    $usr=R::load('users',$_SESSION['id']);
    $photos=json_decode($usr->photos);
	foreach( $files as $file ){
		$parts=explode('.',$file['name'] );
		if (in_array($parts[1],$types)){
			if (count($photos)==0){
				$photoid=0;
			}else{
				$photoid=explode(".",end($photos))[0]+1;
			}
			$file_name=$photoid.'.'.$parts[1];
			array_push($photos,$file_name);
			array_push($fileList,$file_name);
			move_uploaded_file( $file['tmp_name'], $fileDict.$file_name);
		}else{
			$json->error="фото может принимать только форматы jpg,jpeg,png,bmp,ico";
		}
	}
	$json->files=$fileList;
	$json->photos=$photos;
	$usr->photos=json_encode($photos);
	R::store($usr);
}
echo json_encode($json);