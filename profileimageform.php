<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background-color:#F5DEB3;
        }
img{
    display:block;
}
input{
    display:block;
}
#image-edit-container{
    margin-left:37%;
    margin-top:8%;
    
}
.button{
    position:relative;
    left:12%;
    font-size:1.1em;
    border: 3px solid #6F4E37;
    border-radius: 1em;
    padding:0.2em;
    color:#1B140A;
}

.button:hover{
    box-shadow:0.02em 0.01em 0.2em 0.1em #964B00;
    cursor:pointer;
}

#cancel-button{
    position:relative;
    left:20%;
}

</style>
    <title>Profile Image</title>
</head>
<body>
    <?php
session_start();
$username=$_SESSION["username"];
echo '<h1 style="margin-left:40%">Welcome  '.$username.'</h1>';
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div id="image-edit-container">
        <b>Select Your Profile Image: </b>
        <?php
        //get the default image then get the uploaded image from session when it's uploaded
        if(isset($_SESSION["profileImage"])){

        $image_name=$_SESSION["profileImage"];
    }

        else{$image_name="defaultpicture.jpg";
        }

        $image_path="profilepictures/".$image_name;
   
    echo '<img src="' . $image_path . '" width="350px" height="300px">';
 
echo '<input type="file" name="imagefile" id="file-id">';
if( $_SESSION["img_reviewed"]==false){
echo '<input type="submit" name="submit-button" class="button">';
}
else if( $_SESSION["img_reviewed"]==true){
echo '<button type="submit" name="confirm-button"  class="button">Confirm</button>';
echo '<button id="cancel-button" type="button" class="button">Cancel </button>';
}

?>
 </div>
    </form>
<script>
let cancelButton=document.querySelector("#cancel-button");

cancelButton.addEventListener("click",function (){
    
//redirect to get the default image
window.location.href="noimage.php";

});

</script>

</body>
</html>


<?php

if(isset($_POST["submit-button"])){
echo "in submit";
    //a file is selected
  $image_file=$_FILES["imagefile"];
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
   //check for file errors
   if($image_file["error"]==0){
   //The file was successfully uploaded
    //only accept image/ file types
    $image_type=explode("/",$image_file["type"]);
    if($image_type[0]=="image"){
        //the file is of image type (accepted)
        $image_name=$image_file["name"];
if( $_SESSION["img_reviewed"]==false){
    //if not reviewed
       //move the image to the local folder
       move_uploaded_file($image_file["tmp_name"],"profilepictures/$image_name");
        //add the profile image name to the session
        $_SESSION["profileImage"]=$image_name;
        //reload the page to preview the image on the first click
        header("location:profileimageform.php");
        $_SESSION["img_reviewed"]=true;  
}   

}
    else{
        //not an image (rejected)
        echo'
        <p id="no-file-error" style="color:red;position:relative;margin-left:42%">
        The File Type Must Be An Image</p>
        ';
    }



   }
   else{
       //error occured while uploading the file
       echo'
       <p id="no-file-error" style="color:red;position:relative;margin-left:42%">'
       .$error_messages[$image_file["error"]].'</p>
       ';
   }

}


//IF IMAGE IS REVIEWED UPLOAD IT TO THE DATABASE WHEN CONFIRMATION IS CLICKED
if(isset($_POST["confirm-button"])) {
    try{
       
    //if reviewed 
       //upload the image to the database
       $username=$_SESSION["username"];
       $db_conn=mysqli_connect("localhost","root","","hiking");
       if(!$db_conn){die("couldn't connect to the database");}
       $picture_name=$_SESSION["profileImage"];
       $query_result=$db_conn->query("UPDATE hiker SET profileImage='$picture_name' WHERE
        username='$username'");
       if($query_result){
           //IMAGE IS UPLOADED SUCCESSFULLY
           //redirect to the home page
           header("location:home.php");
      
       }
   
       else{
        echo'
        <p id="no-file-error" style="color:red;position:relative;margin-left:42%">
        The Image Could not be uploaded try again</p>
        ';
       }
    }

    catch(Exception $error){
        echo '
        <p id="no-file-error" style="color:red;position:relative;margin-left:42%">
        Error Occured:'.$error.'</p>
        ';
        
    }

    }



?>
