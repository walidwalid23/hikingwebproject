<html lang="en">
<head>
 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Add Admin</title>
    <style>
        body{
            background-color:#F5DEB3;
        }
        .error-message{
        font-size:0.75em;
        color:red;
    }
   
    </style>
</head>
<body>
<?php

$group_id=$_GET["groupid"];

?>
    <div class="container">
<form id="add-form" action="" method="post" >
<div class="form-group">
    <label for="admin-name"><b>Add Admin Name:</b></label>
    <input type="text" class="form-control" id="admin-name" name="adminname" placeholder="Admin Name " >
    <p id="Adminname-error" class="error-message"></p>
  </div>
 
   <br>
  <button  type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button style="margin-left:10%" type="button" id="done-button" class="btn btn-primary">Done</button>
</form>
<p id="nochange-error" style="font-size:1.5em;margin-left:6%;" class="error-message"></p>
</div>

<?php
//send the group id to javascript
echo '<p style="display:none" id="group-id-p">'.$group_id.'</p>'
?>

<script>
  //CLIENT SIDE VALIDATION
  let addForm=document.querySelector("#add-form");
  let doneButton=document.querySelector("#done-button");
  let groupID=document.querySelector("#group-id-p").innerText;
  //redirect on done
  doneButton.addEventListener("click",function (){
window.location.href="groupprofile.php?groupid="+groupID;
  });
  
  addForm.addEventListener("submit",function (eventObj){
  let adminName=addForm.elements.adminname.value;
  let adminNameError=document.querySelector("#Adminname-error");

  if(!adminName){
   eventObj.preventDefault();
    adminNameError.innerText="You Can't Leave This Field Empty";
  }
  else{
   if(adminName.length<4){
    eventObj.preventDefault();
    adminNameError.innerText="Admin Name Character Length Must Be Above 3";
   }
  }
  }
  );

</script>

    
</body>
</html>

<!--------------------------------SERVER SIDE------------------------------------------------------------>
<?php
try{
if(isset($_POST["submit"])){
//getting the data
$admin_name=$_POST["adminname"];

 //CONNECTING TO THE DATABASE
 $db_conn=mysqli_connect("localhost","root","","hiking");
 if(!$db_conn){ echo '<h5 style="color:red;margin-left:120px;">Couldn"t Connect To Database<br>';}

if($admin_name){

    $admin_name=filter_var($admin_name,FILTER_SANITIZE_STRING);
    if(strlen($admin_name)>=4){
    //CHECK IF THE ADMIN NAME EXISTS IN THE HIKERS TABLE
    $result=$db_conn->query("SELECT* FROM hiker WHERE username='$admin_name'");
    $resulted_array=mysqli_fetch_array($result);
    if($resulted_array){
    //INSERT THE ADMIN IN THE GROUPADMINS TABLE
    $hiker_id=$resulted_array["hikerID"];
     
   if($result){
    $result2=$db_conn->query("INSERT INTO groupadmins VALUES('$group_id','$hiker_id')");
   
if($result2){
    echo '<h5 style="color:green;margin-left:120px;">Group Admin Is Added Successfully<br>';
}
    
  }
  else{
    echo '<h5 style="color:red;margin-left:120px;">Couldn"t Add Group Admin<br>';
  }

  
    }
    else{
        //THE WRITTEN USERNAME IS NOT FOUND IN THE HIKER TABLE
        echo '<h5 style="color:red;margin-left:120px;">This Admin Doesn\'t Exist</h5> <br>';
    }
      
  
    }
    else{
        echo '<h5 style="color:red;margin-left:120px;">The Admin Name Must Exceed 3 Characters<br>';

    }
}
else{
  echo '<h5 style="color:red;margin-left:120px;">The Admin Name Field Is Empty</h5> <br>';

}

}
}
catch(Exception $error){ 
    echo '<h4 style="color:red">'.$error.'</h4>';
  }

    
  


?>