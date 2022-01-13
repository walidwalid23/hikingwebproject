<?php
//if the user has cookies stored delete them
if($_COOKIE["remember"]=="yes"){
setcookie("ID",null,time()-1000);
setcookie("remember",null,time()-1000);
setcookie("username",null,time()-1000);
setcookie("profileImage",null,time()-1000);
setcookie("age",null,time()-1000);
}
//if the user has any sessions left destroy them
session_start();
session_destroy();
//redirect the user to the home out page
header("location:homeout.php");

?>