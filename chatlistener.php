<?php
try{
$current_hiker_id=$_GET["hikerid"];

//CONNECT TO DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
 else{
     
   //GET THE NEW MESSAGES COUNT TO USE FOR REAL TIME LISTENING 
$messages_result=$db_conn->query("SELECT COUNT(messagetext) FROM message WHERE receiverID='$current_hiker_id'");
$new_messages_count=mysqli_fetch_array($messages_result)["COUNT(messagetext)"];

 //send the messages count back as a response
 $success_msg=["newMessagesCount"=>$new_messages_count];
          header('Content-Type: application/json');
          $jsonData=json_encode($success_msg);
          //return the success json to the client
          echo $jsonData;

 }

}
catch(Exception $error){
     //send error response
     $error_msg=["error"=>$error];
     header('Content-Type: application/json');
     $jsonData=json_encode($error_msg);
     echo $jsonData;
}


?>