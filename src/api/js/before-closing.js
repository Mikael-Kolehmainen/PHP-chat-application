window.addEventListener('visibilitychange', function()
{
    removeUserData();
});
window.addEventListener('beforeunload', function()
{
    removeUserData();
});

function removeUserData()
{
    const removeData = new Data("/index.php/ajax/remove-messages-session");
    removeData.sendToPhpAsJSON(function() {

    });
}