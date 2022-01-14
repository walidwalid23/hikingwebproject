let doneButton = document.querySelector("#done-button");
let hikerID = document.querySelector("#hikerid").innerText;
doneButton.addEventListener("click", function () {
    window.location.href = "profilepage.php?hikerid=" + hikerID;
});

//client validations
let editForm = document.querySelector("#edit-form");

//get the old values (before submission) to compare with the new to know what was changed
let oldUsername = editForm.elements.username.value;
let oldPassword = editForm.elements.password.value;
let oldEmail = editForm.elements.email.value;
let imageInput = document.querySelector("#profileimage");


editForm.addEventListener('submit', function (eventObj) {

    let newUsername = editForm.elements.username.value;
    let newPassword = editForm.elements.password.value;
    let newEmail = editForm.elements.email.value;
    let usernameError = document.querySelector("#username-error");
    let passwordError = document.querySelector("#password-error");
    let emailError = document.querySelector("#email-error");
    let emailError2 = document.querySelector("#email-error2");
    let noChangeError = document.querySelector("#nochange-error");


    if (newUsername.length < 4) {
        eventObj.preventDefault();
        usernameError.innerText = "Username Length Has To Be Atleast 4 Characters";
    }

    //check password
    if (newPassword.length < 5 && newPassword != oldPassword) {
        eventObj.preventDefault();
        passwordError.innerText = "Password Length Has To Be Atleast 5 Characters";

    }

    //check if email field is not empty
    if (!newEmail) {
        eventObj.preventDefault();
        emailError.innerText = "Email Field Cannot Be Empty";
    }
    //check if the email is valid
    else {
        let atSignExists = false;
        let dotSignExists = false;
        let emailValid = false;
        for (let i = 0; i < newEmail.length; i++) {
            //check if there is @ sign
            if (newEmail[i] == '@') {
                atSignExists = true;
            }
        }
        for (let i = 0; i < newEmail.length; i++) {
            //check if there is dot sign
            if (newEmail[i] == '.') {
                dotSignExists = true;
            }
        }
        if (atSignExists && dotSignExists) {
            emailValid = true;
        }

        if (!emailValid) {
            eventObj.preventDefault();
            emailError2.innerText = "Please Enter A Valid Email";
        }
    }

    //if nothing was changed don't send a request to the server
    if (oldUsername == newUsername && oldPassword == newPassword && oldEmail == newEmail && !imageInput.value) {

        eventObj.preventDefault();
        noChangeError.innerText = "No Edits Made";
    }

});
