<!DOCTYPE html>

<html lang="en">
	<head>
		<title>My Calendar</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript">	
			// Use Ajax to get the right image when mouseover		
			function showImg(x, lid, iid, day){
				var xmlhttp = new XMLHttpRequest();
				var eventLoc = document.querySelectorAll("." + lid);
				var i = Array.prototype.slice.call(eventLoc).indexOf(x);
				var imgLoc = document.querySelectorAll("." + iid);
				xmlhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						var myArr = JSON.parse(this.responseText);
						var linkImg = "<img class='event-img' src='" + myArr[day][i]['url'] + "' alt='" + myArr[day][i]['location'] + "'>";
						imgLoc[i].innerHTML = linkImg;
					}
				}
				xmlhttp.open("GET", "calendar.txt", true);
				xmlhttp.send();		
			}
			
			// Remove Image when mouseout
			function cutImg(x, lid, iid){
				var eventLoc = document.querySelectorAll("." + lid);
				var i = Array.prototype.slice.call(eventLoc).indexOf(x);
				var imgLoc = document.querySelectorAll("." + iid);
				imgLoc[i].innerHTML = "";
			}
		</script>
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

			<div class="header">My Calendar</div>
			
			<nav>
				<button id="toCalendar">My Calendar</button>
				<button id="toForm">Form Input</button>
				<button id="toAdmin">Admin</button>
			</nav>
			
			<!-- write PHP code to get the data from calendar.txt to show on the webpage -->
			<?php
				function sortByOrder($a, $b){
					str_replace(':', '', $a['starttime']);
					str_replace(':', '', $b['starttime']);
					return intval($a['starttime']) - intval($b['starttime']);
				}
				$filetxt = 'calendar.txt';
				$jsondata = file_get_contents($filetxt);
				if(trim($jsondata) == true){
					$json = json_decode($jsondata, true);
			?>
	
			<table>
				<tr>
					<?php 
						if(isset($json['Mon'])){
					?>
							<td class="hCol"><span>Mon</span></td>
							<?php
								usort($json['Mon'], 'sortByOrder');
								foreach ($json['Mon'] as $records){
							?>		
							<td>
								<p class="time">
									<?php 
										 echo $records['starttime'], ' - ', $records['endtime'];
									?>
								</p>
								
								<p>
									<?php
										echo $records['eventname'], ' - ';
									?>
									<span class="mon-schedule" onmouseover="showImg(this, 'mon-schedule', 'mon-img', 'Mon')" onmouseout="cutImg(this, 'mon-schedule', 'mon-img')">
										<?php 
											echo $records['location'];
										?>
									</span>
								</p>
								<div class="mon-img"></div>
							</td>
							<?php
							}
							?>
					<?php 
						} 
					?>
				</tr>
			
				<tr>
					<?php 
						if(isset($json['Tue'])){
					?>
							<td class="hCol"><span>Tue</span></td>
							<?php
								usort($json['Tue'], 'sortByOrder');
								foreach ($json['Tue'] as $records){
							?>		
							<td>
								<p class="time">
									<?php 
										 echo $records['starttime'], ' - ', $records['endtime'];
									?>
								</p>
									
								<p>
									<?php
										echo $records['eventname'], ' - ';
									?>
									<span class="tue-schedule" onmouseover="showImg(this, 'tue-schedule', 'tue-img', 'Tue')" onmouseout="cutImg(this, 'tue-schedule', 'tue-img')">
										<?php 
											echo $records['location'];
										?>
									</span>
								</p>
								<div class="tue-img"></div>
							</td>
							<?php
								}
							?>
					<?php 
						} 
					?>
				</tr>
				
				<tr>
					<?php 
						if(isset($json['Wed'])){
					?>
							<td class="hCol"><span>Wed</span></td>
							<?php
								usort($json['Wed'], 'sortByOrder');
								foreach ($json['Wed'] as $records){
							?>		
							<td>
								<p class="time">
									<?php 
										 echo $records['starttime'], ' - ', $records['endtime'];
									?>
								</p>
									
								<p>
									<?php
										echo $records['eventname'], ' - ';
									?>
									<span class="wed-schedule" onmouseover="showImg(this, 'wed-schedule', 'wed-img', 'Wed')" onmouseout="cutImg(this, 'wed-schedule', 'wed-img')">
										<?php 
											echo $records['location'];
										?>
									</span>
								</p>
								<div class="wed-img"></div>
							</td>
							<?php
								}
							?>
					<?php 
						} 
					?>
				</tr>
				
				<tr>
					<?php 
						if(isset($json['Thu'])){
					?>
							<td class="hCol"><span>Thu</span></td>
							<?php 
								usort($json['Thu'], 'sortByOrder');
								foreach ($json['Thu'] as $records){
							?>		
							<td>
								<p class="time">
									<?php 
										 echo $records['starttime'], ' - ', $records['endtime'];
									?>
								</p>
									
								<p>
									<?php
										echo $records['eventname'], ' - ';
									?>
									<span class="thu-schedule" onmouseover="showImg(this, 'thu-schedule', 'thu-img', 'Thu')" onmouseout="cutImg(this, 'thu-schedule', 'thu-img')">
										<?php 
											echo $records['location'];
										?>
									</span>
								</p>
								<div class="thu-img"></div>
							</td>
							<?php
								}
							?>
					<?php 
						} 
					?>
				</tr>
				
				<tr>
					<?php 
						if(isset($json['Fri'])){
					?>
							<td class="hCol"><span>Fri</span></td>
							<?php
								usort($json['Fri'], 'sortByOrder');
								foreach ($json['Fri'] as $records){
							?>		
							<td>
								<p class="time">
									<?php 
										 echo $records['starttime'], ' - ', $records['endtime'];
									?>
								</p>
									
								<p>
									<?php
										echo $records['eventname'], ' - ';
									?>
									<span class="fri-schedule" onmouseover="showImg(this, 'fri-schedule', 'fri-img', 'Fri')" onmouseout="cutImg(this, 'fri-schedule', 'fri-img')">
										<?php 
											echo $records['location'];
										?>
									</span>
								</p>
								<div class="fri-img"></div>
							</td>
							<?php
								}
							?>
					<?php 
						} 
					?>
				</tr>
			</table>
				<?php 
				}else{
					print("<p class='warning'>Calendar has no events. Please use the input page to enter some events.</p>");	
				} 
				?>
		</div>
		
		<div id="map"></div>
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
			// Combine php and javascript to show the map and markers from txt file
			function initMap() {
				var center = {lat: 44.974, lng: -93.234};
				map = new google.maps.Map(document.getElementById('map'), {
					center: center,
					zoom: 15
				});
				
				setMarkers(map);
			}
			
			function setMarkers(map){
				<?php
					$filetxt = 'calendar.txt';
					$jsondata = file_get_contents($filetxt);
					if(trim($jsondata) == true){
						$json = json_decode($jsondata, true);
				?>
						bounds = new google.maps.LatLngBounds();
				<?php
						foreach($json as $day){
							foreach($day as $records){
								if($records['lat'] !== NULL || $records['lng'] !== NULL) {
				?>			
								var marker = new google.maps.Marker({
									position: {lat: <?php echo $records['lat']; ?>, lng: <?php echo $records['lng']; ?>},
									map: map
								});
								bounds.extend(marker.getPosition());
							<?php
								}
							}
							?>
						<?php
						}
						?>
						map.fitBounds(bounds);
					<?php
					}
					?>
			}

		</script>
		<script async defer
      		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ6nUMYXrNV7K5UhB-TOmevYVcx-ubAcw&libraries=places&callback=initMap">
      	</script>	
	</body>
</html>
