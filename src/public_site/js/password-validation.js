const pwDiv1 = document.getElementById("pw1");

pwDiv1.addEventListener('blur', validatePassword);

function validatePassword()
{
    const lengthValidation = document.getElementById("pw-length-validation");
    const pwValidation = document.getElementById("pw-validation");

    const pw1 = document.getElementById("pw1").value;
    const pw2 = document.getElementById("pw2").value;

    const submitBtn = document.getElementById("create-btn");

    if (pw1 != pw2) {
        submitBtn.disabled = true;
        pwValidation.innerText = "Passwords don't match";
    }
    if (pw1.length < 8) {
        submitBtn.disabled = true;
        lengthValidation.style.color = "#E00000";
    } else {
        lengthValidation.style.color = "#FFF";
    }
    if (pw1 == pw2) {
        submitBtn.disabled = false;
        pwValidation.innerText = "";
    }
}