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
        //add the product to the cart
        $query_result=$db_conn->query("INSERT INTO cart VALUES('$buyer_id','$trip_id')");
        if($query_result){

         //INSERTED SUCCESSFULLY
         if(isset($_GET["groupid"])){
            //if the add to cart was clicked on a group page:
          header("Location:groupprofile.php?groupid=$group_id");
            }
            else{

            //if the add to cart was clicked on the home page:
            header("Location:home.php");
            }

        }

        else{
            //SEND ERROR RESPONSE
            echo '<h1 style="color:red">Could Not Add Product To Cart(Repeated Product)</h1>';
        }


}

catch(Exception $error){

      echo '<h1 style="color:red">'.$error.'</h1>';

}
       



?>