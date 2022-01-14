
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trip</title>

    <style>
.error-message{
        font-size:0.75em;
        color:red;
    }

    </style>
</head>




<body style="background-color:#F5DEB3">
<?php session_start();
 if(isset($_SESSION["tripinserted"])){

echo '<div class="alert alert-success" role="alert">
<p style="margin-left:43%"> Trip Is Inserted Successfully </p>
</div>';

} ?>
<div class="container">
<form id="create-form" action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="tripname"><b>Trip Title:</b></label>
    <input type="text" class="form-control" id="tripname" name="tripname" >
    <p id="tripname-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="triplocation"><b>Trip Location:</b></label>
    <input type="text" class="form-control" id="triplocation" name="triplocation" >
    <p id="triplocation-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="tripdescription"><b>Trip Description:</b></label>
    <textarea id="tripdescription" class="form-control" name="tripdescription" rows="4" cols="50"> </textarea>
    <p id="tripdesc-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="tripprice"><b>Trip Price(dollars):</b></label>
    <input type="number" class="form-control" id="tripprice" name="tripprice" placeholder="Enter Price" >
    <p id="tripprice-error" class="error-message"></p>
  </div>
  <div class="form-group">
    <label for="image"><b>Select Trip Image:</b></label>
    <input type="file" name="image-file" class="form-control" id="image">
  </div>
  
   <br>
  <button id="submit-button" type="submit" name="submit" class="btn btn-primary">Submit</button>
  <?php 
 if(isset($_SESSION["tripinserted"])){

echo '<button id="done-button" type="button" name="done-button" class="btn btn-primary">Done</button> ';
//get the group id and hiker id from the url
echo '<p style="display:none" id="group-id-p">'.$_GET["groupid"].'</p>';

//unsert the session to startover
unset($_SESSION["tripinserted"]);
} ?>
</form>

</div>

<script src="addtripformvalidation.js"></script>
</body>
</html>

<?php

if(isset($_POST["submit"])){
$trip_title=$_POST["tripname"];
$trip_desc=$_POST["tripdescription"];
$trip_location=$_POST["triplocation"];
$trip_price=$_POST["tripprice"];
$trip_image_file=$_FILES["image-file"];
//validation variables
$tite_valid=false;
$location_valid=false;
$price_valid=false;
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
if($trip_image_file["error"]==0){
  $image_valid=true;  
//SET THE NEW IMAGE
$image_name=$trip_image_file["name"];
//move the file to the images folder
move_uploaded_file($trip_image_file["tmp_name"],"postpictures/$image_name");

}
else{

echo '<h5 style="color:red;margin-left:200px;">'.$error_messages[$trip_image_file["error"]] .'<br>';
}

////////name validation/////////
if(strlen($trip_title)>=4){
    $title_valid=true;
}
else{
    echo '<h5 style="color:red;margin-left:200px;">Trip Title Length Must Exceed 3 Characters<br>';
}
////////description validation/////////
if(strlen($trip_desc)>=15){
    $desc_valid=true;
}
else{
    echo '<h5 style="color:red;margin-left:200px;">Trip Description Length Must Exceed 15 Characters<br>';
}
if($trip_location==""){
  echo '<h5 style="color:red;margin-left:200px;">Trip Location Field Cannot Be Empty<br>';
}
else{
  $location_valid=true;
}
if(!$trip_price){
  echo '<h5 style="color:red;margin-left:200px;">Trip Price Field Cannot Be Empty<br>';
}
else{
  $price_valid=true;
}
if($image_valid && $desc_valid && $title_valid && $location_valid && $price_valid){
    //GENERATE TRIP ID
    $trip_id=time()*rand(2,100);
  //group id and trip administrator id
    $group_id=$_GET["groupid"];
    $admin_id=$_GET["hikerid"];

       //CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("INSERT INTO hikingpost VALUES('$trip_id','$trip_title','$image_name','$trip_price',
'$trip_desc','$trip_location','$group_id','$admin_id')");

if($result ){

  $_SESSION["tripinserted"]=true;
  header("location:addtripform.php?groupid=$group_id&hikerid=$admin_id");
}


else{
  echo '<h5 style="color:red;margin-left:200px;">Couldn"t Insert Trip Data <br>';
}


}

}

catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}

}


?>