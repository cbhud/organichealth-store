function validateEmail() {
    const email = document.getElementById("email").value.trim();
    const emailSpan = document.getElementById("mailErr");
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        emailSpan.textContent = "Unesite ispravan email";
        emailSpan.style.color = "red";
        return false;
    }
    emailSpan.textContent = "";
    return true;
}

function validatePassword() {
    const password = document.getElementById("password").value;
    const passSpan = document.getElementById("passErr");
    if (password.length === 0) {
        passSpan.textContent = "Lozinka ne smije biti prana!";
        passSpan.style.color = "red";
        return false;
    }
    passSpan.textContent = "";
    return true;
}

function checkLoginValidation() {
    const validEmail = validateEmail();
    const validPassword = validatePassword();
    document.getElementById('loginBtn').disabled = !(validEmail && validPassword);
}