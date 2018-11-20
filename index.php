<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
require_once "connect.php";
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Texode</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="valid.js"></script>
	</head>
	<body>
		
		<div class="auth">
			<form method="post" name="auth" action="auth.php">
				<label for="name">Login</label>
				<input type="text" name="login" id="login">
				<label for="name">Password</label>
				<input type="password" name="password" id="password">
				<input type="submit" value="вход">
			</form>
		</div>
		
		<h2>Отзывы</h2>
		
		<div class="sort">
		<p>Сотритровать отзывы по: 
		<a href="<? if ($_GET['sort'] != 'ORDER BY user_name ASC') {echo '?sort=ORDER BY user_name ASC';} else {echo '?sort=ORDER BY user_name DESC';}?>">Имени</a>
		<a href="<? if ($_GET['sort'] != 'ORDER BY user_email ASC') {echo '?sort=ORDER BY user_email ASC';} else {echo '?sort=ORDER BY user_email DESC';}?>">Е-mail</a> 
		<a href="<? if ($_GET['sort'] != 'ORDER BY user_date ASC') {echo '?sort=ORDER BY user_date ASC';} else {echo '?sort=ORDER BY user_date DESC';}?>">Дате</a> 
		</p>
		</div>
		
<?php
			//удаление
			if ($_GET['delete']) {
				$db = DataBase::getDb();
				$db->deletePost($_GET['delete']);
			}
			
			$db = DataBase::getDb();
			if ($_SESSION[user_login] == 'admin') {$access = true;}
			$db->sortPost($_GET['sort'], $access);
			
			function generatePost($user_foto, $user_name, $user_text, $user_email, $user_date, $delete) {
				 echo "
				 <link rel='stylesheet' href='style.css'>
				 
				 <div class='post'>
					<img src='$user_foto' class='user_foto'>
					 <div class='user_info'
						 <p class='user_name'>$user_name</p>
						 <p class='user_text'>$user_text</p>
						 <p class='user_email'>$user_email</p>
						 <p class='user_date'>$user_date</p>
					 </div>
					 $delete
					<div class='clearfix'></div>
				 </div>
				 ";
			}
?>
			
			<h3>Форма обратной связи</h3>
			<form method="post" action="feedback.php" enctype="multipart/form-data" name="form_feedback" class="feedbackForm">
				
					 <input type="hidden" name="csrf" value=?<?echo $_SESSION['csrf_token'] ?>">
					 
				<div class="form_float">
				
					<div class="field">
					<label for="name">Имя</label>
					<input type="text" name="name" id="name" maxlength="50">
					</div>
					
					<div class="field">
					<label for="email">Email</label>
					<input type="email" name="email" id="email"><!--type email -->
					</div>
					
					<div class="field">
					<label for="textarea">
					<p>Тескт отзыва</p><!--200 сим сделать -->
					<textarea rows="10" cols="50" name="textarea" id="textarea"></textarea>
					</label>
					</div>
					
					<div class="field">
					<label for="foto">Автар в формате jpg, gif или png</label>
					<input type="file" name="foto" accept="image/JPG, image/GIF, image/PNG">
					</div>
					
					<div class="field">
					<input type="submit" class="submitButton">
					
					<p class="error_message_p">-</p>
					<p class="server_error">
					<? if ($_SESSION[errorServer]) {echo "Server Error: $_SESSION[errorServer]";} else {echo '';}?>
					</p>
					</div>
				</div>
			</form>		
	</body>
</html>