<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="groups.css">
    <title>Group Members</title>
</head>
<body>
    <?php
include "navbar.php";
?>
<a class="sticky-top" href="creategroupform.php" type="button" id="create-group-button">Create Group </a>

<?php
//get the hiker id
$group_id=$_GET["group_id"];

       //CONNECTING TO THE DATABASE
       $db_conn=mysqli_connect("localhost","root","","hiking");
       if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
       
       $result=$db_conn->query("SELECT* FROM hiker,groupmembers WHERE hiker.hikerID=groupmembers.hikerID AND groupmembers.groupID='$group_id'");
       $records_array=mysqli_fetch_all($result,MYSQLI_ASSOC);

       for($i=0;$i<count($records_array);$i++){
        $hiker_id=$records_array[$i]["hikerID"];
        $hiker_username=$records_array[$i]["username"];
        $hiker_age=$records_array[$i]["age"];
        $hiker_image=$records_array[$i]["profileImage"];

      
        $image_path="profilepictures/".$hiker_image;

        echo '<div class="card w-100">
        <div class="card-body">
        <div id="group-img-div">
        <img id="group-img" src="'.$image_path.'">
        </div>
        <div id="group-text-div">
          <h5 style="margin-left:9%" class="card-title">'.$hiker_username.'</h5>
          <p style="margin-left:9%" class="card-text">'.$hiker_age.' Years</p>
          <a id="group-button" href="profilepage.php?hikerid='.$hiker_id.'" class="btn btn-primary">Visit Profile</a>
          </div>
        </div>
      </div>';
      echo "<br>";
       }
      //if there are no members in the group
       if(count($records_array)==0){
          
        echo '<h1 style="margin:15%;margin-left:33%">This Group Has No Members </h1>';
       }
     


?>


</body>
</html>