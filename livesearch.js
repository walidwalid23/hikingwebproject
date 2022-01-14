let searchInput = document.querySelector("#search-bar");
let allSearchResults = document.querySelector("#all-search-results");



//solve the problem of repeated search results by storing the current ID of results in an array
let resultedTripsArray = [];

searchInput.addEventListener("input", async function (eventObj) {
    $current_search_value = searchInput.value;
    //only check if the value is not empty
    if ($current_search_value != "") {
        //send a get request to the server
        let responseData = await axios.get("http://localhost/webproject/livesearch.php?value=" + $current_search_value);

        //if you got results from the server display them
        if (responseData.data.results) {

            let searchResults = responseData.data.results;


            for (let i = 0; i < searchResults.length; i++) {
                //check if the resulted trip is already in the array to stop repeating it
                let tripRepeated = false;
                for (let j = 0; j < resultedTripsArray.length; j++) {
                    if (resultedTripsArray[j] == searchResults[i].postID) {
                        tripRepeated = true;
                    }

                }

                if (!tripRepeated) {
                    let triptitle = searchResults[i].title;
                    let tripid = searchResults[i].postID;
                    //create an element for each resulted trip and add it to the search list
                    let tripLink = document.createElement('a');
                    let tripTitleList = document.createElement('li');
                    //add the title in the trip title list item
                    tripTitleList.append(triptitle);
                    //add the trip title as a link under the search bar
                    tripLink.href = "livesearchtrip.php?tripid=" + tripid;
                    tripLink.style.textDecoration = 'none';
                    tripLink.append(tripTitleList);
                    //add the link of the trip to the list of search results
                    allSearchResults.append(tripLink);
                    //add the trip ID to the current showed trips array
                    resultedTripsArray.push(tripid);
                }

            }
        }
        else if (responseData.data.error) {
            document.write('<h2 style="color:red">' + responseData.data.error + "</h2>");

        }

    }

});




searchInput.addEventListener("keydown", function (eventObj) {
    //if the backArrow (delete) key is clicked remove the old results from the ul and from array
    if (eventObj.keyCode == "8") {
        //clear the ul
        allSearchResults.innerHTML = "";
        //clear the array
        resultedTripsArray = [];


    }
});


//LISTEN FOR WHEN THE SEARCH BUTTON IS CLICKED
let searchButton = document.querySelector("#search-button");

searchButton.addEventListener("click", function () {
    let searchValue = searchInput.value;

    window.location.href = "searchedtrips.php?tripname=" + searchValue;


});