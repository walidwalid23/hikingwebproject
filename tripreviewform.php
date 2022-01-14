<html lang="en">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="groupreview.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Trip Review</title>
</head>
<body>
    <?php
$trip_id=$_GET["tripid"];
$hiker_id=$_GET["hikerid"];
if(isset($_GET["groupid"])){
$group_id=$_GET["groupid"];
}
//////////style/////////////
include 'navbar.php';
echo '
<div id="all-review-div">
<h2 id="rate-word"> Rate This Trip:</h2> ;
<div id="stars-div">
<i  class="far fa-star star "></i>
<i  class="far fa-star star"></i>
<i class="far fa-star star"></i>
<i class="far fa-star star"></i>
<i class="far fa-star star"></i>
</div>
<div id="stars-number" style="margin-left:10%;font-size:1.5em"> Stars: 0 </div>
<h2 class="review-word" >Write Your Review:</h2>
<textarea id="review-comment" class="review-word" rows="6" cols="50"></textarea>
<br>
<button id="submit-button" type="button" class="btn btn-primary">Submit</button>';
if(isset($_GET["groupid"])){
    echo '<button  id="cancel-button-group"  type="button" class="btn btn-primary">Cancel</button>';
     //hide the home cancel button
     echo '<button style="display:none"  id="cancel-button-home"   type="button" class="btn btn-primary">Cancel</button>';
    }
else{
    //hide the group cancel button without removing it for javascript errors
    echo '<button  style="display:none" id="cancel-button-group"   type="button" class="btn btn-primary">Cancel</button>';
    //show the home cancel button
    echo '<button  id="cancel-button-home"   type="button" class="btn btn-primary">Cancel</button>';
}

echo'<p id="comment-error" class="error-text"> </p>
<p id="stars-error" class="error-text"> </p>
</div>
';

//path group id to javascript

?>
<!----------------------------------JAVASCRIPT AND REVIEWS LOGIC HERE----------------------------->
<script>
let stars=document.querySelectorAll(".star");
//listen for mouse hover
for(let i=0;i<stars.length;i++){

stars[i].addEventListener("mouseover",function(){
    for(let j=0;j<=i;j++){

   stars[j].style.color="yellow";  
   
    }
});

}
//listen for mouse release (before clicking)
for(let i=0;i<stars.length;i++){

stars[i].addEventListener("mouseout",function(){
    for(let j=0;j<stars.length;j++){
   stars[j].style.color="black";  
    }
    
});
}

//listen for mouse click (stars submitting)
let starsNumber=0;
for(let i=0;i<stars.length;i++){

stars[i].addEventListener("click",function(){
   
//change stars from 1 to clicked star to bold
    for(let j=0;j<=i;j++){
        console.log("here")
stars[j].style.color="yellow";  
stars[j].classList.remove("far");
stars[j].classList.add("fas");

    }
    //change starts after the clicked star to not bold
    for(let j=i+1;j<stars.length;j++){
   
stars[j].classList.remove("fas");
stars[j].classList.add("far");

    }
    //listen for mouse release (after clicking)
    stars[i].addEventListener("mouseout",function(){
    for(let j=0;j<stars.length;j++){
   stars[j].style.color="yellow";  
    }
    
 });
 

//show the stars number
let starsNumberParagraph=document.querySelector("#stars-number");
starsNumber=i+1;
starsNumberParagraph.innerText="Stars: "+starsNumber;
    

//remove the stars error message(because they are not 0 now since clicked)
let errorP2=document.querySelector("#stars-error");
errorP2.innerText="";


});

}

//SubmitButton listener
let submitButton=document.querySelector("#submit-button");
let reviewArea=document.querySelector("#review-comment");
let errorP1=document.querySelector("#comment-error");
submitButton.addEventListener("click",async function (){
    let errorP2=document.querySelector("#stars-error");
    let validComment=false;
    let validStars=false;
 if(reviewArea.value==""){
     //if comment field is empty show error message
     errorP1.innerText="You Can't Leave The Review Text Field Empty";

 }   
 else{
    validComment=true;
 }
 if(starsNumber==0){
    errorP2.innerText="You Have To Choose The Number Of Stars";
 }
 else{
     validStars=true;
 }
 if(validComment && validStars){
//send a post request with the review data
 let tripID= <?php echo $trip_id ?>;
 let hikerID= <?php echo $hiker_id ?>;
 let reviewComment=reviewArea.value;

 let addReviewResponse=await axios.post("addtripreview.php",{
     tripid:tripID,
     hikerid:hikerID,
     stars:starsNumber,
     comment:reviewComment
 });
console.log(addReviewResponse);
 if(addReviewResponse.data.success){
     //we received success response
     window.location.href="alltripreviews.php?success=true?&tripid="+tripID;

 }
 else if(addReviewResponse.data.error){
     errorP1.innerText=addReviewResponse.data.error;
 }

}




});


//CancelButton from Group listener
let cancelButtonGroup=document.querySelector("#cancel-button-group");

cancelButtonGroup.addEventListener("click",function (){
    
 let groupID= <?php 
    if(isset($_GET["groupid"])){
    echo $group_id;
    } ?>


window.location.href="groupprofile.php?groupid="+groupID;
 

});
//CancelButton from Home listener
let cancelButtonHome=document.querySelector("#cancel-button-home");

cancelButtonHome.addEventListener("click",function (){
window.location.href="home.php";

});

//text input listener
reviewArea.addEventListener("input",function (){
errorP1.innerText="";

});


</script>

</body>
</html>