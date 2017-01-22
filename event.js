var toForm = document.querySelector("#toForm");
var toCalendar = document.querySelector("#toCalendar");
var toAdmin = document.querySelector("#toAdmin");
var logout = document.querySelector("#logout");

function init(){

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

}
init();
