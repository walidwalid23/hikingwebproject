<?php
try{
$search_value=$_GET["value"];

//CONNECTING TO THE DATABASE
$db_conn=mysqli_connect("localhost","root","","hiking");
if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}

$query_result=$db_conn->query("SELECT * FROM hikingpost WHERE title LIKE '$search_value%'
OR title LIKE'%$search_value'");
$results_array=mysqli_fetch_all($query_result,MYSQLI_ASSOC);

//send the resulted array as a response to the get request
header('Content-Type: application/json');
$results=["results"=>$results_array];
$jsonData=json_encode($results);
echo $jsonData;

}
catch(Exception $error){
       //send error response
       $error_msg=["error"=>$error];
       header('Content-Type: application/json');
       $jsonData=json_encode($error_msg);
       echo $jsonData;
}

?>