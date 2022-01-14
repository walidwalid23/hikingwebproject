<html lang="en">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="groupreview.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Average Reviews</title>
    <style>
   #all-review-div{
      font-size:1.5em;
      padding-left:13%;
      padding-top:10%;
      margin-left:25%;
      margin-top:5%;
   }
   #done-button{
       text-decoration:none;
       position:relative;
       left:20%;
       top:10%;
       font-weight:800;
   }
        </style>
</head>
<body>
    <?php
$trip_id=$_GET["tripid"];
//we need group id if request is coming from the group not the home
if(isset($_GET["groupid"])){
$group_id=$_GET["groupid"];
}
 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
 $result=$db_conn->query("SELECT stars,COUNT(stars) FROM tripreviews WHERE postID='$trip_id' GROUP BY(stars)");
 $result_array=mysqli_fetch_all($result,MYSQLI_ASSOC);
 

//////////style/////////////
echo '
<div id="all-review-div">
';
echo '<h2> Trip Reviews </h2>';

$stars=array();
for($i=0;$i<count($result_array);$i++){
    $star_number=$result_array[$i]["stars"];
    $star_count=$result_array[$i]["COUNT(stars)"];
    //SHOWING THE STARS AND THEIR COUNT
  for($j=0;$j<$star_number;$j++){
      echo '<i style="color:yellow;" class="fas fa-star"></i>';
  }
  for($k=$star_number;$k<5;$k++){
   echo '<i style="color:yellow;"  class="far fa-star"></i>';
  }

  echo "    ".$star_count."  Reviewer(s)";

  echo "<br>";

  //add the star number to the stars array

  array_push($stars,$star_number);

}

for($i=0;$i<5;$i++){
    $star_exist=false;
    for($j=0;$j<count($stars);$j++){
if($stars[$j]==$i+1){
    $star_exist=true;
}
    }

    if($star_exist==false){
          //SHOWING THE STARS AND THEIR COUNT
  for($j=0;$j<$i+1;$j++){
    echo '<i style="color:yellow;" class="fas fa-star"></i>';
}
for($k=$i+1;$k<5;$k++){
 echo '<i style="color:yellow;"  class="far fa-star"></i>';
}

echo "    No Reviewer(s)";

echo "<br>";



    }


}
//if this page was viewed from group
if(isset($_GET["groupid"])){
echo '<a id="done-button" href="groupprofile.php?groupid='.$group_id.'">Done</a>';
}
//if this page was viewed from home
else{
    echo '<a id="done-button" href="home.php">Done</a>';
}
echo '</div>
';

//path group id to javascript

?>
<!----------------------------------JAVASCRIPT AND REVIEWS LOGIC HERE----------------------------->
<script>



</script>

</body>
</html>