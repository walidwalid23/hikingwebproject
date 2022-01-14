<?php
try{

$buyer_id=$_GET["hikerid"];
$trip_id=$_GET["tripid"];
//we need group id if request is coming from the group not the home
if(isset($_GET["groupid"])){
$group_id=$_GET["groupid"];
}

        //CONNECTING TO THE DATABASE
        $db_conn=mysqli_connect("localhost","root","","hiking");
        if(!$db_conn){echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
        $query_result=$db_conn->query("INSERT INTO boughttrips VALUES('$buyer_id','$trip_id')");
        if($query_result){
  
          //INSERTED SUCCESSFULLY
         if(isset($_GET["groupid"])){
         //if the buy trip was clicked on a group page:
          header("Location:groupprofile.php?groupid=$group_id&bought=true");
        }
        else{
          //if the buy trip was clicked on the home page:
            header("Location:home.php?success=trip is bought successfully");
          }

        }

        else{
            //SEND ERROR RESPONSE
            echo '<h1 style="color:red">Couldn Not Buy Trip</h1>';
        }


}

catch(Exception $error){

      echo '<h1 style="color:red">'.$error.'</h1>';

}
       



?>