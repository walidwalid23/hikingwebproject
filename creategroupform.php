
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>

    <style>
.error-message{
        font-size:0.75em;
        color:red;
    }

    </style>
</head>




<body style="background-color:#F5DEB3">
<?php session_start();
 if(isset($_SESSION["groupinserted"])){

echo '<div class="alert alert-success" role="alert">
<p style="margin-left:43%"> Group Is Inserted Successfully </p>
</div>';

} ?>
<div class="container">
<form id="create-form" action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="groupname"><b>Group Name:</b></label>
    <input type="text" class="form-control" id="groupname" name="groupname" >
    <p id="groupname-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="groupdescription"><b>Group Description:</b></label>
    <textarea id="groupdescription" class="form-control" name="groupdescription" rows="4" cols="50"> </textarea>
    <p id="groupdesc-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="image"><b>Select Group Image:</b></label>
    <input type="file" name="image-file" class="form-control" id="image">
  </div>
   <br>
  <button id="submit-button" type="submit" name="submit" class="btn btn-primary">Submit</button>
  <?php 
 if(isset($_SESSION["groupinserted"])){

echo '<button id="done-button" type="button" name="done-button" class="btn btn-primary">Done</button> ';
echo '<p style="display:none" id="group-id-p">'.$_GET["groupid"].'</p>';
unset($_SESSION["groupinserted"]);
} ?>
</form>

</div>

<script src="creategroupvalidation.js"></script>
</body>
</html>

<?php

if(isset($_POST["submit"])){
$group_name=$_POST["groupname"];
$group_desc=$_POST["groupdescription"];
$group_image_file=$_FILES["image-file"];
//validation variables
$name_valid=false;
$desc_valid=false;
$image_valid=false;
////////image validation/////////
   //file errors array
   $error_messages = array(
    'the file uploaded successfully',
    'Error:The file exceeds the upload_max_filesize',
    'Error:The file exceeds the MAX_FILE_SIZE ',
 'Error:The file was only partially uploaded',
 'Select an image file to upload',
 'Error:Missing a temporary folder',
 'Error:Failed to write file to disk',
 'Error:A PHP extension stopped the file upload',
);
try{
if($group_image_file["error"]==0){
  $image_valid=true;  
//SET THE NEW IMAGE
$image_name=$group_image_file["name"];
//move the file to the images folder
move_uploaded_file($group_image_file["tmp_name"],"grouppictures/$image_name");

}
else{

echo '<h5 style="color:red;margin-left:200px;">'.$error_messages[$group_image_file["error"]] .'<br>';
}

////////name validation/////////
if(strlen($group_name)>=4){
    $name_valid=true;
}
else{
    echo '<h5 style="color:red;margin-left:200px;">Group Name Length Must Exceed 3 Characters<br>';
}
////////description validation/////////
if(strlen($group_desc)>=15){
    $desc_valid=true;
}
else{
    echo '<h5 style="color:red;margin-left:200px;">Description Length Must Exceed 15 Characters<br>';
}

if($image_valid && $desc_valid && $name_valid){
    //GENERATE GROUP ID
    $group_id=time()*rand(2,100);
  
       //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result1=$db_conn->query("INSERT INTO hikinggroup VALUES('$group_id','$group_name','$image_name','$group_desc')");
$hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
$result2=$db_conn->query("INSERT INTO groupadmins VALUES('$group_id','$hiker_id')");
if($result1 && $result2){

  $_SESSION["groupinserted"]=true;
  header("location:creategroupform.php?groupid=$group_id");
}


else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Insert Group Data <br>';
}


}

}

catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}

}





?>