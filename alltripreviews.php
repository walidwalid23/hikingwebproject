
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="alltripreviews.css">
    <link rel="stylesheet" href="allgroupreviews.css">
    <title>Trip Reviews</title>
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
$trip_id=$_GET["tripid"];

 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database</h5><br>';}
 
 $result1=$db_conn->query("SELECT* FROM tripreviews WHERE postID='$trip_id'");
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

    <button type="button" style="margin-left:5%;"  class="btn btn-primary comment-button">Comments</button>
    <br><br>';
//GET THE COMMENTS FOR EACH REVIEW FROM THE COMMENTS TABLE USING REVIEWERID AND POSTID AS REVIEW KEYS
$comments_result=$db_conn->query("SELECT* FROM reviewcomments WHERE reviewerID='$reviewer_ID' AND postID='$trip_id'");
$comments_data_array=mysqli_fetch_all($comments_result,MYSQLI_ASSOC);

  echo '<ul style="display:none;list-style-type: none;" class="comments-list">';
  for($h=0;$h<count($comments_data_array);$h++){
    $commenter_id=$comments_data_array[$h]["commenterID"];
    $comment=$comments_data_array[$h]["comment"];
    //GET THE DATA OF THE COMMENTER FROM THE HIKER TABLE
    $commenter_result=$db_conn->query("SELECT* FROM hiker WHERE hikerID='$commenter_id'");
    $commenter_data_array=mysqli_fetch_array($commenter_result);
    $commenter_username=$commenter_data_array["username"];
    $commenter_image=$commenter_data_array["profileImage"];
    $commenter_image_path="profilepictures/".$commenter_image;
    $commenter_type=$commenter_data_array["type"];

  echo'<a href="profilepage.php?hikerid='.$commenter_id.'" class="commenter-profile-link">';
 echo' <li class="comment-container">
<img src="'.$commenter_image_path.'" class="comment-img""> ';
if($commenter_type=="auditor"){
  //style the username and comment differently if the auditor is the one who commented
 echo' <span class="commenter-username auditor-username">'.$commenter_username.' </span>';
echo '<p class="comment auditor-comment">'.$comment.' </p>';
}
else{
  echo' <span class="commenter-username">'.$commenter_username.' </span>';
  echo '<p class="comment">'.$comment.' </p>';
}
echo'</li></a>';
  }
  echo'</ul>';
echo '
<form action="alltripreviewsserver.php?tripid='.$trip_id.'&reviewerid='.$reviewer_ID.'" method="post">
<div style="display:none;" class="comment-input">
<input style="width:80%;" id="comment" type="text" placeholder="Enter Your Comment" name="comment"> 
<button type="submit" id="submit-button" name="submit"  class="btn btn-primary">Comment</button>
</div>
</form>
<p style="color:red" id="error-message"></p>

  </div>
</div>';

echo "<br>";

 }

//if the trip has no reviews
if(count($reviews_array)==0){
    echo '<h2 style="margin-left:35%;"> This Trip Currently Has No Reviews</h2>';
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
<script src="alltripreviews.js"></script>
</body>
</html>



