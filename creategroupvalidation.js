
//client validations

let createForm = document.querySelector("#create-form");
let groupNameInput = document.querySelector("#groupname");
let groupDescInput = document.querySelector("#groupdescription");
let groupnameError = document.querySelector("#groupname-error");
let groupDescError = document.querySelector("#groupdesc-error");

createForm.addEventListener('submit', function (eventObj) {

    let groupName = groupNameInput.value;
    let groupDesc = groupDescInput.value;

    if (groupName.length < 4) {
        eventObj.preventDefault();
        groupnameError.innerText = "Group Name Length Has To Be Atleast 4 Characters";
    }
    if (groupDesc.length < 15) {
        eventObj.preventDefault();
        groupDescError.innerText = "Group Description Length Has To Be Atleast 15 Characters";
    }



});

groupNameInput.addEventListener("input", function () {
    let groupName = groupNameInput.value;

    if (groupName.length >= 4) {
        groupnameError.innerText = "";
    }

});

groupDescInput.addEventListener("input", function () {
    let groupDesc = groupDescInput.value;
    if (groupDesc.length >= 15) {
        groupDescError.innerText = "";
    }
});
let doneButton = document.querySelector("#done-button");
doneButton.addEventListener("click", function () {
    let groupID = document.querySelector("#group-id-p").innerText;
    window.location.href = "groupprofile.php?groupid=" + groupID;
});