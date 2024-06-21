function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var email = document.getElementById("email").value;
    var confirmEmail = document.getElementById("confirmEmail").value;

    if (password !== confirmPassword) {
        alert("As senhas não coincidem.");
        document.getElementById("password").style.backgroundColor = "#ff9999";
        document.getElementById("confirmPassword").style.backgroundColor = "#ff9999";
        return false;
    }

    if (email !== confirmEmail) {
        alert("Os emails não coincidem.");
        document.getElementById("email").style.backgroundColor = "#ff9999";
        document.getElementById("confirmEmail").style.backgroundColor = "#ff9999";
        return false;
    }

    return true;
}
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
