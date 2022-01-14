<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="groups.css">
    <title>Add/Delete Admins</title>
</head>
<body>
    <?php
//get the group id
$group_id=$_GET["groupid"];
//show the navigation bar
include "navbar.php";
echo '<a class="sticky-top" href="addadmin.php?groupid='.$group_id.'" type="button" id="create-group-button">Add Admins </a>'
?>

<?php
try{

//get current hiker ID
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];    
  //CONNECTING TO THE DATABASE
  $db_conn=mysqli_connect("localhost","root","","hiking");
  if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
  
//IF THERE IS HIKER ID IN THE GET REQUEST DELETE ADMIN (PAGE REFRECH WITH HIKER ID WHEN DELETE IS CLICKED)
if(isset($_GET["hikerid"])){


$clicked_hiker_id=$_GET["hikerid"];


$deleteResult=$db_conn->query("DELETE FROM groupadmins WHERE administratorID='$clicked_hiker_id' AND groupID='$group_id'");
if($deleteResult==true){

    echo '<div id="join-success" class="alert alert-success" role="alert">
    <p style="margin-left:43%">You Successfully Deleted This Administrator</p>
    </div>';

}
else{
    echo '<div style="display:none" id="error-div" class="alert alert-danger" role="alert">
<p id="error-word" style="margin-left:43%">You Couldn\'t Delete This Admin</p>
</div>';
}

}
   //////layout///
   echo '<h1>Admins:</h1>';
  
     
       $result=$db_conn->query("SELECT* FROM hiker,groupadmins WHERE hiker.hikerID=groupadmins.administratorID AND groupadmins.groupID='$group_id'");
       $records_array=mysqli_fetch_all($result,MYSQLI_ASSOC);

       for($i=0;$i<count($records_array);$i++){
    
        $hiker_id=$records_array[$i]["hikerID"];
        $hiker_username=$records_array[$i]["username"];
        $hiker_age=$records_array[$i]["age"];
        $hiker_image=$records_array[$i]["profileImage"];
        $image_path="profilepictures/".$hiker_image;

        if($current_hiker_id!=$hiker_id){   

        echo '<div class="card w-100">
        <div class="card-body">
        <div id="group-img-div">
        <img id="group-img" src="'.$image_path.'">
        </div>
        <div id="group-text-div">
          <h5 style="margin-left:9%" class="card-title">'.$hiker_username.'</h5>
          <p style="margin-left:9%" class="card-text">'.$hiker_age.' Years</p>
          <a id="group-button" href="profilepage.php?hikerid='.$hiker_id.'" class="btn btn-primary">Visit Profile</a>

          <a style="margin-left:10%" id="group-button" href="AddDeleteAdmins.php?groupid='.$group_id.'&hikerid='.$hiker_id.'" class="btn btn-danger">Delete Admin <i class="fas fa-user-times"></i></a>
          </div>
        </div>
      </div>';
      echo "<br>";
        }


       }
     
    

    }
    catch(Exception $error){
       echo '<div style="display:none" id="error-div" class="alert alert-danger" role="alert">
<p id="error-word" style="margin-left:43%">'.$error.'</p>
</div>';
    }
?>


</body>
</html>