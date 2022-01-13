
<!DOCTYPE html>
<html>
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="groupprofile.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <title>Group</title>


</head>
<body>
    <?php
  

 include "navbar.php";



 if(isset($_GET["groupid"])){
   
     $group_id=$_GET["groupid"];
      //check if the user has already joined the group or not 
  if($_COOKIE["remember"]=="yes"){
    $hiker_id=$_COOKIE["ID"];
  }
  else{
  
    $hiker_id= $_SESSION["ID"];
  }
        //CONNECTING TO THE DATABASE
        $db_conn=mysqli_connect("localhost","root","","hiking");
        if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
        //check if the hiker is a member or not
     $result1=$db_conn->query("SELECT* from groupmembers WHERE hikerID='$hiker_id' AND groupID='$group_id'");
     $resulted_member_data=mysqli_fetch_array($result1);
     //check if the hiker is the admin of this group or not
     $result2=$db_conn->query("SELECT* from groupadmins WHERE administratorID='$hiker_id' AND groupID='$group_id'");
     $resulted_admin_data=mysqli_fetch_array($result2);

if($resulted_admin_data){
  echo '  <a class="sticky-top" href="addtripform.php?groupid='.$group_id.'&hikerid='.$hiker_id.'" type="button" id="add-trip-button">Add Trip </a>';
}
     
//////GET GROUP DATA FROM THE DATABASE
    $query_result= $db_conn->query("SELECT* FROM hikinggroup WHERE groupID='$group_id'");
    $group_data=mysqli_fetch_array($query_result);
    if($group_data){
    //get the group data
    $group_name=$group_data["name"];
    $group_desc=$group_data["description"];
    $group_image=$group_data["groupImage"];
//add div for success group join
if(isset($_GET["success"])){
echo '<div id="join-success" class="alert alert-success" role="alert">
<p style="margin-left:43%">You Successfully Joined This Group</p>
</div>';
}
if(isset($_GET["bought"])){
  echo '<div id="join-success" class="alert alert-success" role="alert">
  <p style="margin-left:43%">You Successfully Bought This Trip</p>
  </div>';
  }
//add div for success group leave
if(isset($_GET["group-left"])){
echo '<div id="leave-success" class="alert alert-success" role="alert">
<p style="margin-left:43%">You Successfully Left This Group</p>
</div>';
}
//add div for success group delete
if(isset($_GET["group-delete"])){
  echo '<div id="delete-success" class="alert alert-success" role="alert">
  <p style="margin-left:43%">You Successfully Left This Group</p>
  </div>';
  }
//errors div
echo '<div style="display:none" id="error-div" class="alert alert-danger" role="alert">
<p id="error-word" style="margin-left:43%"></p>
</div>';

     //set the group Name
    echo '<h1 id="group-name">'.$group_name.'</h1>';
    //set the group Image
    echo '<img id="group-image" src="grouppictures/'.$group_image.'">';
    
    //set the group description and members button
    echo '<p>
    <button id="description-button" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseDesc" aria-expanded="false" aria-controls="collapseDesc">
      Description';
 
   //ALL group reviews button
   echo ' <button onclick="goToAllReviewsPage()" id="all-reviews-button" class="btn btn-warning" type="button">
  View Group Reviews
</button>';
  
  //if there is data returned (user is a member in this group show joined button)
  if($resulted_member_data){
  
    echo ' <button  id="joined-button" class="btn btn-primary" type="button">
    Joined
  </button>';
  echo ' <button onclick="goToReviewPage()" id="review-button" class="btn btn-warning" type="button">
  Review Group
</button>';
  echo ' <button id="leave-button" class="btn btn-danger" type="button">
  Leave Group
</button>';
    
  }

  //if there is data returned (user is an admin in this group show owned button)
  else if($resulted_admin_data){
 
     //get the number of group members
  $result3=$db_conn->query("SELECT COUNT(hikerID) from groupmembers WHERE groupID='$group_id'");
  $members_count_array=mysqli_fetch_array($result3);
  $members_count=$members_count_array["COUNT(hikerID)"];
    echo ' </button>
    <button onclick="showMembers()" id="members-button" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseMembers" aria-expanded="false" aria-controls="collapseMembers">
  '.$members_count.' Member(s)
   
  </button>';
    echo ' <button id="owned-button" class="btn btn-success" type="button">
    Owned
  </button>';
  echo ' <button onclick="goToEditForm()" id="edit-button" class="btn btn-primary" type="button">
  Edit Group
</button>';
echo ' <button onclick="goToAddDeleteAdminsPage()" id="AddDelete-admins-button" class="btn btn-primary" type="button">
Add/Delete Administrators
</button>';
  echo ' <button id="delete-button" class="btn btn-danger" type="button">
  Delete Group
</button>';

  }
  else{
    //else show join button
 echo ' <button style="margin-left:30%" id="join-button" class="btn btn-secondary" type="button">
  Join Group
</button>';
  }
 

echo ' </p>
 <div class="collapse" id="collapseDesc">
    <div class="card card-body">
      '.$group_desc.'
    </div>
  </div>
';
 //get current user ID (throw to js)
  echo '<p id="user-id" style="display:none">'.$hiker_id.' </p>';
  //get the viewed group id (throw to js)
  echo '<p id="group-id" style="display:none">'.$group_id.' </p>';
  //add trips button
  //echo "<button>Add Trips </button>";

    }
    else{
        echo '<h5 style="color:red">GROUP DOESN"T EXIST</h5>';
    }
 }

else{
  
    echo '<h5 style="color:red">NOT FOUND 404</h5>';
}




//SHOW THE GROUP TRIPS
echo '<h2 id="trips-word">Trips</h2>';
include "alltrips.php";



?>
</div>
</div>
<script src="joingroup.js"></script>
<script src="leavegroup.js"></script>
<script src="deletegroup.js"></script>
<script src="viewmembers.js"></script>
<script src="editgroup.js"></script>
<script src="AddDeleteAdmins.js"></script>
<script>
//go to group review page
let hikerID=document.querySelector("#user-id").innerText;
let grouppID=document.querySelector("#group-id").innerText;

function goToReviewPage(){

window.location.href="groupreview.php?hikerid="+hikerID+"&groupid="+grouppID;

}
function goToAllReviewsPage(){

window.location.href="allgroupreviews.php?groupid="+grouppID;

}


</script>

<script src="bootstrap/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>