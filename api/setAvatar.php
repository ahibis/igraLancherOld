<?
session_start();
$json=new stdClass();
$json->status='error';
$fileDict="../avaimg/";
$types=array('jpg','jpeg','png','bmp','ico');

if (empty($_SESSION['login'])){$json->error="вы не вошли в аккаунт";}
if(empty($_POST['my_file_upload'])){$json->error="неизвестная ошибка";}  
if(empty($json->error)){
	$json->status="success";
	$files=$_FILES; // полученные файлы
    $fileList=array();
    
	foreach( $files as $file ){
		$parts=explode('.',$file['name'] );
		if (in_array($parts[1],$types)){
			$file_name=$_SESSION['login'].'.'.$parts[1];
			array_push($fileList,$file_name);
			move_uploaded_file( $file['tmp_name'], $fileDict."$file_name");
		}else{
			$json->error="аватарка может принимать только форматы jpg,jpeg,png,bmp,ico";
		}
	}
	$json->files=$fileList;
}
echo json_encode($json);