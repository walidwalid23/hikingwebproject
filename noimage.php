<?php
session_start();

$_SESSION["profileImage"]="defaultpicture.jpg";

header("location:home.php");



?>