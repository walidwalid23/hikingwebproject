<?php
try{
//setting the second parameter to true to receive the data as an associative array
$received_data=json_decode(file_get_contents("php://input"),true);
$chat_id=$received_data["chatID"];
$message_text=$received_data["message"];
$current_date=$received_data["currentDate"];
$seen_receiver=$received_data["seenReceiver"];
$sender_id=$received_data["senderID"];
$receiver_id=$received_data["receiverID"];
$sender_type=$received_data["senderType"];
$receiver_type=$received_data["receiverType"];

//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$insert_msg_result=$db_conn->query("INSERT INTO message Values('$chat_id','$message_text','$current_date','$seen_receiver'
,'$sender_id','$receiver_id','$sender_type','$receiver_type')");

if($insert_msg_result==true){
//SET THE SEEN OF THE CHAT OF THE USER WHO SENT THE MESSAGE TO TRUE AND THE OTHER PERSON TO FALSE
$chat_result=$db_conn->query("SELECT* FROM chat WHERE chatID='$chat_id'");
$chat_data_array=mysqli_fetch_array($chat_result);
    if($sender_id==$chat_data_array["person1ID"]){
 //if the current user(sender) is person1 in the chat table
 $update_chat_seen=$db_conn->query("UPDATE chat SET person1seen=true,person2seen=false WHERE chatID='$chat_id'");  
}
   else{
//he must be person2 if not person1
$update_chat_seen=$db_conn->query("UPDATE chat SET person2seen=true,person1seen=false WHERE chatID='$chat_id'"); 
}

if($update_chat_seen==true){
//ADD ONE TO THE NEW MESSAGES IN THE INBOX OF THE RECEIVER
$update_inbox=$db_conn->query("UPDATE inbox SET newmessagesnum=newmessagesnum+1 WHERE hikerID='$receiver_id'"); 
if($update_inbox==true){

$success_response=["success"=>"Message Inserted Successfully"];
header('Content-Type: application/json');
$jsonData=json_encode($success_response);
//return the success json to the client
echo $jsonData;
}
else{
    //send error response
    $error_msg=["error"=>"couldn't Update Inbox"];
    header('Content-Type: application/json');
    $jsonData=json_encode($error_msg);
    echo $jsonData;
}

}
else{
    //send error response
    $error_msg=["error"=>"couldn't Update Seen Status"];
    header('Content-Type: application/json');
    $jsonData=json_encode($error_msg);
    echo $jsonData;
}
}
else{
       //send error response
       $error_msg=["error"=>"couldn't Insert Message"];
       header('Content-Type: application/json');
       $jsonData=json_encode($error_msg);
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