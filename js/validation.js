/**
 * This function validates login and registration form.
 */
function validate() {
  // Initializing regex variables.
  const alphabetRegex = /^[a-zA-Z]+$/;
  const phoneRegex = /^\+91\d{10}$/;
  const emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  // Getting the values of the input fields.
  var firstName = $(".firstname").val();
  var lastName = $(".lastname").val();
  var contact = $("#phone").val();
  var password = $(".userpassword").val();
  var interests = $(".prefInterests").val();
  var regEmail = document.forms["registration_form"]["regemail"].value;
  var inputEmailId = $("#email").val();

  // Initializing variables by targetting the input fields.
  var nameError = $(".nameError");
  var contactError = $(".contactError");
  var emailError = $(".emailError");
  var passwordError = $(".passwordError");
  var interestsError = $(".interestsError");

  // Initializing empty strings for error variables.
  nameError.text("");
  contactError.text("");
  emailError.text("");
  passwordError.text("");
  interestsError.text("");

  // Checking whether the fields are empty or not.
  if (!regEmail || !firstName || !lastName || !contact || !password || !prefInterests) {
    nameError.text("This field shouldn't be empty");
    contactError.text("This field shouldn't be empty");
    emailError.text("This field shouldn't be empty");
    passwordError.text("This field shouldn't be empty");
    interestsError.text("This field shouldn't be empty");
    event.preventDefault();
  }

  // Checking whether fields contains only alphabets.
  if (!alphabetRegex.test(firstName)) {
    nameError.text("Name should contain alphabets only");
    event.preventDefault();
  }
  if (!alphabetRegex.test(lastName)) {
    nameError.text("Name should contain alphabets only");
    event.preventDefault();
  }

  // Checks for valid phone no pattern.
  if (!phoneRegex.test(contact) || contact.length !== 13) {
    contactError.text(
      "Enter a valid phone no starting with +91 and with 10 digits"
    );
    event.preventDefault();
  }

  // Checks for valid email Syntax.
  if (!emailRegex.test(regEmail) && !emailRegex.test(inputEmailId)) {
    emailError.text("Enter a valid email");
    event.preventDefault();
  }

  // Checks for password validation.
  if (!password) {
    passwordError.text("Password field is required");
    event.preventDefault();
  }

  // Checks whether the interest field is empty or not.
  if (!interests) {
    interestsError.text("Please select your interests");
    event.preventDefault();
  }
}
