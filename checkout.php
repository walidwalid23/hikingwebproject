<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="checkout.css">
<link rel="stylesheet" href="icons/css/all.css">
<title> Cart </title>

</head>
<body>
<?php

include 'navbar.php';
try{
//get the hiker id
if($_COOKIE["remember"]=="yes"){
    $hiker_id=$_COOKIE["ID"];
  }
  else{
   
    $hiker_id= $_SESSION["ID"];
  }
 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

 $result=$db_conn->query("SELECT* FROM hikingpost,cart WHERE hikingpost.postID=cart.productID AND cart.hikerID='$hiker_id'");
 $all_products=mysqli_fetch_all($result,MYSQLI_ASSOC);


echo '<h1 id="cart-word"> Trips Cart </h1>';

 //display this if there are no products in the cart
if(count($all_products)==0){

    echo' <div class="card">
    <div class="card-body">
   
  
      <h3> Your Cart Is Empty </h3>


    </div>
  </div>';
    
}
else{
$total_price=0;
 for($i=0;$i<count($all_products);$i++){
    $trip_id=$all_products[$i]["postID"];
    $trip_title=$all_products[$i]["title"];
    $trip_image=$all_products[$i]["postImage"];
    $trip_price=$all_products[$i]["price"];
    $trip_location=$all_products[$i]["location"];
    $trip_image_path="postpictures/".$trip_image;

   echo' <div class="card">
    <div id="trip-title" class="card-header">
      '.$trip_title.'
    </div>
    <div class="card-body">
   
   <img src="'.$trip_image_path.'" alt="trip image" width="300px" height="200px">
   <span id="location-title">Location: </span>
   <span  id="trip-location">'.$trip_location.'</span>
   <span id="price-title">Price: </span>
   <span id="trip-price">'.$trip_price.' $</span>
   <a href="deleteonecartproduct.php?hikerid='.$hiker_id.'&tripid='.$trip_id.'" id="delete-trip"> Delete <i class="fas fa-trash"></i></a>
  
  


    </div>
  </div>';
   //add the price to the total price
   $total_price+=$trip_price;
 }
echo '<div style="background-color:white;width:100%;height:10%">
<span id="total-price">Total Price= '.$total_price.' $</span>
</div>';
echo '<a href="deletecartproducts.php?hikerid='.$hiker_id.'" id="checkout-button" type="button" class="btn btn-primary">Check Out</a>';
}
}

catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}


?>

</body>
</html>