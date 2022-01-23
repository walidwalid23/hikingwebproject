let commentButton = document.querySelectorAll(".comment-button");
let commentsList = document.querySelectorAll(".comments-list");
let commentInput = document.querySelectorAll(".comment-input");
let submitButton = document.querySelector("#submit-button");
let errorP = document.querySelector("#error-message");
/*ITERATING OVER THE CLASSES OF THE COMMENTS AND COMMENT INPUT OF EACH POST AND LISTENING FOR COMMENT
ON EACH ONE OF THEM*/
for (let i = 0; i < commentButton.length; i++) {
    commentButton[i].addEventListener("click", function () {
        //switching on each click
        if (commentsList[i].style.display == "none") {
            commentsList[i].style.display = "block";
            commentInput[i].style.display = "block";
        }
        else {
            commentsList[i].style.display = "none";
            commentInput[i].style.display = "none";
        }




    });
}
submitButton.addEventListener("click", function (eventObj) {

    let comment = document.querySelector("#comment").value;

    if (!comment) {
        eventObj.preventDefault();
        errorP.innerText = "You Can't Leave This Field Empty";
    }



});

