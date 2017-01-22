<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	function get_users(){
		$con= mysqli_connect('egon.cs.umn.edu','C4131F16U113','14991','C4131F16U113','3307');
		// Check connection
		if ($con->connect_error){
			echo 'Failed to connect to MySQL';
		}
		$users = $con->query('select * from tbl_accounts');
		$rows = array();
		while($r = $users->fetch_assoc()){
			$rows[] = $r;
		}
		$con->close();
		return $rows;
	}
	
	function delete_user($userID){
		$con = new mysqli('egon.cs.umn.edu','C4131F16U113','14991','C4131F16U113','3307');
		// Check connection
		if ($con->connect_error){
			echo 'Failed to connect to MySQL';
		}
		$query= 'delete from tbl_accounts where acc_id = ?';
		$statement= $con->prepare($query);
		$statement->bind_param('i' , $userID);
		$statement->execute();
		$con->close();
	}

	function add_user($username, $login, $password){
		$con = new mysqli('egon.cs.umn.edu','C4131F16U113','14991','C4131F16U113','3307');
		// Check connection
		if ($con->connect_error){
			echo 'Failed to connect to MySQL';
		}
		$query = 'insert into tbl_accounts (acc_name, acc_login, acc_password) values (?, ?, ?)';
		$statement = $con->prepare($query);
		$statement->bind_param('sss', $username, $login, sha1($password));
		$statement->execute();
		$con->close();
	}
	
	function edit_user($userID, $username, $login, $password){
		$con = new mysqli('egon.cs.umn.edu','C4131F16U113','14991','C4131F16U113','3307');
		// Check connection
		if ($con->connect_error){
			echo 'Failed to connect to MySQL';
		}
		$query = 'update tbl_accounts set acc_name = ?, acc_login = ?, acc_password = ? where acc_id = ?';
		$statement = $con->prepare($query);
		$statement->bind_param('sssi', $username, $login, sha1($password), $userID);
		$statement->execute();
		$con->close();
	}
?>
