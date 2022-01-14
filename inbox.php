<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="icons/css/all.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="inbox.css">
<title> Inbox </title>

</head>
<body>
<?php
////////////////////////////////SERVER/////////////////////////////////////
try{
    include 'navbar.php';
      //CONNECT TO DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

// get the current user id
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];

/////////// GET THE CHATS DATA FROM THE DATABASE THEN DISPLAY IT///////////////////
//get the messages that the current hiker sent or that he received from the user in this chat
$chat_result=$db_conn->query("SELECT* FROM chat WHERE person1ID='$current_hiker_id' OR person2ID='$current_hiker_id'");
$chats_data=mysqli_fetch_all($chat_result,MYSQLI_ASSOC);

echo '<h2 style="margin-left:43%">Inbox<i style="margin-left:1%;" class="fas fa-envelope"></i></h2>';
//iterate over all the chats for the current hiker
for($i=0;$i<count($chats_data);$i++){
 $chat_id=$chats_data[$i]["chatID"];
 //KNOW IF THE CURRENT USER IS PERSON1 OR PERSON2 IN THE CHAT TO CHECK HIS SEEN OF THE CHAT
 if($current_hiker_id==$chats_data[$i]["person1ID"]){
     //check if person1(current user saw the chat)
 $chat_seen=($chats_data[$i]["person1seen"]==1)?true:false;
 }
 else{
    //check if person2(current user saw the chat)
 $chat_seen=($chats_data[$i]["person2seen"]==1)?true:false;
 }
 //GET THE DATA OF THE LAST MESSAGE FROM THE MESSAGE TABLE
 $messages_result=$db_conn->query("SELECT* FROM message WHERE chatID='$chat_id'");
 $messages_array=mysqli_fetch_all($messages_result,MYSQLI_ASSOC);
 $last_message_data=$messages_array[count($messages_array)-1];
 $last_message_text=$last_message_data["messagetext"];
 $last_message_date=$last_message_data["messagedate"];
 $last_message_sender_ID=$last_message_data["senderID"];
 
  //GET THE DATA OF THE SENDER OF THE LAST MESSAGE FROM THE HIKER TABLE
  $sender_result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$last_message_sender_ID'");
  $sender_array=mysqli_fetch_array($sender_result);
  $sender_username=$sender_array["username"];
  $sender_image_path="profilepictures/".$sender_array["profileImage"];
//get the message receiver(other user) id for the chat page
  $message_sender=$last_message_data["senderID"];
  $message_receiver=$last_message_data["receiverID"];
  $receiver_id=($current_hiker_id==$message_sender)?$message_receiver:$message_sender;
  //IF YOU SENT THE LAST MESSAGE SHOW THE USERNAME OF THE RECEIVER (ELSE DON'T SHOW IT)
  if($receiver_id!=$current_hiker_id){
  $receiver_result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$receiver_id'");
  $receiver_array=mysqli_fetch_array($receiver_result);
  $receiver_username=$receiver_array["username"];
  }
   
if($chat_seen){
    
echo '<a id="inbox-chat-button" href="chat.php?receiverid='.$receiver_id.'">
<div class="container sent">';
 //IF YOU SENT THE LAST MESSAGE SHOW THE USERNAME OF THE RECEIVER (ELSE DON'T SHOW IT)
 if($receiver_id!=$current_hiker_id){
     echo '<p id="receiver-username">Chatting With: '.$receiver_username.' </p>';
}
 echo' <img src="'.$sender_image_path.'" id="img-left" alt="Avatar" style="width:100%;">
  <span id="sender-username">'.$sender_username.' </span>
  <p id="chat-message-left" >
  '. $last_message_text.'
</p>
<span class="time time-right">'. $last_message_date.'</span>
</div></a>';
}
else{
   
echo '
<a id="inbox-chat-button" href="chat.php?receiverid='.$receiver_id.'">
<div class="container received">
  <img  src="'.$sender_image_path.'" id="img-left" alt="Avatar" style="width:100%;">
  <span id="sender-username">'.$sender_username.'</span>
  <p id="chat-message-left"  >
  '.$last_message_text.'
</p>
<span class="time time-right">'. $last_message_date.'</span>
<span id="new-message-text">New Message!</span>
</div> 
</a>
';
}
}


//////SET THE INBOX NEW MESSAGES OF THE CURRENT USER TO ZERO SINCE HE SAW THE CHATS
$delete_inbox_notifications=$db_conn->query("UPDATE inbox SET newmessagesnum=0 WHERE hikerID='$current_hiker_id' ");
if($delete_inbox_notifications==false){

    echo '<h4 style="color:red">Couldn\'t Update Inbox Data</h4>';
}


}

catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}

?>


</body>
</html>