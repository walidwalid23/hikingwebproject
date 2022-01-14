<?php
try{
$hiker_id=$_GET["hikerid"];

   //CONNECTING TO THE DATABASE
   $db_conn=mysqli_connect("localhost","root","","hiking");
   if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

   $delete_result=$db_conn->query("DELETE FROM cart WHERE hikerID='$hiker_id'");

   if($delete_result){
       //data deleted successfully
       header("Location:home.php?success=Checked Out Successfully");
   }



}
catch(Exception $error){
    echo '<h4 style="color:red">'.$error.'</h4>';
}

?>