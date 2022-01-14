//DO THIS IF THERE IS A DELETE BUTTON TO DELETE THE GROUP(OTHERWISE YOU WILL GET ERROR FOR UNDEFINED VARIABLES)
if (document.querySelector("#delete-button")) {
    let joinButton = document.querySelector("#delete-button");
    let idGroup = document.querySelector("#group-id").innerText;


    joinButton.addEventListener("click", async function () {
        try {
            // SEND A REQUEST TO DELETE THE GROUP
            let response = await axios.post("http://localhost/webproject/deletegroup.php",
                {
                    groupID: idGroup

                });
            if (response.data.success) {
                //

                //redirect to the home page and show the success div
                window.location.href = "home.php?success=group deleted successfully";

            }
            else {
                //show the error div
                let errorDiv = document.querySelector("#error-div");
                errorDiv.style.display = "block";
                let errorWord = document.querySelector("#error-word");
                errorWord.innerText = "You Couldn\'t Delete This Group";


            }
        }
        catch (error) {
            let errorDiv = document.querySelector("#error-div");
            errorDiv.style.display = "block";
            let errorWord = document.querySelector("#error-word");
            errorWord.innerText = error;

        }

    });
}