<!DOCTYPE html>
<html>
	<head>
		<title>Calendar Input</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
			body {
				background: #EBDCF3;
			}
			
		</style>
	</head>
	<body>
		<?php
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			session_start();
			if(!$_SESSION['login']){
				header("Location: login.php");
			}else{
				$user = $_SESSION['username'];
				print("<h1>Welcome $user</h1>");
				print("<button id='logout'>Log Out</button>");
			}
		?>
		<div id="container">

			<div id="header">Calendar Input</div>

			<nav>
				<button id="toCalendar">My Calendar</button>
				<button id="toForm">Form Input</button>
				<button id="toAdmin">Admin</button>
			</nav>
			<script type="text/javascript">			
				var toForm = document.querySelector("#toForm");
				var toCalendar = document.querySelector("#toCalendar");
				var toAdmin = document.querySelector("#toAdmin");
				var logout = document.querySelector("#logout");
				
				toForm.addEventListener("click", function(){
					location.href = "input.php";
				});

				toCalendar.addEventListener("click", function(){
					location.href = "calendar.php";
				});
				
				toAdmin.addEventListener("click", function(){
					location.href = "admin.php";
				});

				if(!!logout){
					logout.addEventListener("click", function(){
						location.href = "logout.php";
					});
				}
			</script>
			<?php
				require('./database_HW8F16.php');
				require('./models/users_db.php');
				
				$valid = TRUE;
				$message = "";
				$id = "";
				$action = filter_input(INPUT_POST, 'action');
				if($action == NULL) {	
					$action = 'list_users';
				}
				
				if($action == 'list_users'){
					$users = get_users();
					include('./views/user_list.php');
					include('./views/user_add.php');
				}else if($action == 'delete_user'){
					$userID = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
					delete_user($userID);
					$message = "Account deleted successfully.";
					$users = get_users();
					include('./views/user_list.php');
					include('./views/user_add.php');
				}else if($action == 'add_user'){
					$username = filter_input(INPUT_POST, 'username');
					$user_login = filter_input(INPUT_POST, 'login');
					$user_password = filter_input(INPUT_POST, 'password');
					$users = get_users();
					if(empty($username) || empty($user_login) || empty($user_password)){
						if(empty($username)){
							$message = "This new username could not be empty.";
						}else if(empty($user_login)){
							$message = "This new login could not be empty.";
						}else{			
							$message = "This new password could not be empty.";
						}
					}else{
						foreach($users as $user){
							if($user_login == $user['acc_login'] || sha1($user_password) == $user['acc_password']){
								$valid = FALSE;
								break;
							}
						}
						
						if($valid){
							add_user($username, $user_login, $user_password);
							$users = get_users();
							$message = "Account added successfully.";
						}else{
							if($user_login == $user['acc_login']){
								$message = "This login is used by another user.";
							}else{
								$message = "This password is used by another user.";
							}
						}	
					}
					
					include('./views/user_list.php');
					include('./views/user_add.php');
				}else if($action == 'edit_user'){
					$users = get_users();
					if(!isset($_POST['cancel'])){
						$login = filter_input(INPUT_POST, 'login');
						$id = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
						$username = filter_input(INPUT_POST, 'username');
						$password = filter_input(INPUT_POST, 'password');
						
						foreach($users as $user){
							if($login == $user['acc_login'] || sha1($password) == $user['acc_password']){
								$valid = FALSE;
								break;
							}
						}
						
						if(empty($username) || empty($login) || empty($password)){
							if(empty($username)){
								$message = "This new username could not be empty.";
							}else if(empty($login)){
								$message = "This new login could not be empty.";
							}else{			
								$message = "This new password could not be empty.";
							}
							include('./views/user_list.php');
							include('./views/user_add.php');
						}else if($valid){
							edit_user($id, $username, $login, $password);
							$message = "Account updated successfully.";
							$users = get_users();
							$id = "";
							include('./views/user_list.php');
							include('./views/user_add.php');
						}else{
							if($login == $user['acc_login']){
								$message = "This login is used by another user.";
							}else{
								$message = "This password is used by another user.";
							}
							include('./views/user_list.php');
							include('./views/user_add.php');
						}
					}else{
						include('./views/user_list.php');
						include('./views/user_add.php');
					}
				}
			?>

		</div>
	</body>
</html>
