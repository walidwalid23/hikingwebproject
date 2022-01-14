<?php
try{
$hiker_id=$_GET["hikerid"];
$trip_id=$_GET["tripid"];
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$result=$db_conn->query("DELETE FROM cart WHERE hikerID='$hiker_id' AND productID='$trip_id'");


if($result){
    //product deleted successfully
    header("Location:checkout.php");
}



}
catch(Exception $error){
 echo '<h4 style="color:red">'.$error.'</h4>';
}





?>