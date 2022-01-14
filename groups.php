<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="groups.css">
    <title>Groups</title>
</head>
<body>
    <?php
include "navbar.php";
?>
<a  class="sticky-top" href="creategroupform.php" type="button" id="create-group-button">Create Group </a>

<?php
       //CONNECTING TO THE DATABASE
       $db_conn=mysqli_connect("localhost","root","","hiking");
       if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
       
       $result=$db_conn->query("SELECT* FROM hikinggroup");
       $records_array=mysqli_fetch_all($result,MYSQLI_ASSOC);

       for($i=0;$i<count($records_array);$i++){
        $group_id=$records_array[$i]["groupID"];
        $group_name=$records_array[$i]["name"];
        $group_desc=$records_array[$i]["description"];
        $group_image=$records_array[$i]["groupImage"];
        $image_path="grouppictures/".$group_image;

        echo '<div class="card w-100">
        <div class="card-body">
        <div id="group-img-div">
        <img id="group-img" src="'.$image_path.'">
        </div>
        <div id="group-text-div">
          <h5 style="margin-left:9%" class="card-title">'.$group_name.'</h5>
          <p class="card-text">'.$group_desc.'</p>
          <a id="group-button" href="groupprofile.php?groupid='.$group_id.'" class="btn btn-primary">Visit Group</a>
          </div>
        </div>
      </div>';
      echo "<br>";
       }
     


?>


</body>
</html>