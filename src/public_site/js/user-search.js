const searchField = document.getElementById("user-search");

searchField.addEventListener("keyup", (event) => {
    updateUserList();
});

function updateUserList()
{
    let input, filter, ul, li, a, txtValue;
    input = document.getElementById("user-search");
    filter = input.value.toUpperCase();
    ul = document.getElementById("user-list");
    li = ul.getElementsByTagName("li");

    for (let i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("p")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
}