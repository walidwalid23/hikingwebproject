let loginForm = document.querySelector("#login-form");
let loginUsernameError = document.querySelector("#usernameError");
let loginPasswordError = document.querySelector("#passwordError");

loginForm.addEventListener("submit", function (eventObj) {
    //preventing the form from routing
    eventObj.preventDefault();
    let username = loginForm.elements.username.value;
    let password = loginForm.elements.password.value;
    let rememberBoxCheck = loginForm.elements.rememberme.checked;
    let usernameValid = false;
    let passwordValid = false;
    //CLIENT CHECKING
    if (username.length < 4) {

        loginUsernameError.innerText = "Username Length Has To Be Atleast 4 Characters";

    }
    else {
        usernameValid = true;
    }
    if (password.length < 5) {

        loginPasswordError.innerText = "Password Length Has To Be Atleast 5 Characters";


    }
    else {
        passwordValid = true;
    }
    //SERVER CHECKING
    async function postToServer(usernameValue, passwordValue) {
        try {
            let postResponse = await axios.post("http://localhost/webproject/serverloginvalidation.php", {
                username: usernameValue,
                password: passwordValue,
                rememberCheck: (rememberBoxCheck == true) ? "yes" : "no"

            });
            console.log(postResponse);

            if (postResponse.data.error) {
                //DECODED JSON (OBJECT) CONTAINING ERROR IS SENT(IN CASE OF VALIDATION ERRORS)
                let matchError = document.querySelector("#match-error");
                let errorMessage = postResponse.data.error;
                matchError.innerText = errorMessage;
            }
            else {
                //DECODED JSON (OBJECT) CONTAINING SUCCESS IS SENT(IN CASE OF NO ERRORS)
                //go to the home page
                if (postResponse.data.success) {

                    window.location.href = "home.php";
                }


            }
        }
        catch (error) {
            document.write('<h3 style="color:red">Error occured:' + error + '</h3>');
        }
    }

    if (usernameValid && passwordValid) {

        postToServer(username, password);
    }



});

//INPUT LISTENERS TO REMOVE VALIDATION ERROS
let usernameInput = document.querySelector("#usernamelogin");
let passwordInput = document.querySelector("#passwordlogin");

usernameInput.addEventListener("input", function () {
    if (usernameInput.value.length >= 4) {
        loginUsernameError.innerText = "";
    }

});
passwordInput.addEventListener("input", function () {
    if (passwordInput.value.length >= 5) {
        loginPasswordError.innerText = "";
    }

});


