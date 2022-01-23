
<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
<script>

</script>


<?php
echo '<div class="container-fluid">';

include "navbar.php";
  //success div for any success requests
  if(isset($_GET["success"])){
    echo '<div class="alert alert-success" role="alert">
<p style="margin-left:43%">'.$_GET["success"].'</p>
</div>';
}

//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database</h5><br>';}
//get the current hiker id
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
//CHECK IF THE CURRENT USER HAS A PENALTY TO SHOW IT TO HIM
$result=$db_conn->query("SELECT* from penalty WHERE administratorID='$current_hiker_id'");
$penalty_array=mysqli_fetch_array($result);
if($penalty_array){
    //the user has a penalty show it to him
include 'penaltypopup.php';
}
else{
    include 'userjoinedgroupstrips.php';

}
    
    ?>



</div>

<script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>