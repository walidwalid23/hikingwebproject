let groupID = document.querySelector("#group-id").innerText;
function goToEditForm() {
    window.location.href = "editgroup.php?groupid=" + groupID;
}
