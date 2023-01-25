class Chat
{
    #CHAT_ID = "messages";

    constructor(messagesData)
    {
        this.messagesData = messagesData;
    }

    updateChat()
    {
        this.#clearChat();
        const messageObj = new Message();
        const chatElement = document.getElementById(this.#CHAT_ID);

        let datesOfMessages = [];
        let i = 0;
        this.messagesData.forEach(message => {
            messageObj.message = message.message;
        //    messageObj.userImage = message.userImage;
            messageObj.media = message.media;
            messageObj.timeOfMessage = message.timeOfMessage.substring(0, 5);
            messageObj.sentByUser = message.sentByUser;

            if (!datesOfMessages.includes(message.dateOfMessage)) {
                const messageDateObj = new Date(message.dateOfMessage);
                const day = messageDateObj.getDate();
                const month = messageDateObj.getMonth() + 1;
                const year = messageDateObj.getFullYear();
                const messageDate = day + "." + month + "." + year;

                message.dateOfMessage = messageDate;

                const messageDateElement = messageObj.createDateElement();
                chatElement.appendChild(messageDateElement);

                datesOfMessages.push(messageDate);
            }

            const messageElement = messageObj.createMessageElement();
            chatElement.appendChild(messageElement);

            if (i == this.messagesData.lenght - 1) {
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