<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="penalty.css">
    <title>Add Penalty</title>
</head>
<body>
   <?php
   include 'navbar.php';
   ?> 
   <form action="" method="post" id="penalty-form">
  <div class="form-group">
    <label for="penalty-reason"><b>Penalty Reason</b></label>
    <input type="text" class="form-control input-field" id="penalty-reason" name="penaltyreason" placeholder="Enter The Penalty Reason">
  </div>
  <br>
  <div class="form-group">
    <label for="admin-username"><b>Administrator Username</b></label>
    <input type="text" class="form-control input-field" id="admin-username" name="adminusername" placeholder="Enter The Administrator Username">
  </div>
  <button type="submit" class="btn btn-primary" name="submit" style="margin-top:1%;">Submit</button>
</form>
</body>
</html>

<?php

if(isset($_POST["submit"])) {

$penalty_reason=$_POST["penaltyreason"];
$admin_username=$_POST["adminusername"];

$penalty_reason_valid=false;
$admin_username_valid=false;
$admin_username_exists=false;

if($penalty_reason!=""){
    //penalty reason not empty
    $penalty_reason_valid=true;
}
else{
    echo '<h6 style="color:red;margin-left:40%;">You Cannot Leave Penalty Field Empty </h6>';
}

if($admin_username!=""){
    //admin username not empty
    $admin_username_valid=true;
}
else{
    echo '<h6 style="color:red;margin-left:40%;">You Cannot Leave Admin Field Empty </h6>';
}
//CHECK IF THE ADMIN USERNAME EXISTS OR NOT
 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database</h5><br>';}
 
 $result=$db_conn->query("SELECT* FROM groupadmins,hiker WHERE groupadmins.administratorID=hiker.hikerID
 AND hiker.username='$admin_username' ");
 $resulted_admin_array=mysqli_fetch_array($result);

if(isset($resulted_admin_array)){
  //the admin username exists
  $admin_username_exists=true;
}
else if(!isset($resulted_admin_array) && $admin_username_valid){
    
   echo '<h6 style="color:red;margin-left:40%;">This Admin Does not Exist </h6>';
    
}

if($penalty_reason_valid && $admin_username_valid && $admin_username_exists){
//INSERT THE PENALTY IN THE PENALTY TABLE
$administrator_ID=$resulted_admin_array["hikerID"];

$insert_result=$db_conn->query("INSERT INTO penalty VALUES('$penalty_reason','$administrator_ID')");

if($insert_result==true){
    echo '<h6 style="color:green;margin-left:40%;">Penalty Added Successfully </h6>';
}
else{
    
   echo '<h6 style="color:red;margin-left:40%;">Error While Inserting Penalty </h6>';
}

}


}






?>