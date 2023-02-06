class Chat
{
    #CHAT_ID = "messages";

    constructor(messagesData)
    {
        this.messagesData = messagesData;
    }

    updateChat()
    {
        if (this.messagesData == "already saved") {
            return;
        }

        this.#clearChat();
        const messageObj = new Message();
        const chatElement = document.getElementById(this.#CHAT_ID);

        let datesOfMessages = [];
        let i = 0;
        this.messagesData.forEach(message => {
            messageObj.message = message.message;
            messageObj.userImage = message.userImage;
            messageObj.media = message.media;
            messageObj.timeOfMessage = message.timeOfMessage.substring(0, 5);
            messageObj.sentByUser = message.sentByUser;

            const messageDateObj = new Date(message.dateOfMessage);
            let day = messageDateObj.getDate();
            let month = messageDateObj.getMonth() + 1;
            if (month < 10) {
                month = "0" + month;
            }
            if (day < 10) {
                day = "0" + day;
            }
            const year = messageDateObj.getFullYear();
            const messageDate = day + "." + month + "." + year;

            if (!datesOfMessages.includes(messageDate)) {
                messageObj.dateOfMessage = messageDate;

                const messageDateElement = messageObj.createDateElement();
                chatElement.appendChild(messageDateElement);

                datesOfMessages.push(messageDate);
            }

            const messageElement = messageObj.createMessageElement();
            chatElement.appendChild(messageElement);

            if (i == this.messagesData.length - 1) {
                messageElement.scrollIntoView();
            }
            i++;
        });
    }

    #clearChat()
    {
        removeChilds(document.getElementById(this.#CHAT_ID));
    }
}