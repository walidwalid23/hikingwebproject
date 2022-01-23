<?php
/////////COMMENTS SERVER SIDE //////

  try{
      session_start();
$comment=$_POST["comment"];
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
$trip_id=$_GET["tripid"];
$reviewerID=$_GET["reviewerid"];
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database</h5><br>';}
//WE USE THE REVIEWERID AND TRIPID BECAUSE THEY ARE PRIMARY KEYS FOR THE TRIPREVIEWS TABLE
$comment_inserted=$db_conn->query("INSERT INTO reviewcomments VALUES('$current_hiker_id','$comment','$reviewerID','$trip_id')");

if($comment_inserted){
//reload the page
header("Location:alltripreviews.php?tripid=$trip_id");

}
else{
  echo '<h5 style="color:red;margin-left:200px;">Error Inserting The Comment</h5><br>';
}


}



catch(exception $error){
  echo '<h5 style="color:red;margin-left:200px;">'.$error.'</h5><br>';
}


?>