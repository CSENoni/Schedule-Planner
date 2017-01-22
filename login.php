<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include('database_HW8F16.php');
	// define variables and set to empty values
	$usernameErr = $passwordErr = "";

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
	  if(empty($_POST['username']) || empty($_POST['password'])){
			
		  if (empty($_POST['username'])) {
			$usernameErr = "Please enter a valid value for Login Name Field.";
    	  }
		  
		  if (empty($_POST['password'])) {
			$passwordErr = "Please enter a valid value for Password Field.";
		  }	
	  }else{
		  // Create connection
		  $conn = new mysqli($db_servername, $db_username, $db_password, $db_name, $db_port);
		  if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }else{
			  // Find the query that matches the username and password
			  $username = $_POST['username'];
			  $password = sha1($_POST['password']);
			  $query = $conn->query("select * from tbl_accounts where acc_login = '$username' and acc_password = '$password'");
			  $checkUser = $conn->query("select * from tbl_accounts where acc_login = '$username'" );
			  if($query->num_rows >= 1){
				  // Initializing Session and redirect to the calendar.php
				  session_start();
				  
				  $_SESSION['login'] = true;
				  $_SESSION['username'] = $username;
				  header("Location: calendar.php");		  				  
			  }else{
				  if($checkUser->num_rows === 0){
					  $usernameErr = "User Does not exist. Please check the login details and try again.";  
				  }else{
					  $passwordErr = "Password is incorrect: Please check the password and try again.";
				  }
			  }
			  $query->close();
			  $checkUser->close();
		  }
		  mysqli_close($conn);
	  }	
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
			body {
				background: #EBDCF3;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<h1 class="header">Login Page</h1>
			<?php
				if(!empty($usernameErr)){
					print("<p class='warning'>$usernameErr</p>");
				}
				
				if(!empty($passwordErr)){
					print("<p class='warning'>$passwordErr</p>");
				}
			?>
			<p>Please enter your user's login name and password. Both values are case sensitive.</p>
			<form id="log_in" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
				<p>
					<label for="username">Login:</label>
					<input type="text" id="username" name="username">
				</p>
							
				<p>
					<label for="password">Password:</label>
					<input type="password" id="password" name="password">
				</p>
							
				<p><input type="submit" id="submit" name="submit" value="Submit"></p>
			</form>
			<p>This page has been tested in Chrome</p>
		</div>		
	</body>
</html>
