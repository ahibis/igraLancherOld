<?
require 'utill.php';
if (isset($_SESSION['id'])){
	$log=1;
	$fullname=$_SESSION['name'].' '.$_SESSION['sname'];
}
$user_id=$usr->id;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>аккаунт</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/accaunt.css">
	<script>
		myAcc=<? echo $self; ?>;
		photos=<? echo $usr->photos; ?>;
		user_id=<? echo $usr->id ?>;
	</script>
	<script src="js/jquery.js"></script>
	<script src="js/main.js"></script>
	<script src="js/accaunt.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand" href="/">igra.media</a>
  			</button>
			<span class="navbar-text">
			    <? if (isset($fullname)){
			    	pecho($fullname);
			    	echo '<button class="btn btn-danger" onclick="accaunt.leave()">выйти</button>';
			    }else{
			    	echo '<button class="btn btn-success" onclick=document.location.href="/..">зарегистрировться</button>';
			    } ?>
			</span>
		</div>
	</nav>
	<div class="container">
		<div class="modal fade" id="showphoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1>Просмотр фото</h1>
					</div>
					<div class="modal-body">
		        		<div class="row sbody">
		        			<div width="35px"><button class="btn btn-secondary" onclick="prevPhoto()">&lt;</button></div>
		        			<div id="ophoto"><img src="" id="sPhoto"></div>
		        			<div width="35px"><button class="btn btn-secondary" onclick="nextPhoto()">&gt;</button></div>
		        		</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<div class="wrap">
					<img id="ava" src="<? pecho($usr->src=='' ? 'img/anonym.png' : $usr->src); ?>" width='100%'><br>
					<? if($self){echo '<button class="btn btn-success col-12" onclick="loadAva()">загрузить фото</button>';} ?>	
				</div>
			</div>
			<div class="col-sm-9 accaunt">
				<div class="wrap">
					<h1>
						<span class="field" name="name"><? pecho($usr->name); ?></span> 
						<span class="field" name="sname"><? pecho($usr->sname); ?></span>
					</h1>
					<hr>
					<h4>общие данные</h4>
					<div class="row">
						<div class="col-4">место проживания:</div>
						<div class='col-8' id='country' value='$usr->address'>
							<?
								if($self){
									echo "<input class='form-control' placeholder='адрес' id='address' maxlength='20' value='$usr->address'>";
								}else{
									echo "$usr->address";
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4">email:</div>
						<div class="col-8"><? pecho($usr->email); ?></div>
					</div>
					<div class="row">
						<div class="col-4">день рождения:</div>
						<div class="col-8" ><? echo "<input type='date' name='birthday' value='$usr->birthday'> ";?></div>
					</div>
					<div class="row">
						<div class="col-4">тип участника:</div>
						<div class="col-8">
							<?
							if ($self){
								echo '<select name="type_acc">';
								foreach ($conf["userTypes"] as $k => $v) {
									$select=$usr->type_acc==$k? "selected" : "";
									echo "<option value='$k' $select>$v</option>";
								}
								echo '</select>';
							}else{
								echo $conf["userTypes"][$usr->type_acc];
							}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4">о себе:</div>
						<div class="col-8 field" name="aboutMe"><? pecho($usr->aboutMe=="" ? "информация не указана" : $usr->aboutMe); ?></div>
					</div>
				</div>
				<div class="wrap">
					<? 
					$photos=json_decode($usr->photos);
					$cf=count($photos);
					echo "<h4 id='cf'>фото($cf)</h4>";
					?>
					<div class="row photos">
						<?
							
							$mp=min(count($photos),4);
							for ($i=0; $i <$mp ; $i++) { 
								echo "<img src='photos/$user_id/$photos[$i]' class='col-3'>";
							}
						?>
					</div>
					<? if($self){echo "<button class='btn btn-success col-12 col-md-3' onclick='addPhoto()'>добавить фото</button>";} ?>
				</div>
				<div class="wrap">
					<h4>стена</h4>
					<textarea class="form-control" id="postText" placeholder="текст поста" <? if (!$log){echo "readOnly";}?>></textarea>
					<div id="postPhotos"></div>
					<div class="row postLine">
						<div >
							<img src="img/photo.png" !show="true" onclick="savePostPhotos()">
						</div>
						<div >
							<button class='btn btn-success' onclick='Post.send()'>опубликовать</button>
						</div>
					</div>
				</div>
				<div id="posts">
				
				</div>
				<button class='btn btn-secondary loadnext' onclick='Post.nextLoads()'>загрузить еще</button>

			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.7.1/dist/css/suggestions.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.7.1/dist/js/jquery.suggestions.min.js"></script>
</body>
</html>