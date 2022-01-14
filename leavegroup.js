//DO THIS IF THERE IS A LEAVE BUTTON TO LEAVE THE GROUP(OTHERWISE YOU WILL GET ERROR FOR UNDEFINED VARIABLES)
if (document.querySelector("#leave-button")) {
    let leaveButton = document.querySelector("#leave-button");
    let idUser = document.querySelector("#user-id").innerText;
    let idGroup = document.querySelector("#group-id").innerText;


    leaveButton.addEventListener("click", async function () {
        try {
            // SEND A REQUEST TO DELETE THE MEMBER FROM THE GROUP
            let response = await axios.post("http://localhost/webproject/leavegroup.php",
                {
                    userID: idUser,
                    groupID: idGroup

                });

            if (response.data.success) {

                //refrech the page to show the join group button and show the success div
                window.location.href = "groupprofile.php?groupid=" + idGroup + "&group-left=" + true;

            }
            else {
                //show the error div
                let errorDiv = document.querySelector("#leave-error");
                errorDiv.style.display = "block";
                let errorWord = document.querySelector("#error-word");
                errorWord.innerText = "You Couldn\'t Leave This Group";


            }
        }
        catch (error) {
            let errorDiv = document.querySelector("#join-error");
            errorDiv.style.display = "block";
            let errorWord = document.querySelector("#error-word");
            errorWord.innerText = error;

        }

    });
}