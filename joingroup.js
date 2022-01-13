//DO THIS IF THERE IS A JOIN BUTTON TO JOIN THE GROUP(OTHERWISE YOU WILL GET ERROR FOR UNDEFINED VARIABLES)
if (document.querySelector("#join-button")) {
    let joinButton = document.querySelector("#join-button");
    let idUser = document.querySelector("#user-id").innerText;
    let idGroup = document.querySelector("#group-id").innerText;


    joinButton.addEventListener("click", async function () {
        try {
            // SEND A REQUEST TO JOIN THE USER AS A MEMBER TO THE GROUP

            let response = await axios.post("http://localhost/webproject/joingroup.php",
                {
                    userID: idUser,
                    groupID: idGroup

                });
            if (response.data.success) {
                //
                /*WE REFRECH THE PAGE INSTEAD OF CHANGING THE DIV DISPLAY TO BLOCK BECAUSE WE NEED TO MAKE A QUERY
                ON THE PHP PAGE FIRST TO CHECK IF THE USER IS A MEMBER OR NOT (FOR THE USERS WHO ALREADY CLICKED JOIN WHEN THEY VISIT THE GROUP AGAIN)*/

                //refrech the page to show the joined button and show the success div
                window.location.href = "groupprofile.php?groupid=" + idGroup + "&success=" + true;

            }
            else {
                //show the error div
                let errorDiv = document.querySelector("#join-error");
                errorDiv.style.display = "block";
                let errorWord = document.querySelector("#error-word");
                errorWord.innerText = "You Couldn\'t Join This Group";


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