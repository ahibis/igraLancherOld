<?
session_start();
include("capcha/simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>аккаунт</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/accaunt.css">
	<script src="js/jquery.js"></script>
	<script src="js/main.js"></script>
	<script src="js/registration.js"></script>
</head>
<body>
	
	<div class="container" id="registration">
		<h1>Регистрация</h1>
		<div class="row">
			<label for="name" class="col-sm-2 col-form-label">Имя</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="Имя" id="name" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="sname" class="col-sm-2 col-form-label">Фамилия</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="Фамилия" id="sname" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="login" class="col-sm-2 col-form-label">логин</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="login" id="login" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="email" class="col-sm-2 col-form-label">email</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="email" id="email" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="password" class="col-sm-2 col-form-label">пароль</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="пароль" id="password" type="password" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="password2" class="col-sm-2 col-form-label">пароль</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="повторите пароль" id="password2" type="password" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="адресс" class="col-sm-2 col-form-label">адресс</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="адрес" id="address" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="captcha" class="col-sm-2 col-form-label">капча</label>
			<div class="col-sm-9">
				<input class="form-control" id="captcha" placeholder="капча" maxlength="10">
			</div>
		</div>
		<div><img src="<? echo  $_SESSION['captcha']['image_src']; ?>"></div>
		<div id="error"></div>
		
		<button type="button" class="btn btn-success" onclick="accaunt.registration()">зарегистрироваться</button>
		<button type="button" class="btn btn-success" onclick="accaunt.goTo('login')">уже есть аккаунт</button>
	</div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.7.1/dist/css/suggestions.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.7.1/dist/js/jquery.suggestions.min.js"></script>
</body>
</html>