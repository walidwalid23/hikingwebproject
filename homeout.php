<!--Check If the User is Already Logged In or Not -->
<?php
session_start();
//check if the user has a cookie or a session to log him in
if(isset($_COOKIE["username"]) || isset($_SESSION["username"]) ){
    header("location:home.php");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Hike Now</title>
    <link rel="stylesheet" href="homeout.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="container" id="all-container">
        <div id="quote-div">
            <p id="quote-one"> Are You Ready For An </p>
            <p id="adventure-word">Adventure?</p>
        </div>


        <button id="login-button" onclick="loginFormUp()">Hike Now!</button>

        <p id="noaccount-word"> <b>Don't Have An Account?</b></p>
        <button id="signup-button" onclick="signupFormUp()">Sign Up! </button>

    </div>

    <!--LOGIN FORM-->
    <!--ADD REMEMBER ME CHECKBOX-->
    <form action="" id="login-form" method="post">
        <label for="usernamelogin"> <b> Username: </b> </label>
        <br>
        <input type="text" id="usernamelogin" class="fields" name="username" placeholder="Username">
        <br>
        <p id="usernameError" class="error-message"></p>
        <label for="passwordlogin"> <b> Password: </b> </label>
        <br>
        <input type="password" id="passwordlogin" class="fields" name="password" placeholder="Password">
        <br>
        <p id="passwordError" class="error-message"></p>
        <input type="checkbox" id="rememberbox" name="rememberme">
        <label for="rememberbox"><b>Remember me</b></label>
        <br>
        <p id="match-error" class="error-message"></p>
        <br>
        <input type="submit" id="login-submit" class="submit" value="Log In">

    </form>

    <!--SIGNUP FORM-->
    <form id="signup-form" action="serversignupvalidation.php" method="post">
        <label for="usernamesignup"> <b> Username: </b> </label>
        <br>
        <input type="text" id="usernamesignup" class="fields" name="username" placeholder="Username">
        <p id="usernameErrorP" class="error-message"></p>
        <label for="emailfield"> <b> Email: </b> </label>
        <br>
        <input type="text" id="emailfield" class="fields" name="email" placeholder="Email">
        <p id="emailErrorP" class="error-message"></p>
        <p id="emailErrorP2" class="error-message"></p>
        <label for="passwordsignup"> <b> Password: </b> </label>
        <br>
        <input type="password" id="passwordsignup" class="fields" name="password" placeholder="Password">
        <br>
        <p id="passwordErrorP" class="error-message"></p>
        <label for="datefield"> <b>Enter Your BirthDate: </b> </label>
        <input type="date" id="datefield" name="date" min="1940-01-01" max="2003-12-31">
        <p id="dateErrorP" class="error-message"></p>
        <p id="unique-error" class="error-message"></p>
        <input type="submit" id="sign-up-submit" class="submit" value="Sign Up">
    </form>

    <script src="loginformvalidations.js"></script>
    <script src="signupformvalidations.js"></script>
    <script src="formup.js"> </script>
</body>





</html>