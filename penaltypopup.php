<html>
    <head>
      <style>
      #popup-div{
          width:500px;
          height:400px;
          background-color:white;
          margin-top:7%;
          margin-left:35%;
      }
      #penalty-header{
          margin-left:40%;
          color:red;
      }
      #penalty-reason{
        margin-top:5%;
    margin-left:5%;
    font-weight:bold;
}
#submit-button{
  margin-top:35%;
    margin-left:30%;
}
      </style>
</head>  
<body>


<?php
//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database</h5><br>';}
//get the current hiker id
$current_hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
$result=$db_conn->query("SELECT* from penalty WHERE administratorID='$current_hiker_id'");
$penalty_array=mysqli_fetch_array($result);

$penalty_reason=$penalty_array["penaltyReason"];

echo'
  <div id="popup-div">
  <h2 id="penalty-header"> Penalty </h2>
  <hr>';
  echo '<h3>Reason:</h3>';
  echo '<p id="penalty-reason">'.$penalty_reason.' </p>';
  echo '
  <form action="" method="get">
  
  <button id="submit-button" type="submit" name="submit" class="btn btn-primary">I Won\'t Do This Again</button>
  
  </form>
  ';
 echo' </div>';

?>
</body>
</html>

<?php
//removing the penalty after agreeing to the pop up
if(isset($_GET["submit"])){

  $delete_penalty=$db_conn->query("DELETE from penalty WHERE administratorID='$current_hiker_id'");
 if($delete_penalty==true){
//reload the page
header("Location:home.php");

 }
  else{
    echo"<h2>Error While Deleting The Penalty</h2>";
  }

}


?>