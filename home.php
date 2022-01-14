
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
   
    /*

$username=$_COOKIE["username"];
$age=$_COOKIE["age"];

echo "<h1>Welcome: ".$username."</h1>"; 
echo "<h3>Age: ".$age."</h3>"; 
echo $_COOKIE["profileImage"];
*/
 
?>

<?php
echo '<div class="container-fluid">';

include "navbar.php";
  //success div for any success requests
  if(isset($_GET["success"])){
    echo '<div class="alert alert-success" role="alert">
<p style="margin-left:43%">'.$_GET["success"].'</p>
</div>';
}
    
    
    include 'userjoinedgroupstrips.php';
    
    ?>



</div>

<script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>