
//client validations

let createForm = document.querySelector("#create-form");

let tripTitleInput = document.querySelector("#tripname");
let tripDescInput = document.querySelector("#tripdescription");
let tripTitleError = document.querySelector("#tripname-error");
let tripDescError = document.querySelector("#tripdesc-error");

let tripLocationInput = document.querySelector("#triplocation");
let tripPriceInput = document.querySelector("#tripprice");
let tripLocationError = document.querySelector("#triplocation-error");
let tripPriceError = document.querySelector("#tripprice-error");

createForm.addEventListener('submit', function (eventObj) {

    let tripTitle = tripTitleInput.value;
    let tripDesc = tripDescInput.value;
    let tripLocation = tripLocationInput.value;
    let tripPrice = tripPriceInput.value;

    if (tripTitle.length < 4) {
        eventObj.preventDefault();
        tripTitleError.innerText = "Trip Title Length Has To Be Atleast 4 Characters";
    }
    if (tripDesc.length < 15) {
        eventObj.preventDefault();
        tripDescError.innerText = "Trip Description Length Has To Be Atleast 15 Characters";
    }

    if (!tripPrice) {
        eventObj.preventDefault();
        tripPriceError.innerText = "The Trip Price Field Cannot Be Empty!"
    }
    if (!tripLocation) {
        eventObj.preventDefault();
        tripLocationError.innerText = "The Trip Location Field Cannot Be Empty!"
    }



});

tripTitleInput.addEventListener("input", function () {

    let tripTitle = tripTitleInput.value;

    if (tripTitle.length >= 4) {
        tripTitleError.innerText = "";
    }

});

tripDescInput.addEventListener("input", function () {
    let tripDesc = tripDescInput.value;
    if (tripDesc.length >= 15) {
        tripDescError.innerText = "";
    }
});

tripPriceInput.addEventListener("input", function () {
    let tripPrice = tripPriceInput.value;

    if (tripPrice.length > 0) {
        tripPriceError.innerText = "";
    }

});

tripLocationInput.addEventListener("input", function () {
    let tripLocation = tripLocationInput.value;
    if (tripLocation.length > 0) {
        tripLocationError.innerText = "";
    }
});


let doneButton = document.querySelector("#done-button");
doneButton.addEventListener("click", function () {
    let groupID = document.querySelector("#group-id-p").innerText;
    window.location.href = "groupprofile.php?groupid=" + groupID;
});