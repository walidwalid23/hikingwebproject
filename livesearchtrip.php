


<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="allgroupreviews.css">

    <style>
#avg-rating{
  text-decoration:none;
  color:black;
  display:block;
  font-size:1.4em;
font-weight:400;
}
#avg-rating:hover{
  cursor:pointer;
  font-weight:700;
}

</style>
    
</head>
<body>
<?php
include 'navbar.php';
try{
   
//show all the trips for this group

$trip_id=$_GET["tripid"];
  //get current the hiker id
  if($_COOKIE["remember"]=="yes"){
    $hiker_id=$_COOKIE["ID"];
  }
  else{
  
    $hiker_id= $_SESSION["ID"];
  }

 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
 
 $result1=$db_conn->query("SELECT* FROM hikingpost WHERE postID='$trip_id'");
 $trips_array=mysqli_fetch_array($result1);
if($result1){
   $trip_id=$trips_array["postID"];
    $trip_title= $trips_array["title"];
  $trip_price= $trips_array["price"];
  $trip_location= $trips_array["location"];
  $trip_description= $trips_array["description"];
  $trip_image= $trips_array["postImage"];
  $image_path="postpictures/".$trip_image;
  
  //get the average rating of the trip
  $result2=$db_conn->query("SELECT AVG(stars) FROM tripreviews WHERE postID='$trip_id'");
  $trip_avg_array=mysqli_fetch_array($result2);
   $avg_stars=$trip_avg_array["AVG(stars)"];
  //get the reviewer data

  echo '<div id="review-card" class="card" style="width: 18rem;">
  <img class="card-img-top" src="'.$image_path.'" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">Title: '.$trip_title.'</h5>
    <h5 class="card-title">Location: '.$trip_location.'</h5>
    <h5 class="card-text">Description: '.$trip_description.'</h5>
    <h5 class="card-title">Price: '.$trip_price.'$</h5>';
    if(isset($avg_stars)){
   echo ' <a href="averagerates.php?tripid='.$trip_id.'" id="avg-rating" class="card-title">Average Rating: '.$avg_stars.'</a>';
    }
    else{
      echo ' <h5 class="card-title">Average Rating: No Rating</h5>';
    }
    //CHECKING IF THE USER ALREADY BOUGHT THIS TRIP OR NOT
    $query_result=$db_conn->query("SELECT* FROM boughttrips WHERE hikerID='$hiker_id' AND tripID='$trip_id'");
    $data=mysqli_fetch_array($query_result);
    if($data){
      echo ' <!-- buy now button -->
   <button  type="button" class="btn btn-success" >
     Bought
   </button>';

    }
    else{
   echo ' <!-- buy now button -->
   <a href="buytrip.php?tripid='.$trip_id.'&hikerid='.$hiker_id.'"  id="buy-now-button" type="button" class="btn btn-primary" >
     Buy Now
   </a>';
    }
   
   echo ' <a href="addtocart.php?hikerid='.$hiker_id.'&tripid='.$trip_id.'"     id="add-to-cart-button" type="button"  style="margin-right:2%"  class="btn btn-primary">Add To Cart</a>';

    echo '<a style="margin-right:2%" href="tripreviewform.php?tripid='.$trip_id.'&hikerid='.$hiker_id.'" class="btn btn-warning">Review Trip</a>
    <a href="alltripreviews.php?tripid='.$trip_id.'" class="btn btn-warning">View Reviews</a>
  </div>
</div>';


}

else{

    echo '<h5 style="color:red;margin-left:200px;">Couldn"t Get Trip<br>';

}
}

catch(Exception $error){

    echo '<h5 style="color:red;margin-left:200px;">'.$error.'<br>';
}


?>
</body>
</html>

