function togglePasswordVisibility() {
    var senhaInput = document.getElementById("senha");
    var senhaToggle = document.getElementById("toggleSenha");

    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        senhaToggle.innerText = "🤔";
    } else {
        senhaInput.type = "password";
        senhaToggle.innerText = "🤫";
    }
}