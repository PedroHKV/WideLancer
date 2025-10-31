const denuncia = document.getElementById("denuncia_");
const motivo = document.getElementById("motivo");
const reqStatus = document.getElementById("reqStatus");
const statusdenun = document.getElementById("status");
const email = document.getElementById("email");

function render_portif(){
    const emailValor = email.innerHTML;
    const http = URL_SITE+"/portifolio?email="+emailValor;
    window.location.href = http;
}

function init_negocio(){
    const idAnuncio = window.location.href.split("?id=")[1];
    let dados = new FormData();
    dados.append("idAnuncio", idAnuncio);
    fetch(URL_SITE+"/anuncio/defChat", {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(res => {
        if (res === "sucesso"){
            const http = URL_SITE+"/chat";
            window.location.href=http;
        }
    }).catch(e => {
        console.log(e);
    })
}

function denunciar(){
    motivo.value = "";
    denuncia.classList.remove("hid");
    denuncia.classList.add("show");
}

function cancelar(){
    denuncia.classList.remove("show");
    denuncia.classList.add("hid");
}

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

function enviar_denuncia(){
    let motivacao = motivo.value;
    let dados = new FormData();
    let urlAtual = window.location.href;
    let id = urlAtual.split("?id=")[1];
    dados.append("motivo", motivacao);
    dados.append("id", id);
    fetch(URL_SITE+"/anuncio/denuncia", {
        method : "POST",
        body : dados
    }).then( r => {return r.text()}).then( res => {
        if (res === "cadastrado"){
            cancelar();
            statusdenun.innerHTML = "Denúncia feita com sucesso";
            reqStatus.style.transform = "translateY(115px)";
        } else {
            statusdenun.innerHTML = "falha ao registrar denuncia";
            reqStatus.style.transform = "translateY(115px)";
        }
    }).catch(err => {
        console.log(err);
    });
}