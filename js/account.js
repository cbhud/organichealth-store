function editData(){
    console.log("editData called");
    if (!checkValidation()){
        return;
    }

    console.log("=-=proso VALIDACIJU");

    $.ajax({
        type: "POST",
        url: "account.php",
        data: {
            edit: "Yes",
            fname: document.getElementById("fname").value,
            lname: document.getElementById("lname").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            password: document.getElementById("password").value
        },
        success: function(data){
            document.getElementById("msg").innerHTML = data;
            document.getElementById("msg").style.color = "green";
        }
    });
}
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneRegex = /^\d{9}$/;
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

function validateFirstName() {
    const val = document.getElementById("fname").value.trim();
    const span = document.getElementById("fnameErr");
    if (val.length < 2) {
        span.textContent = "Ime mora imati najmanje 2 karaktera.";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}

function validateLastName() {
    const val = document.getElementById("lname").value.trim();
    const span = document.getElementById("lnameErr");
    if (val.length < 2) {
        span.textContent = "Prezime mora imati najmanje 2 karaktera.";
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
    if (val.length < 1) {
        return true;
    }
    const span = document.getElementById("passErr");
    if (val.length > 0 && val.length < 8) {
        span.textContent = "Lozinka mora imati najmanje 8 karaktera";
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
    let validFName = validateFirstName();
    let validLName = validateLastName();
    let validEmail = validateEmail();
    let validPhone = validatePhone();
    let validPassword = validatePassword();

    let isValid = validFName && validLName && validEmail && validPhone && validPassword;

    document.getElementById('update').disabled = !isValid;

    return isValid;
}
