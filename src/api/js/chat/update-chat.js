async function updateChat()
{
    const groupId = window.location.pathname.split('/')[4];
    const getMessages = new Data(`/index.php/ajax/get-messages/${groupId}`);

    const messagesData = JSON.parse(await getMessages.getFromPhp());

    const chat = new Chat(messagesData);
    chat.updateChat();
}

updateChat();
setInterval(updateChat, 1000);