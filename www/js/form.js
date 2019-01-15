function validatePassword(password) {

	// Password must be between 4 and 8 digits long
	return password.length >= 4 && password.length <= 8;
}
function validate() {
	var $validace = $("#validace");
	var password = $("#password").val();
	$validace.text("");

	if (validatePassword(password)) {
		document.getElementById("id").submit();
	}

	else {
		$validace.text("Wrong password!");
		$validace.css("color", "red");
	}
	return false;
}
$("#validate").bind("click", validate);

