<?php

$jsonDataArray=json_decode(file_get_contents("php://input"),true);
$username=$jsonDataArray["username"];
$password=$jsonDataArray["password"];
$email=$jsonDataArray["email"];
$date=$jsonDataArray["date"];
$age;


$usernameValid=false;
$passwordValid=false;
$emailValidate=false;
$dateValid=false;
$formValidate=false;

if($username){

    $username=filter_var($username,FILTER_SANITIZE_STRING);
    if(strlen($username)>=4){
        $usernameValid=true;
    }
}


if($password){

    if(strlen($password)>=5){
        $passwordValid=true;
    }
    
}


if($email){
    $email=filter_var($email,FILTER_SANITIZE_EMAIL);

  if(filter_var($email,FILTER_VALIDATE_EMAIL)!==false){
      
      $emailValidate=true;
  }
    
}
//date validation
if($date){
//birth date
$birthdate_array  = explode('-', $date);
$birth_year=intval($birthdate_array[0]);
$birth_month=intval($birthdate_array[1]);
$birth_day=intval($birthdate_array[2]);
//current date
$currentdate=date("Y-m-d");
$currentdate_array  = explode('-', $currentdate);
$current_year=intval($currentdate_array[0]);
$current_month=intval($currentdate_array[1]);
$current_day=intval($currentdate_array[2]);

if (checkdate($birth_month,$birth_day,$birth_year)) {
    $dateValid=true;
    //GET THE USER AGE FROM THE BIRTHDATE AND CURRENT DATE AS INTEGERS
  if(($birth_month==$current_month &&  $birth_day>$current_day) || $birth_month>$current_month  ){
    //birthday didn't come yet
    $age=$current_year-$birth_year-1;
  }
  else{
      //current year minus birth year
    $age=$current_year-$birth_year;
  }
    
}


}


if($usernameValid && $passwordValid && $emailValidate && $dateValid){
    $formValidate=true;
}

if($formValidate){
    try{
// VALIDATE IF THE USERNAME IS UNIQUE
$username_unique=false;
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
//checking if USERNAME IS UNIQUE
$username_query=$db_conn->query("SELECT username FROM hiker WHERE username='$username'");
$repeated_username_array=mysqli_fetch_array($username_query);

if($repeated_username_array){
    //SEND ERROR MESSAGE TO USER
    $error_msg=["error"=>"Username Is Already Taken"];
    header("Content-Type:application/json");
    $error_in_json=json_encode($error_msg);
    // return the error to the client
    echo $error_in_json;
}
else{$username_unique=true;}
   //VALIDATE IF THE EMAIL IS UNIQUE
   $email_unique=false;
    //CONNECTING TO THE DATABASE
    $db_conn=mysqli_connect("localhost","root","","hiking");
    if(!$db_conn){
        die("couldn't connect to the database");}
    //checking if EMAIL IS UNIQUE
    $email_query=$db_conn->query("SELECT email FROM hiker WHERE email='$email'");
    $repeated_email_array=mysqli_fetch_array($email_query);
   if($repeated_email_array){
       //SEND ERROR MESSAGE TO USER
    $error_msg=["error"=>"Email Is Already Taken"];
    header("Content-Type:application/json");
    $error_in_json=json_encode($error_msg);
    // return the error to the client
    echo $error_in_json;
    }
    else{ $email_unique=true;}

    if($username_unique && $email_unique){
    //generating UNIQUE ID FOR EACH HIKER
    $hiker_id=time()*rand(2,100);
    //MAKING SURE THE ID IS UNIQUE OR ELSE GENERATE A NEW ONE
    $id_query=$db_conn->query("SELECT * FROM hiker WHERE hikerID='$hiker_id'");
    $hiker_id_repeated=mysqli_fetch_array($id_query);
    if($hiker_id_repeated){
        //generate a new ID
        $hiker_id=time()*rand(2,100);
        
    }
    //hashing the password
    $password=password_hash($password,PASSWORD_BCRYPT);
    //INSERTING USER DATA IN THE DATABASE
    $insertResult=$db_conn->query("INSERT INTO hiker values('$hiker_id','$username',$age,'$email','$password','defaultpicture.jpg','user')");
    if($insertResult){
     //DATA IS INSERTED SUCCESSFULLY
     //CREATE INBOX FOR THIS USER
     $create_inbox=$db_conn->query("INSERT INTO inbox VALUES('$hiker_id',0)"); 
     if($create_inbox==true){
     //set remember cookie to false
     $daysInSeconds=86400*3;
     setcookie("remember","no",time()+$daysInSeconds);
     //SET THE REQUIRED SESSIONS
     session_start();
     $_SESSION["ID"]=$hiker_id;
     $_SESSION["username"]=$username;
     $_SESSION["email"]=$email;
     $_SESSION["age"]=$age;
     $_SESSION["type"]="user";
      //sessopm for image review
      $_SESSION["img_reviewed"]=false;
     //SEND SUCCESS RESPONSE
     $success_msg=["success"=>"user validated"];
     header('Content-Type: application/json');
     $jsonData=json_encode($success_msg);
     //return the error to the client
     echo $jsonData;
     }
      else{
        $error_msg=["error"=>"Inbox Data Was Not Inserted Successfully"];
        header('Content-Type: application/json');
        $jsonData=json_encode($error_msg);
        echo $jsonData;
      }
    }
    else{
        $error_msg=["error"=>"User Data Was Not Inserted Successfully"];
        header('Content-Type: application/json');
        $jsonData=json_encode($error_msg);
        echo $jsonData;
        
    }
}
    }
    catch(Exception $error){ 
        $error_msg=["error"=>$error];
        header('Content-Type: application/json');
        $jsonData=json_encode($error_msg);
        echo $jsonData;
        
    }
}

else{
    echo "<h1> THE FORM IS NOT VALID </h1>";
}




?>