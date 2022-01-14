<?
session_start();
$json=new stdClass();
$json->status='error';
$fileDict="../postPhotos/";
$types=array('jpg','jpeg','png','bmp','ico');

if (empty($_SESSION['login'])){$json->error="вы не вошли в аккаунт";}
if (empty($_SESSION['id'])){$json->error="вы не вошли в аккаунт";}
if(empty($_POST['my_file_upload'])){$json->error="неизвестная ошибка";}
if(empty($_POST['page_id'])){$json->error="вы не указали page_id";} 
if(empty($json->error)){
	if (!is_dir($fileDict.$_POST['page_id'])){mkdir($fileDict.$_POST['page_id']);}
	$fileDict=$fileDict.$_POST['page_id']."/";
	$json->status="success";
	$files=$_FILES; // полученные файлы
    $fileList=array();
    $i=0;
	foreach( $files as $file ){
		$parts=explode('.',$file['name'] );
		if (in_array($parts[1],$types)){
			$file_name=time().'_'.$i.'.'.$parts[1];
			array_push($fileList,$file_name);
			move_uploaded_file( $file['tmp_name'], $fileDict.$file_name);
		}else{
			$json->error="фото может принимать только форматы jpg,jpeg,png,bmp,ico";
		}
		$i+=1;
	}
	$json->files=$fileList;
}
echo json_encode($json);