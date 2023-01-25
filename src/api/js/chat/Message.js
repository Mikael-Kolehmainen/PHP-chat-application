class Message
{
    #DATE_CLASS_NAME = "date";
    #MESSAGE_CLASS_NAME = "message";
    #SENT_CLASS_NAME = "sent";
    #ROUND_IMAGE_CLASS_NAME = "round-image";

    constructor(message, media, dateOfMessage, timeOfMessage, userImage, sentByUser)
    {
        this.message = message;
        this.media = media;
        this.dateOfMessage = dateOfMessage;
        this.timeOfMessage = timeOfMessage;
        this.userImage = userImage;
        this.sentByUser = sentByUser;
    }

    /*
        <p class='date'>12.01.2023</p>
        <div class='message'>
            <div class='round-image'>
                <img src='/src/public_site/media/placeholder.png'>
            </div>
            <p>This is a longer message sent by the user. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut in leo posuere, lacinia est sit amet, cursus risus. Ut ultrices elit ac arcu sodales pretium.</p>
            <p id='time'>21:20</p>
        </div>
    */
    createDateElement()
    {
        const date = document.createElement("p");
        date.classList.add(this.#DATE_CLASS_NAME);

        date.innerText = this.dateOfMessage;

        return date;
    }

    createMessageElement()
    {
        let messageElement = document.createElement("div");
        messageElement.classList.add(this.#MESSAGE_CLASS_NAME);

        if (this.sentByUser) {
            messageElement.classList.add(this.#SENT_CLASS_NAME);
        }

        const userImageContainer = document.createElement("div");
        userImageContainer.classList.add(this.#ROUND_IMAGE_CLASS_NAME);
        messageElement.appendChild(userImageContainer);
        const userImage = document.createElement("img");
        userImage.src = this.userImage;
        userImageContainer.appendChild(userImage);

        if (this.message != null) {
            const messageText = document.createElement("p");
            messageText.innerText = this.message;
            messageElement.appendChild(messageText);
        } else if (this.media != null) {
            const messageImage = document.createElement("img");
            messageElement.appendChild(messageImage);

            messageImage.addEventListener("error", function() { messageImage.src = "/src/public_site/media/image-not-found.png" });
            messageImage.src = this.media;
        }

        const timeText = document.createElement("p");
        timeText.classList.add("time");
        messageElement.appendChild(timeText);

        timeText.innerText = this.timeOfMessage;


        return messageElement;
    }
}