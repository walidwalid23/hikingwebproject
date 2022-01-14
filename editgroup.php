<html>
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <style>
      body{

background-color:#F5DEB3;
}
#edit-form{
    margin-top:40px;
    margin-left:80px;
}
.form-control{
    width:50%;
}
.error-message{
        font-size:0.75em;
        color:red;
    }
   
        </style>
    <title>Edit Form</title>
</head>
<body>
    <?php

$group_id=$_GET["groupid"];

?>
    <div class="container">
<form id="edit-form" action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="group-name"><b>Edit Group Name:</b></label>
    <input type="text" class="form-control" id="group-name" name="groupname" placeholder="Group Name " >
       

    <p id="groupname-error" class="error-message"></p>
  </div>
 
  <div class="form-group">
    <label for="description"><b>Edit Group Description:</b></label>
    <input type="text" class="form-control" id="description" name="desc" 
    placeholder="Group Description ">  
    <p id="description-error" class="error-message"></p>
  
  </div>
  <div class="form-group">
    <label for="image"><b>Edit Group Image:</b></label>
    <input type="file" name="image-file" class="form-control" id="image">
  </div>
   <br>
  <button  type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button style="margin-left:10%" type="button" id="done-button" class="btn btn-primary">Done</button>
</form>
<p id="nochange-error" style="font-size:1.5em;margin-left:6%;" class="error-message"></p>
</div>
<?php
//send group id to the client side

echo '<p style="display:none" id="group-id-paragraph">'.$group_id.'</p>';

?>

<script src="editgroupvalidation.js">
</script>
</body>
</html>

<!--------------------------------SERVER SIDE------------------------------------------------------------>
<?php

if(isset($_POST["submit"])){
//getting the data
$group_name=$_POST["groupname"];
$group_desc=$_POST["desc"];
$image_file=$_FILES["image-file"];


 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

if($group_name){

    $group_name=filter_var($group_name,FILTER_SANITIZE_STRING);
    if(strlen($group_name)>=4){
        //group name is valid
   //UPDATING THE GROUP NAME
   $result=$db_conn->query("UPDATE hikinggroup SET name='$group_name' WHERE groupID='$group_id'");
   if($result){
     echo '<h5 style="color:green;margin-left:200px;">Group Name Is Updated Successfully<br>';
   }
   
   else{
     echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Group Name<br>';
   }


    }
}
else{
  echo '<h5 style="color:red;margin-left:200px;">The Group Name Field Is Empty</h5> <br>';

}


if($group_desc){

    if(strlen($group_desc)>=15){

   //UPDATING THE DESCRIPTION
   $result=$db_conn->query("UPDATE hikinggroup SET description='$group_desc' WHERE groupID='$group_id'");
   if($result){
     echo '<h5 style="color:green;margin-left:200px;">Group Description Is Updated Successfully<br>';
   }
   
   
   else{
     echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Group Description<br>';
   }


    }
    
}
else{
  echo '<h5 style="color:red;margin-left:200px;">The Description Field Is Empty</h5> <br>';

}

//image validation
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
if($image_file["error"]==0){
//SET THE NEW IMAGE
$image_name=$image_file["name"];
//move the file to the images folder
move_uploaded_file($image_file["tmp_name"],"grouppictures/$image_name");
//update the image name in the database
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("UPDATE hikinggroup SET groupImage='$image_name' WHERE groupID='$group_id'");
if($result){
  echo '<h5 style="color:green;margin-left:200px;">Group Image Is Updated Successfully<br>';
  
}
else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Update Group Image <br>';
}

}
else{

echo '<h5 style="color:red;margin-left:200px;">'.$error_messages[$image_file["error"]] .'<br>';
}


}

catch(Exception $error){ 
    echo '<h4 style="color:red">'.$error.'</h4>';
  }

    }
  


?>