window.addEventListener('visibilitychange', removeUserData);
window.addEventListener('beforeunload', removeUserData);

function removeUserData()
{
    const removeData = new Data("/index.php/ajax/remove-messages-session");
    removeData.sendToPhpAsJSON(function() {

    });
}