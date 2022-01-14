function loginFormUp() {
    //all container
    let allContainer = document.querySelector("#all-container");
    allContainer.style.display = "none";

    //login form translation 
    let loginForm = document.querySelector("#login-form");
    loginForm.style.display = "block";
    window.requestAnimationFrame(function () {
        loginForm.style.transform = "translateY(-500px)";
    });
    //TRANSITION
    loginForm.style.transition = "transform 1s ease-in-out";


}


function signupFormUp() {
    //all container
    let allContainer = document.querySelector("#all-container");
    allContainer.style.display = "none";

    //sign up form translation 
    let signupForm = document.querySelector("#signup-form");
    signupForm.style.display = "block";
    window.requestAnimationFrame(function () {
        signupForm.style.transform = "translateY(-550px)";
    });
    //TRANSITION
    signupForm.style.transition = "transform 1s ease-in-out";



}