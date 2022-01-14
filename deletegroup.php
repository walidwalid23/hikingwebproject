<?php
try{
//setting the second parameter to true to receive the data as an associative array
$received_data=json_decode(file_get_contents("php://input"),true);
$group_id=$received_data["groupID"];
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
//YOU MUST DELETE THE GROUP FROM FOREIGN TABLES FIRST THEN THE ORIGINAL TABLE TO AVOID CONSTRANT ERRORS
$result1=$db_conn->query("DELETE FROM groupmembers WHERE groupID='$group_id'");
$result2=$db_conn->query("DELETE FROM groupadmins WHERE groupID='$group_id'");
$result3=$db_conn->query("DELETE FROM hikingpost WHERE groupID='$group_id'");
$result4=$db_conn->query("DELETE FROM hikinggroup WHERE groupID='$group_id'");
if($result1 && $result2 && $result3 && $result4 ){
//inserted successfully send success response to client
$success_msg=["success"=>"group deleted successfully"];
          header('Content-Type: application/json');
          $jsonData=json_encode($success_msg);
          //return the success json to the client
          echo $jsonData;

}
else{
     //send error response
    $error_msg=["error"=>"couldn't delete group"];
    header('Content-Type: application/json');
    $jsonData=json_encode($error_msg);
    echo $jsonData;
}

}

catch(Exception $error){
    echo '<h5 style="color:red;margin-left:200px;">'.$error.'<br>';
}


?>