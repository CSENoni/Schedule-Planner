<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
	</head>
	
	<body>
		<h1>List of Users</h1>
		<?php print("<p class='warning'>$message</p>"); ?>
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Login</th>
				<th>New Password</th>
				<th>Action</th>
			</tr>
			
			<?php foreach($users as $user) {?>
			<tr>
				<?php if(isset($_POST["userID"]) && isset($_POST["edit"]) && $_POST["userID"] == $user['acc_id'] || (!empty($id) && $id == $user['acc_id'])){ ?>
					<form action="admin.php" method="POST">
						<td><?php echo $user['acc_id'] ?></td>
						<td><input type="text" name="username" value=<?php echo $user['acc_name'] ?>></td>
						<td><input type="text" name="login" value=<?php echo $user['acc_login'] ?>></td>
						<td><input type="password" name="password"></td>
						<input type="hidden" name="action" value="edit_user">
						<input type="hidden" name="userID" value=<?php echo $user['acc_id']; ?>>
						<td>
							<input type="submit" value="Update">
							<input type="submit" name="cancel" value="Cancel">
						</td>
					</form>
				<?php }else{ ?>
				<td><?php echo $user['acc_id'] ?></td>
				<td><?php echo $user['acc_name'] ?></td>
				<td><?php echo $user['acc_login'] ?></td>
				<td></td>
				<td>
					<form action="admin.php" method="POST">
						<input type="hidden" name="userID" value=<?php echo $user['acc_id']; ?>>
						<input name="edit" type="submit" value="Edit">
					</form>
					
					<form action="admin.php" method="POST">
						<input type="hidden" name="action" value="delete_user">
						<input type="hidden" name="userID" value=<?php echo $user['acc_id']; ?>>
						<input type="submit" value="Delete">
					</form>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</body>
</html>
