let signupForm = document.querySelector("#signup-form");
let signupUsernameError = document.querySelector("#usernameErrorP");
let signupPasswordError = document.querySelector("#passwordErrorP");
let signupemailError = document.querySelector("#emailErrorP");
let signupemailError2 = document.querySelector("#emailErrorP2");
let signupdateError = document.querySelector("#dateErrorP");

signupForm.addEventListener("submit", function (eventObj) {
    //prevent form request
    eventObj.preventDefault();

    let username = signupForm.elements.username.value;
    let password = signupForm.elements.password.value;
    let email = signupForm.elements.email.value;
    let date = signupForm.elements.date.value;
    let usernameValid = false;
    let passwordValid = false;
    let emailValid = false;
    let dateValid = false;



    //VALIDATIONS CONDITIONS
    //check username
    if (username.length < 4) {

        signupUsernameError.innerText = "Username Length Has To Be Atleast 4 Characters";
    }
    else { usernameValid = true }
    //check password
    if (password.length < 5) {

        signupPasswordError.innerText = "Password Length Has To Be Atleast 5 Characters";

    }
    else { passwordValid = true }
    //check if email field is not empty
    if (!email) {

        signupemailError.innerText = "Email Field Cannot Be Empty";
    }

    //check if the email is valid
    else {
        let atSignExists = false;
        let dotSignExists = false;
        for (let i = 0; i < email.length; i++) {
            //check if there is @ sign
            if (email[i] == '@') {
                atSignExists = true;
            }
        }
        for (let i = 0; i < email.length; i++) {
            //check if there is dot sign
            if (email[i] == '.') {
                dotSignExists = true;
            }
        }
        if (atSignExists && dotSignExists) {
            emailValid = true;
        }

        if (!emailValid) {

            signupemailError2.innerText = "Please Enter A Valid Email";
        }
    }
    if (!date) {
        signupdateError.innerText = "Date Field Cannot Be Empty";
    }
    else { dateValid = true; }

    //SERVER CHECKING
    async function postToServer(usernameValue, passwordValue, emailValue, dateValue) {
        try {

            let postResponse = await axios.post("http://localhost/webproject/serversignupvalidation.php", {
                username: usernameValue,
                password: passwordValue,
                email: emailValue,
                date: dateValue

            });
            console.log(postResponse);

            if (postResponse.data.error) {
                //JSON IS SENT(IN CASE OF VALIDATION ERRORS)
                let uniqueError = document.querySelector("#unique-error");
                let errorMessage = postResponse.data.error;
                uniqueError.innerText = errorMessage;
            }
            else if (postResponse.data.success) {
                //DECODED JSON (OBJECT) CONTAINING SUCCESS IS SENT(IN CASE OF NO ERRORS)
                //go to the home page

                window.location.href = "profileimageform.php";

            }
            else {
                document.write('<h2 style="color:red">' + postResponse.data + '</h2>');
                document.write('<h6 style="color:red">' + postResponse.status + '</h6>');
            }
        }
        catch (error) {

            document.write('<h3 style="color:red">Error occured:' + error + '</h3>');
        }
    }

    if (usernameValid && passwordValid && emailValid && dateValid) {

        postToServer(username, password, email, date);
    }


});


//INPUT LISTENERS TO REMOVE VALIDATION ERROS
let signupUsernameInput = document.querySelector("#usernamesignup");
let SignupPasswordInput = document.querySelector("#passwordsignup");
let SignupEmailInput = document.querySelector("#emailfield");
let SignupdateInput = document.querySelector("#datefield");

signupUsernameInput.addEventListener("input", function () {
    if (signupUsernameInput.value.length >= 4) {
        signupUsernameError.innerText = "";
    }

});
SignupPasswordInput.addEventListener("input", function () {
    if (SignupPasswordInput.value.length >= 5) {
        signupPasswordError.innerText = "";
    }

});
SignupEmailInput.addEventListener("input", function () {
    //check if email is not empty
    if (SignupEmailInput.value) {
        signupemailError.innerText = "";
    }
    //check if it's a valid email
    let email = SignupEmailInput.value;
    let atSignExists = false;
    let dotSignExists = false;
    let emailIsValid = false;
    for (let i = 0; i < email.length; i++) {
        //check if there is @ sign
        if (email[i] == '@') {
            atSignExists = true;
        }
    }
    for (let i = 0; i < email.length; i++) {
        //check if there is dot sign
        if (email[i] == '.') {
            dotSignExists = true;
        }
    }
    if (atSignExists && dotSignExists) {
        emailIsValid = true;
    }
    if (emailIsValid) {
        signupemailError2.innerText = "";
    }

});

SignupdateInput.addEventListener("input", function () {
    if (SignupdateInput.value) {
        signupdateError.innerText = "";
    }

});





