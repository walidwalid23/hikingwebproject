







<!--TAKE ALL THE DATA FROM THE DATABASE EXCEPT THE ID FROM A COOKIE OR SESSION-->






<!DOCTYPE html>
<html>
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="profilepage.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <title>Profile</title>
</head>
<body>
<?php
 include "navbar.php";
//connecting to database
try{
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}   
 //getting the hiker id from the url 
$hiker_id=$_GET["hikerid"];
//get the current hiker id
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
//get the hiker data from the database using his id
$result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$hiker_id'");
$hiker_data=mysqli_fetch_array($result);

$username=$hiker_data["username"];
$imageName=$hiker_data["profileImage"];
$age=$hiker_data["age"];
//new profile style
 echo '
<div class="container-fluid">
<div id="profile-background" class="row">
<div class="col-3">';
echo '<img id="profile-image" width="350px" height="300px" class="card-img-top" src="profilepictures/'.$imageName .'"alt="Profile Image">';
echo "</div>";
echo '<div class="col-3">';
echo '<span id="username" >'.$username.'</span>';
echo "</div>";
echo '<div class="col-3">';
echo '<p id="age">'.$age.'</p>';
echo "</div>";
//show the message box only for different users other than current user
if($current_hiker_id!=$hiker_id){
  echo '<div class="col-2">';
  echo '<a id="message-link" href="chat.php?receiverid='.$hiker_id.'"><span id="message-box-container">Message <i class="fas fa-envelope"></i></span></a>';
  echo "</div>";
  }
  //show the Edit Profile button only for the current user
  if($current_hiker_id==$hiker_id){
    echo '<div class="col-2">';
    echo '
    <div id="edit-container">
    <a href="profileeditform.php" id="edit-word"><b>Edit Profile</b></a>
    <label for="edit-word"><i id="user-edit-icon" class="fas fa-user-edit"></i></label>
    </div>
    ';
    echo "</div>";
    }
  
echo '</div>';

//GET THE JOINED GROUPS FROM THE DATABASE
$result1=$db_conn->query("SELECT COUNT(groupID) FROM groupmembers WHERE hikerID='$hiker_id' ");
$groups_joined_count=mysqli_fetch_array($result1,MYSQLI_ASSOC)["COUNT(groupID)"];
//USER JOINED GROUPS CARD
echo '<div class="col-lg-12">';
echo '<div id="joined-groups-card" class="card" style="width: 18rem;">
  <div style="margin-left:30%;" class="card-body">
    <h5 class="card-title">Joined Groups</h5>
    <h6 class="card-subtitle mb-2 text-muted">'.$groups_joined_count." Group(s)".'</h6>';
    if($current_hiker_id==$hiker_id){
      //show the joined groups only for the logged in hiker
  echo'  <a class="groups-button" href="joinedgroups.php" class="card-link">View Joined Groups</a>';
    }
  echo '</div>
</div>
</div>
';
//GET THE OWNED GROUPS FROM THE DATABASE
$result2=$db_conn->query("SELECT COUNT(groupID) FROM groupadmins WHERE administratorID='$hiker_id' ");
$groups_owned_count=mysqli_fetch_array($result2,MYSQLI_ASSOC)["COUNT(groupID)"] ;
//USER OWNED GROUPS CARD
echo '<div class="col-lg-12">';
echo '<div id="owned-groups-card" class="card" style="width: 18rem;">
  <div style="margin-left:30%;" class="card-body">
    <h5 class="card-title">Owned Groups</h5>
    <h6 class="card-subtitle mb-2 text-muted">'.$groups_owned_count." Group(s)".'</h6>';
    if($current_hiker_id==$hiker_id){
      //show the owned groups only for the logged in hiker
  echo '  <a class="groups-button" href="ownedgroups.php" class="card-link">View Owned Groups</a>';
  }
 echo '</div>
</div>
</div>
';

echo '</div>';
}
catch(Exception $error){
  echo '<h5 style="color:red;margin-left:200px;">'.$error.'<br>';
}
?>
</div>
</div>

<script src="bootstrap/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>