function load() {
	var form = document.querySelector('form');
	var name = document.querySelector('#name');
	var email = document.querySelector('form input#email');
	
	form.addEventListener('submit', validuj);
	name.addEventListener('blur', validujInput);
	email.addEventListener('blur', validujInput);
}

/*
 * fce volana na submit
 * */
function validuj(event) {
	var name = document.querySelector('#name');
	var email = document.querySelector('form input#email');
	
	name.classList.remove('error');
	email.classList.remove('error');
	
	validujName(name, event);
	validujEmail(email, event);
}

function validujName(elm, event) {
	if (elm.value.length < 5) {
		if (event) {
			event.preventDefault();
		}
		elm.classList.add('error');
	}
}

function validujEmail(elm, event) {
	if (elm.value.indexOf('@') == -1) {
		if (event) {
			event.preventDefault();
		}
		elm.classList.add('error');
	}
}

/*
 * fce volana pri bluru 
 */
function validujInput(event) {
	var input = event.target;
	input.classList.remove('error');
	
	if (input.id == 'name') {
		validujName(input);
	}
	
	if (input.id == 'email') {
		validujEmail(input);
	}
}
