let doneButton = document.querySelector("#done-button");
let groupIDP = document.querySelector("#group-id-paragraph");
console.log(groupIDP);
let groupID = groupIDP.innerText;


doneButton.addEventListener("click", function () {
    window.location.href = "groupprofile.php?groupid=" + groupID;
});

//client validations
let editForm = document.querySelector("#edit-form");

let groupNameField = editForm.elements.groupname;
let groupDescField = editForm.elements.desc;
let groupNameError = document.querySelector("#groupname-error");
let descriptionError = document.querySelector("#description-error");

editForm.addEventListener('submit', function (eventObj) {

    let newGroupName = groupNameField.value;
    let newDescription = groupDescField.value;

    //check group name
    if (newGroupName.length < 4) {

        eventObj.preventDefault();
        groupNameError.innerText = "Group Name Length Has To Be Atleast 4 Characters";
    }

    //check description
    if (newDescription.length < 15) {
        eventObj.preventDefault();
        descriptionError.innerText = "Description Length Has To Be Atleast 15 Characters";
    }

});



groupNameField.addEventListener("input", function () {

    let newGroupName = groupNameField.value;
    if (newGroupName.length >= 4) { groupNameError.innerText = ""; }

});

groupDescField.addEventListener("input", function () {

    let newDescription = groupDescField.value;
    if (newDescription.length >= 15) { descriptionError.innerText = ""; }

});