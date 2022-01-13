<html>
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <style>
      body{

background-color:#F5DEB3;
}
#edit-form{
    margin-top:40px;
    margin-left:80px;
}
.form-control{
    width:50%;
}
.error-message{
        font-size:0.75em;
        color:red;
    }
   
        </style>
    <title>Edit Form</title>
</head>
<body>
    <?php
$old_username;
$old_email;
$hiker_id;
if($_COOKIE["remember"]=="yes"){
$old_username=$_COOKIE["username"];
$old_email=$_COOKIE["email"];
$hiker_id=$_COOKIE["ID"];
}
else{
    session_start();
    $old_username=$_SESSION["username"];
    $old_email=$_SESSION["email"];
    $hiker_id=$_SESSION["ID"];
}

?>
    <div class="container">
<form id="edit-form" action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="username"><b>Edit Your Username:</b></label>
    <input type="text" class="form-control" id="username" name="username" value=<?php
    echo $old_username?> >
    <p id="username-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="password"><b>Edit Your Password:</b></label>
    <input type="password" class="form-control" id="password" name="password">
    <p id="password-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="email"><b>Edit Your Email address:</b></label>
    <input type="text" class="form-control" id="email" name="email" value=<?php
    echo $old_email?> >
    <p id="email-error" class="error-message"></p>
    <p id="email-error2" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="image"><b>Edit Your Profile Image:</b></label>
    <input type="file" id="profileimage" name="image-file" class="form-control" id="image">
  </div>
   <br>
  <button  type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button style="margin-left:10%" type="button" id="done-button" class="btn btn-primary">Done</button>
</form>
<p id="nochange-error" style="font-size:1.5em;margin-left:6%;" class="error-message"></p>
</div>
<?php echo'<p style="display:none" id="hikerid">'.$hiker_id.'</p>'  ?>
<script src="profileeditformvalidation.js">
</script>
</body>
</html>

<!--SERVER SIDE-->
<?php

if(isset($_POST["submit"])){
//getting the data
$username=$_POST["username"];
$password=$_POST["password"];
$email=$_POST["email"];
$image_file=$_FILES["image-file"];
$hiker_id=$GLOBALS["hiker_id"];
//validation variables
$usernameValid=false;
$passwordValid=false;
$emailValidate=false;
$formValidate=false;

if($username){

    $username=filter_var($username,FILTER_SANITIZE_STRING);
    if(strlen($username)>=4){
        $usernameValid=true;
    }
}
else{
  echo '<h5 style="color:red;margin-left:200px;">The Username Field Is Empty</h5> <br>';
  $usernameValid=false;
}


if($password){

    if(strlen($password)>=5){
        
   //CONNECTING TO THE DATABASE
   
   $db_conn=mysqli_connect("localhost","root","","hiking");
   if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
   //hashing the password
   $password=password_hash($password,PASSWORD_BCRYPT);
   //UPDATING THE NEW PASSWORD
   $result=$db_conn->query("UPDATE hiker SET password='$password' WHERE hikerID='$hiker_id'");
   if($result){
     echo '<h5 style="color:green;margin-left:200px;">Password Is Updated Successfully<br>';
   }
   
   
   else{
     echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Password<br>';
   }


    }
    
}
else{
  echo '<h5 style="color:red;margin-left:200px;">The Password Field Is Empty</h5> <br>';
  $passwordValid=false;
}


if($email){
    $email=filter_var($email,FILTER_SANITIZE_EMAIL);

  if(filter_var($email,FILTER_VALIDATE_EMAIL)!==false){
      
      $emailValidate=true;
  }
    
}
else{
  echo '<h5 style="color:red;margin-left:200px;">The Email Field Is Empty</h5> <br>';
  $emailValidate=false;
}




//image validation
   //file errors array
   $error_messages = array(
    'the file uploaded successfully',
    'Error:The file exceeds the upload_max_filesize',
    'Error:The file exceeds the MAX_FILE_SIZE ',
 'Error:The file was only partially uploaded',
 'Select an image file to upload',
 'Error:Missing a temporary folder',
 'Error:Failed to write file to disk',
 'Error:A PHP extension stopped the file upload',
);
try{
if($image_file["error"]==0){
//SET THE NEW IMAGE
$image_name=$image_file["name"];
//move the file to the images folder
move_uploaded_file($image_file["tmp_name"],"profilepictures/$image_name");
//update the image name in the database
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("UPDATE hiker SET profileImage='$image_name' WHERE hikerID='$hiker_id'");
if($result){
  echo '<h5 style="color:green;margin-left:200px;">Profile Image Is Updated Successfully<br>';
  //UPDATE COOKIES AND SESSIONS VALUES
  if($_COOKIE["remember"]=="yes"){

    $_COOKIE["profileImage"]=$image_name;
     }
     else{
       if($_SESSION["username"]){
        $_SESSION["profileImage"]=$image_name;
       }
       else{
         session_start();
         $_SESSION["profileImage"]=$image_name;
       }
     }
}
else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Profile Image <br>';
}

}
else{

echo '<h5 style="color:red;margin-left:200px;">'.$error_messages[$image_file["error"]] .'<br>';
}


   
// VALIDATE IF THE USERNAME IS UNIQUE
$username_unique=false;
if($usernameValid){
   //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
//checking if USERNAME IS UNIQUE
$username_query=$db_conn->query("SELECT username FROM hiker WHERE username='$username'");
$repeated_username_array=mysqli_fetch_array($username_query);

if($repeated_username_array){
    //SEND ERROR MESSAGE TO USER
    echo '<h5 style="color:red;margin-left:200px;">Username Is Already Taken</h5> <br>';
}
else{$username_unique=true;}

}
if($emailValidate){
   //VALIDATE IF THE EMAIL IS UNIQUE
   $email_unique=false;
    //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
    //checking if EMAIL IS UNIQUE
    $email_query=$db_conn->query("SELECT email FROM hiker WHERE email='$email'");
    $repeated_email_array=mysqli_fetch_array($email_query);
   if($repeated_email_array){
       //ECHO ERROR MESSAGE TO USER
       echo '<h5 style="color:red;margin-left:200px;">Email Is Already Taken</h5> <br>';
    }
    else{ $email_unique=true;}

  }

    if($username_unique){
  //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("UPDATE hiker SET username='$username' WHERE hikerID='$hiker_id'");
if($result){
  echo '<h5 style="color:green;margin-left:200px;">Username Is Updated Successfully<br>';
   //UPDATE COOKIES AND SESSIONS VALUES
   if($_COOKIE["remember"]=="yes"){

    $_COOKIE["username"]=$username;
     }
     else{
      
      $_SESSION["username"]=$username;
     }
  
}
else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Username <br>';
}

     

}
if( $email_unique){
   //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("UPDATE hiker SET email='$email' WHERE hikerID='$hiker_id'");
if($result){
  echo '<h5 style="color:green;margin-left:200px;">Email Is Updated Successfully<br>';
  //UPDATE COOKIES AND SESSIONS VALUES
  if($_COOKIE["remember"]=="yes"){

   $_COOKIE["email"]=$email;
    }
    else{
      
     
     $_SESSION["email"]=$email;
    }
}


else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Email <br>';
}


}
    }
    catch(Exception $error){ 
      echo '<h4 style="color:red">'.$error.'</h4>';
    }





}
?>