<?php
	// define variables and set to empty values
	$eventErr = $stimeErr = $etimeErr = $locationErr = $urlErr = "";
	$valid = true;
	$filetxt = 'calendar.txt';
	if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['clear'])) {
	  if(empty($_POST['eventname']) || empty($_POST['starttime']) || empty($_POST['endtime']) || 
			empty($_POST['location']) || empty($_POST['url'])){
			
		  if (empty($_POST['eventname'])) {
			$eventErr = "Please provide a value for Event Name.";
			$valid = false;
    	  }
		  
		  if (empty($_POST['starttime'])) {
			$stimeErr = "Please select a value for Start Time.";
			$valid = false;
		  }
			
		  if (empty($_POST['endtime'])) {
			$etimeErr = "Please enter a value for Event End Time.";
			$valid = false;
		  }

		  if (empty($_POST['location'])) {
			$locationErr = "Please enter a value for Event Location.";
			$valid = false;
		  }
		  
		  if (empty($_POST['url'])){
			$urlErr = "Please enter a link for URL";
			$valid = false;	
		  }		
	  }
	  
	  // if valid then redirect
	  if($valid){
		// url encode the address
		$address = urlencode($_POST['location']);
		//google map geocode api url
		$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
		// get the json response
		$resp_json = file_get_contents($url);
		// decode the json
		$resp = json_decode($resp_json, true);
		// get long and lat
		$lat = $resp['results'][0]['geometry']['location']['lat'];
		$long = $resp['results'][0]['geometry']['location']['lng'];
		// form the data in JSON format and put into the file
		$formdata = array(
			'eventname' => $_POST['eventname'],
			'starttime' => $_POST['starttime'],
			'endtime' => $_POST['endtime'],
			'location' => $_POST['location'],
			'url' => $_POST['url'],
			'lat' => $lat,
			'lng' => $long
		);
		
		$jsondata = file_get_contents($filetxt);

		if(trim($jsondata) == false){
			$arr = array();
			array_push($arr, $formdata);
			$newform = array(
				$_POST['day'] => $arr
			);
			$jsondata = json_encode($newform);
		}else{
			$json = json_decode($jsondata, true);
			$day = $_POST['day'];
			if(isset($json[$day])){
				array_push($json[$day], $formdata);
			}else{
				$arr = array();
				array_push($arr, $formdata);
				$json[$day] = $arr;
			}
			$jsondata = json_encode($json);
		}
		//write to file and redirect
		if(file_put_contents($filetxt, $jsondata)){}  
		header('Location: calendar.php');
		exit();		
	  }
	}
	// if user click clear button: clean file and redirect
	if(isset($_POST['clear'])){
		if(file_put_contents($filetxt, '')){}
		header('Location: calendar.php');
		exit();
	}
?>

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

			<div class="header">Calendar Input</div>

			<nav>
				<button id="toCalendar">My Calendar</button>
				<button id="toForm">Form Input</button>
				<button id="toAdmin">Admin</button>
			</nav>
			
			<?php print("<p class='warning'> $eventErr </p>"); ?>
			<?php print("<p class='warning'> $stimeErr </p>"); ?>
			<?php print("<p class='warning'> $etimeErr </p>"); ?>
			<?php print("<p class='warning'> $locationErr </p>"); ?>
			<?php print("<p class='warning'> $urlErr </p>"); ?>
					
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
				<table>
					<tr>
						<td><label for="event">Event Name</label></td>
						<td><input type="text" id="event" name="eventname"></td>
					</tr>
					<tr>
						<td><label for="stimes">Start Time</label></td>
						<td><input type="time" id="stimes" name="starttime"></td>
					</tr>
					<tr>
						<td><label for="etimes">End Time</label></td>
						<td><input type="time" id="etimes" name="endtime"></td>
					</tr>
					<tr>
						<td><label for="loc">Location</label></td>
						<td><input type="text" id="loc" name="location" placeholder="xx or xx,xx,...(prefer)"></td>
					</tr>
					<tr>
						<td><label for="url">URL</label></td>
						<td><input type="text" id="url" name="url"></td>
					</tr>
					<tr>
						<td><label for="day">Day of the week</label></td>
						<td>
							<select id="day" name="day">
								<option>Mon</option>
								<option>Tue</option>
								<option>Wed</option>
								<option>Thu</option>
								<option>Fri</option>
							</select>	
						</td>
					</tr>
					<tr>
						<td><input type="submit" id="clear" name="clear" value="Clear"></td>
						<td><input type="submit" id="submit" name="submit" value="Submit"></td>
					</tr>
				</table>
			</form>
			<p>This page has been tested in Chrome</p>
		</div>
		<script>
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
	</body>
</html>
