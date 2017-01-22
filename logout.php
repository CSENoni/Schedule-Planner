<?php
session_start();
if(session_destroy()){
	// Destroy current session and redirect to the login page
	$_SESSION['login'] = false;
	header("Location: login.php");
}
?>
