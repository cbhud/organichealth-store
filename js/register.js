
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneRegex = /^\d{9}$/;
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

function validateName() {
    const val = document.getElementById("name").value.trim();
    const span = document.getElementById("nameErr");
    if (val.length < 3) {
        span.textContent = "Ime i prezime moraju imati najmanje 3 karaktera.";
        span.style.color = "red";
        return false;
    }
    if (!val.includes(' ')) {
        span.textContent = "Unesite i ime i prezime (razdvojeno razmakom).";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}
function validateEmail() {
    const val = document.getElementById("email").value.trim();
    const span = document.getElementById("mailErr");
    if (!emailRegex.test(val)) {
        span.textContent = "Unesite ispravan email.";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}
function validatePhone() {
    const val = document.getElementById("phone").value.trim();
    const span = document.getElementById("phoneErr");
    if (!phoneRegex.test(val)) {
        span.textContent = "Telefon mora imati tačno 9 cifara.";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}
function validatePassword() {
    const val = document.getElementById("password").value;
    const span = document.getElementById("passErr");
    if (val.length < 8) {
        span.textContent = "Lozinka mora imati najmanje 8 karaktera.JS";
        span.style.color = "red";
        return false;
    }
    if (!passwordRegex.test(val)) {
        span.textContent = "Lozinka mora sadržati slova i brojeve.";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}

function checkValidation(){
    let validName = validateName();
    if (!validName){
        document.getElementById('register').disabled = true;
        return;
    }
    let validEmail = validateEmail();
    if (!validEmail){
        document.getElementById('register').disabled = true;
        return;
    }
    let validPhone = validatePhone();
    if (!validPhone){
        document.getElementById('register').disabled = true;
        return;
    }
    let validPassword = validatePassword();
    if (!validPassword){
        document.getElementById('register').disabled = true;
        return;
    }
    if (validName && validEmail && validPhone && validPassword) {
        document.getElementById('register').disabled = false;
    } else {
        document.getElementById('register').disabled = true;
    }
}
