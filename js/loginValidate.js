/*
 * Handles the submit event of the survey form
 *
 * param e  A reference to the event object
 * return   True if no validation errors; False if the form has
 *          validation errors
 */
function validate(e)
{
	hideErrors();

	if(formHasErrors()){

		e.preventDefault();

		return false;
	}

	return true;
}

/*
 * Does all the error checking for the form.
 *
 * return   True if an error was found; False if no errors were found
 */
function formHasErrors()
{
	var errorFlag = false;

	// Check require input
	var requiredFields = ["username", "password"];

	for (var i = 0; i < requiredFields.length; i++) {
		var inputField = document.getElementById(requiredFields[i]);

		if(!formHasInput(inputField)){

			document.getElementById(requiredFields[i] + "_error").style.display = "block";

			if(!errorFlag){
				inputField.focus();
			}

			errorFlag = true;
		}
	}

	return errorFlag;
}


// Check for input, return false when there is no input
function formHasInput(inputFieldElement){

	if(inputFieldElement.value == null || trim(inputFieldElement.value) == "")
	{
		return false;
	}

	return true;
}


/*
 * Hides all of the error elements.
 */
function hideErrors()
{
	var errorField = document.getElementsByClassName("error");

	for (var i = 0; i < errorField.length; i++) {
		errorField[i].style.display = "none";
	}
}

function displayRegisterForm()
{
	var registerForm = document.getElementById("registerForm");
	var registerFormCloseButton = document.getElementById("closeRegister");

	registerForm.style.display = "block";
	registerFormCloseButton.style.display = "block";
}

function hideRegisterForm()
{
	var registerForm = document.getElementById("registerForm");
	var registerFormCloseButton = document.getElementById("closeRegister");

	registerForm.style.display = "none";
	registerFormCloseButton.style.display = "none";
}

/*
 * Handles the load event of the document.
 */
function onLoad()
{
	hideErrors();

	document.getElementById("submit").addEventListener("click", validate);
	document.getElementById("registerNow").addEventListener("click", displayRegisterForm)
	document.getElementById("closeRegister").addEventListener("click", hideRegisterForm)
	
}

// Add document load event listener
document.addEventListener("DOMContentLoaded", onLoad, false);