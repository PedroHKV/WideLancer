const denuncia = document.getElementById("denuncia_");
const motivo = document.getElementById("motivo");
const reqStatus = document.getElementById("reqStatus");
const statusdenun = document.getElementById("status");

function render_portif( id ){
    const http = URL_SITE+"/Templates/perfil.php?id="+id;
    window.location.href = http;
}

function init_negocio(id, usuario_id){
    let dados = new FormData();
    dados.append("solicitante" , id);
    dados.append("anunciante", usuario_id);
    fetch(URL_SITE+"/ServerScripts/iniciar_negocio.php", {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(res => {
        const http = URL_SITE+"/Templates/chat.php";
        window.location.href=http;

    }).catch(e => {
        console.log(e);
    })
}

function denunciar(){
    motivo.value = "";
    denuncia.classList.add("show");
    denuncia.classList.remove("hid");
}

function cancelar(){
    denuncia.classList.add("hid");
    denuncia.classList.remove("show");
}

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

function enviar_denuncia(id){
    let motivacao = motivo.value;
    let dados = new FormData();
    dados.append("motivo", motivacao);
    dados.append("id", id);
    fetch(URL_SITE+"/ServerScripts/tratar_denuncia.php", {
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
