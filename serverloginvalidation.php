<?php
//receiving json data from ajax (true to receive json as associative array)
$data = json_decode(file_get_contents("php://input"),true);
$username=$data["username"];
$password=$data["password"];
//returns yes or no
$rememberCheck=$data["rememberCheck"];
//validation variables
$usernameValidate=false;
$passwordValidate=false;
$formValidate=false;

if($username){

    $username=filter_var($username,FILTER_SANITIZE_STRING);
   
    if(strlen($username)>=4){
        $usernameValidate=true;
    }
}

if($password){

    if(strlen($password)>=5){
        $passwordValidate=true;
    }
    
}

if($usernameValidate && $passwordValidate ){

    $formValidate=true;

}

if($formValidate){
//IF FORM IS VALID CHECK FOR THE VALIDITY OF USERNAME AND PASSWORD IN DATABASE
 // VALIDATE USERNAME AND PASSWORD EXISTANCE
    $username_exists=false;
    $password_match=false;
    //CONNECTING TO THE DATABASE
    $db_conn=mysqli_connect("localhost","root","","hiking");
    if(!$db_conn){echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
    //checking if USERNAME IS UNIQUE
    $username_query=$db_conn->query("SELECT * FROM hiker WHERE username='$username'");
    $userdata_array=mysqli_fetch_array($username_query);

    if($userdata_array){
        //username exists
        $username_exists=true;
          
      //CHECK IF THE HASHED PASSWORD MATCHES CURRENT HASH
      if(password_verify($password,$userdata_array["password"])){
          try{
        //password matches the username
        $password_match=true;
   ////////////////////LOGIN IS SUCCESS //////////////////////////////     
        //SET COOKIES-SESSION AND LOG IN
        $daysInSeconds=86400*3;
        if($rememberCheck=="yes"){
        //SET REMEMBER COOKIE TO KNOW IF COOKIES WERE SENT
        setcookie("remember","yes",time()+$daysInSeconds);
        //SET COOKIES
        setcookie("username",$userdata_array["username"],time()+$daysInSeconds);
        setcookie("email",$userdata_array["email"],time()+$daysInSeconds);
        setcookie("age",$userdata_array["age"],time()+$daysInSeconds);
        setcookie("profileImage",$userdata_array["profileImage"],time()+$daysInSeconds);
        setcookie("ID",$userdata_array["hikerID"],time()+$daysInSeconds);
        setcookie("type",$userdata_array["type"],time()+$daysInSeconds);
        }
        else{
            //SET FORGET COOKIE TO KNOW IF SESSIONS WERE SENT
           setcookie("remember","no",time()+$daysInSeconds);
            //SET TEMPORARY SESSIONS
            session_start();
            $_SESSION["username"]=$userdata_array["username"];
            $_SESSION["email"]=$userdata_array["email"];
            $_SESSION["age"]=$userdata_array["age"];
            $_SESSION["profileImage"]=$userdata_array["profileImage"];
            $_SESSION["ID"]=$userdata_array["hikerID"];
            $_SESSION["type"]=$userdata_array["type"];

        }
        //SEND SUCCESS RESPONSE
          $success_msg=["success"=>"user validated"];
          header('Content-Type: application/json');
          $jsonData=json_encode($success_msg);
          //return the error to the client
          echo $jsonData;


          }
          catch(Exception $error){
            $error_msg=["error"=>$error];
            header('Content-Type: application/json');
            $jsonData=json_encode($error_msg);
            echo $jsonData;
          }
      }   


    }
    
    if(!$username_exists || !$password_match){
        $error_msg=["error"=>"Username or password don't match"];
        header('Content-Type: application/json');
        $jsonData=json_encode($error_msg);
        echo $jsonData;
    }

  
}
    
else{
    $error_msg=["error"=>"Form is not valid"];
    header('Content-Type: application/json');
    $jsonData=json_encode($error_msg);
    echo $jsonData;
}



?>