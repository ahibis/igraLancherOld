<?
session_start();
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
	<script src="js/login.js"></script>
</head>
<body>
	
	<div class="container" id="login">
		<h1>Авторизация</h1>
		<div class="row">
			<label for="email" class="col-sm-2 col-form-label" >email</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="email" id="email" maxlength="20">
			</div>
		</div>
		<div class="row">
			<label for="password" class="col-sm-2 col-form-label">пароль</label>
			<div class="col-sm-9">
				<input class="form-control" placeholder="пароль" maxlength="20" id="password" type="password">
			</div>
		</div>
		<div id="error"></div>
		<button type="button" class="btn btn-success" onclick="accaunt.login()">войти в аккаунт</button>
		<button type="button" class="btn btn-success" onclick="accaunt.goTo('registration')">создать аккаунт</button>
	</div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>