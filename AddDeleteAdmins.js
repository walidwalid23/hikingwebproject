let currentGroupID = document.querySelector("#group-id").innerText;

function goToAddDeleteAdminsPage() {

    window.location.href = "AddDeleteAdmins.php?groupid=" + currentGroupID;

}