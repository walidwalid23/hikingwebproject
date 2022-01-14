<?php
try{
//setting the second parameter to true to receive the data as an associative array
$received_data=json_decode(file_get_contents("php://input"),true);

//if comment is empty
if(!$received_data["comment"]){
    echo '<p style="red"> You Can\'t Leave The Comment Field Empty </p>';
}

else {
//add the review in the database
$groupID=$received_data["groupid"];
$reviewerID=$received_data["hikerid"];
$reviewComment=$received_data["comment"];
$reviewStars=$received_data["stars"];

 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

 $result=$db_conn->query("INSERT INTO groupreviews VALUES('$reviewerID','$groupID',$reviewStars,'$reviewComment')");

 if($result){
     //inserted successfully send success response to client
$success_msg=["success"=>"review inserted successfully"];
header('Content-Type: application/json');
$jsonData=json_encode($success_msg);
//return the success json to the client
echo $jsonData;
 }
else{
      //send error response
      $error_msg=["error"=>"You Already Voted"];
      header('Content-Type: application/json');
      $jsonData=json_encode($error_msg);
      echo $jsonData;
  }
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