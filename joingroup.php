<?php
try{
//setting the second parameter to true to receive the data as an associative array
$received_data=json_decode(file_get_contents("php://input"),true);
$hiker_id=$received_data["userID"];
$group_id=$received_data["groupID"];
//CONNECTING TO THE DATABASE

$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("INSERT INTO groupmembers VALUES('$hiker_id','$group_id')");
if($result){
//inserted successfully send success response to client
$success_msg=["success"=>"group joined successfully"];
          header('Content-Type: application/json');
          $jsonData=json_encode($success_msg);
          //return the success json to the client
          echo $jsonData;

}
else{
     //send error response
    $error_msg=["error"=>"couldn't insert data"];
    header('Content-Type: application/json');
    $jsonData=json_encode($error_msg);
    echo $jsonData;
}

}

catch(Exception $error){
    echo '<h5 style="color:red;margin-left:200px;">'.$error.'<br>';
}


?>