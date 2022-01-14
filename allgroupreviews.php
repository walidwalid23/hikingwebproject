
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="allgroupreviews.css">
    <title>Group Reviews</title>
</head>
<body>
<?php
 include "navbar.php";

try{
   
if(isset($_GET["success"])){
    //show this message when the user comes after adding his review successfully
    echo '<div id="delete-success" class="alert alert-success" role="alert">
    <p style="margin-left:43%">Your Review Was Added Succcessfully</p>
    </div>';

}

//show all the reviews for this group
$group_id=$_GET["groupid"];

 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
 
 $result1=$db_conn->query("SELECT* FROM groupreviews WHERE groupID='$group_id'");
 $reviews_array=mysqli_fetch_all($result1,MYSQLI_ASSOC);
if($result1){
 for($i=0;$i<count( $reviews_array);$i++){
  $reviewer_ID= $reviews_array[$i]["reviewerID"];
  $stars_number= $reviews_array[$i]["stars"];
  $review= $reviews_array[$i]["review"];

  //get the reviewer data
 $result2=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$reviewer_ID'");
 $reviewer_array=mysqli_fetch_array($result2,MYSQLI_ASSOC);
 
 $reviewer_username= $reviewer_array["username"];
 $reviewer_age=$reviewer_array["age"];
 $reviewer_image=$reviewer_array["profileImage"];
 $image_path="profilepictures/".$reviewer_image;

  echo '<div id="review-card" class="card" style="width: 18rem;">
  <img class="card-img-top" src="'.$image_path.'" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">'.$reviewer_username.'</h5>';
   
   for($j=0;$j<$stars_number;$j++){
     
 echo  '<span class="card-text"> <i style="color:yellow" class="fas fa-star"></i>';
   }
   if($stars_number<5){
    for($k=$stars_number;$k<5;$k++){
   echo '<i style="color:yellow" class="far fa-star"></i>';
    }
   }
echo '</span>';
 echo ' <p class="card-text">'.$review.'.</p>
    <a href="profilepage.php?hikerid='.$reviewer_ID.'" class="btn btn-primary">Visit Profile</a>
  </div>
</div>';

echo "<br>";

 }

//if the group has no reviews
if(count($reviews_array)==0){
  echo '<h2 style="margin-left:35%;"> This Group Currently Has No Reviews</h2>';
}

}

else{

    echo '<h5 style="color:red;margin-left:200px;">Couldn"t Get Reviews<br>';

}
}

catch(Exception $error){

    echo '<h5 style="color:red;margin-left:200px;">'.$error.'<br>';
}


?>
</body>
</html>

