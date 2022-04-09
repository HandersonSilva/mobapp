// @ts-nocheck
$(document).ready(function() {
    aplicarMask();
});

function aplicarMask() {
    // VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
    // @ts-ignore
    VMasker(document.querySelector("#telefone")).maskPattern("(99) 99999-9999");
}

function sendMenssageSite() {
    let nome = $("#nome").val();
    let telefone = $("#telefone").val();
    let email = $("#email").val();
    let emailMensage = $("#mensagem").val();

    var er = new RegExp(
        /^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/
    );

    if (
        nome == "" ||
        telefone == "" ||
        (email == "" || !er.test(email)) ||
        emailMensage == ""
    ) {
        alertSite(
            "Dados inválidos",
            "Por favor preencha todos os dados",
            "error",
            "OK"
        );
        return false;
    }
    let mensagem = "Mensagem enviada com sucesso";
    axios
        .post("/index.php/site_mensagem", {
            nome: nome,
            telefone: telefone,
            email: email,
            mensagem: emailMensage
        })
        .then(function(response) {
            if (response.status == 200) {
                title = "Sucesso";
                alertSite(title, mensagem, "success", "OK");
                $("#nome").val("");
                $("#telefone").val("");
                $("#email").val("");
                $("#mensagem").val("");
            }
        })
        .catch(function(error) {});
}

function alertSite(title, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
        allowOutsideClick: true
    }).then(result => {});
}

function alertSite(title, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
        allowOutsideClick: true
    }).then(result => {});
}
