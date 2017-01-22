<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
	</head>
	
	<body>
		<main>
			<h1>Add New User</h1>
			<form action="admin.php" method="POST">
				<input type="hidden" name="action" value="add_user">
				<p>
					<label for="username">Name: </label>
					<input type="text" id="username" name="username">
				</p>
				
				<p>
					<label for="login">Login: </label>
					<input type="text" id="login" name="login">
				</p>
				
				<p>
					<label for="password">Password: </label>
					<input type="password" id="password" name="password">
				</p>
				
				<button>Add User</button>
			</form>
		</main>
	</body>
</html>
