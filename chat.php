<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="icons/css/all.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="chat.css">
<title> Chat </title>

</head>
<body>
<?php
////////////////////////////////SERVER/////////////////////////////////////
try{
    include 'navbar.php';
      //CONNECT TO DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
 else{
//get the receiver hiker id and tpe
$receiver_id=$_GET["receiverid"];
//get the receiver hiker type
$type_result=$db_conn->query("SELECT hiker.type FROM hiker WHERE hikerID='$receiver_id'");
$receiver_type=mysqli_fetch_array($type_result)["type"];
// get the sender id and type
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
$current_hiker_type=($_COOKIE["remember"]=="yes")?$_COOKIE["type"]:$_SESSION["type"];

//CREATE A CHAT RECORD BETWEEN THE TWO HIKERS ONLY FOR FIRST TIME
//CHECK IF THE HIKERS DON'T ALREADY HAVE A CHAT 
$result=$db_conn->query("SELECT * FROM chat WHERE person1ID='$current_hiker_id' AND person2ID='$receiver_id'
OR person1ID='$receiver_id' AND person2ID='$current_hiker_id' ");
$resulted_chat=mysqli_fetch_array($result);
//IF THERE IS A CHAT ID GET IT FROM THE DATABASE
if($resulted_chat){
    $chat_id=$resulted_chat["chatID"];
    //make the chat seen true for the current user since there is chat that exists already and he saw it(since he opened it)
    if($current_hiker_id==$resulted_chat["person1ID"]){
        //if the current user is person1 in the chat table
 $update_chat_seen=$db_conn->query("UPDATE chat SET person1seen=true WHERE chatID='$chat_id'");   
    }
    else{
        //he must be person2 if not person1
        $update_chat_seen=$db_conn->query("UPDATE chat SET person2seen=true WHERE chatID='$chat_id'");   
    }
if($update_chat_seen){
    //chat seen is updated successfully
}
else{
    echo '<h2 style="color:red">Error Occured While Updating Chat Seen</h2>';
}
}
//IF THERE IS NOT A CHAT ID CREATE A NEW ONE
else{
//generate a unique chat id
$chat_id=time()*rand(2,100);
//ADDING TRUE THEN FALSE BECAUSE PERSON1 IS THE CURRENT HIKER AND HE SAW THE CHAT(SINCE HE IS THE ONE WHO OPENED IT)
$chat_result=$db_conn->query("INSERT INTO chat VALUES('$chat_id','$current_hiker_id','$receiver_id','$current_hiker_type','$receiver_type',true,false)");
if($chat_result){
//CHAT IS CREATED SUCCESSFULLY
}
else{
    echo '<h4 style="color:red">Couldn\'t Create Chat</h4>';
}
}
/////////// GET THE MESSAGE DATA FROM THE DATABASE THEN DISPLAY IT///////////////////
//get the messages that the current hiker sent or that he received from the user in this chat
$message_result=$db_conn->query("SELECT* FROM message WHERE senderID='$current_hiker_id' AND receiverID='$receiver_id' 
OR receiverID='$current_hiker_id' AND  senderID='$receiver_id'");
$message_data=mysqli_fetch_all($message_result,MYSQLI_ASSOC);


echo '<h2 style="margin-left:43%">Chat Messages</h2>';
for($i=0;$i<count($message_data);$i++){
    
 $message_text=$message_data[$i]["messagetext"];
 $message_date=$message_data[$i]["messagedate"];
 $sender_id=$message_data[$i]["senderID"];
 $receiver_type=$message_data[$i]["receiverID"];
 $sender_type=$message_data[$i]["sendertype"];
 $receiver_type=$message_data[$i]["receivertype"];
 $message_seen=($message_data[$i]["seenreceiver"]==1)?true:false;

 //GET THE DATA OF THE SENDER FROM THE HIKER TABLE
 $sender_result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$sender_id' ");
 $sender_array=mysqli_fetch_array($sender_result);
 $sender_username=$sender_array["username"];
 $sender_image_path="profilepictures/".$sender_array["profileImage"];
  //GET THE DATA OF THE RECEIVER FROM THE HIKER TABLE
  $receiver_result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$receiver_id' ");
  $receiver_array=mysqli_fetch_array($receiver_result);
  $receiver_username=$receiver_array["username"];
  $receiver_image_path="profilepictures/".$receiver_array["profileImage"];

if($current_hiker_id==$sender_id){
    //IF THE CURRENT HIKER IS THE PERSON WHO SENT THIS MESSAGE SHOW THE MESSAGE THIS WAY
echo '
<div class="container sent">
  <img src="'.$sender_image_path.'" id="img-left" alt="Avatar" style="width:100%;">
  <span id="sender-username">'.$sender_username.' </span>
  <p id="chat-message-left" >
  '.$message_text.'
</p>';
if($message_seen){
    echo '<i class="fas fa-check-double"></i>';
}
else{
    echo '<i class="fas fa-check"></i>';
}
echo'<span class="time time-right">'. $message_date.'</span>
</div>';
}
else{
echo '<div class="container received">
  <img class="right" src="'.$receiver_image_path.'" id="img-right"  alt="Avatar" style="width:100%;">
  <span id="receiver-username">'.$receiver_username.'</span>
  <p id="chat-message-right"  >
  '.$message_text.'

</p>
<span class="time time-left">'. $message_date.'</span>
</div>

';
}
}



echo '
<div id="chat-input">
<textarea id="message-input" type="text" placeholder="Enter A Message..." rows="3"></textarea>
<button id="chat-input-send-button" type="button" class="btn btn-primary">Send</button>
<div>
<h4 id="error-p" style="color:red"></h4>';

/////////UPDATE THE VIEWED MESSAGES OF THE USER WHO SENT TO US TO SEEN////////////////
$update_seen_result=$db_conn->query("UPDATE message SET seenreceiver=true WHERE senderID='$receiver_id'");
if($update_seen_result){
    //////messages seen updated successfully
}
else{
    echo '<h2 style="color:red">Couldn\'t Update The Messages To Seen</h2>';
}

//GET THE CURRENT MESSAGES COUNT TO USE FOR REAL TIME LISTENING 
$messages_result=$db_conn->query("SELECT COUNT(messagetext) FROM message WHERE receiverID='$current_hiker_id'");
$current_messages_count=mysqli_fetch_array($messages_result)["COUNT(messagetext)"];


//pass the data to javascript
echo '<p id="chat-id" style="display:none">'.$chat_id.'</p>';
echo '<p id="sender-id" style="display:none">'.$current_hiker_id.'</p>';
echo '<p id="receiver-id" style="display:none">'.$receiver_id.'</p>';
echo '<p id="sender-type" style="display:none">'.$current_hiker_type.'</p>';
echo '<p id="receiver-type" style="display:none">'.$receiver_type.'</p>';
echo '<p id="messages-count" style="display:none">'.$current_messages_count.'</p>';
 }
}

catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}

?>

<script src="chat.js"></script>
</body>
</html>