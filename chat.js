let sendMessageButton = document.querySelector("#chat-input-send-button");
let chatID = document.querySelector("#chat-id").innerText;
let receiverID = document.querySelector("#receiver-id").innerText;
let senderID = document.querySelector("#sender-id").innerText;
let senderType = document.querySelector("#sender-type").innerText;
let receiverType = document.querySelector("#receiver-type").innerText;
let messageInput = document.querySelector("#message-input");
let errorP = document.querySelector("#error-p");


sendMessageButton.addEventListener("click", async function () {
    try {
        let message = messageInput.value;
        let currentDateObject = new Date();
        let currentHours = currentDateObject.getHours().toString();
        let currentMinutes = currentDateObject.getMinutes().toString();
        let currentSeconds = currentDateObject.getSeconds().toString();
        let currentDate = currentHours + ":" + currentMinutes + ":" + currentSeconds;
        if (!message) {
            errorP.innerText = "You Can't Leave The Message Field Empty";
        }
        else {
            //SEND A REQUEST TO THE SERVER USING AJAX
            let request = await axios.post("http://localhost/webproject/addmessage.php",

                {
                    chatID: chatID,
                    message: message,
                    currentDate: currentDate,
                    seenReceiver: false,
                    receiverID: receiverID,
                    senderID: senderID,
                    senderType: senderType,
                    receiverType: receiverType




                }
            );
            console.log(request);
            if (request.data.success) {
                //refrech the page to show the inserted message

                window.location.href = "chat.php?receiverid=" + receiverID;
            }

            else {

                errorP.innerText = request.data.error;

            }
        }
    }
    catch (error) {
        errorP.innerText = error;
    }
}


)

/////////////MAKING THE CHAT REAL TIME BY LISTENING TO DATABASE CHANGES////////////////
let currentHikerID = senderID;
let currentMessagesCount = document.querySelector("#messages-count").innerText;


async function checkNewMessage() {
    try {
        console.log("listening");
        let response = await axios.get("chatlistener.php?hikerid=" + currentHikerID);

        if (response.data.newMessagesCount) {
            if (response.data.newMessagesCount > currentMessagesCount) {
                //reload the page if the user received a new message
                location.reload();
            }
        }

        else if (response.data.error) {
            document.write(response.data.error);
        }
    }

    catch (error) {
        document.write(error);
    }
}

function listenToMessages() {
    window.requestAnimationFrame(listenToMessages);
    checkNewMessage();
}
listenToMessages();