const btnAceitar = document.getElementById('aceit');
const btnRecusar = document.getElementById('rec');
const statusbar = document.getElementById("status");
const reqStatus = document.getElementById("reqStatus");

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

function aceitar(usuarioid){
    const url = URL_SITE+"/ServerScripts/visual_solic.php";
    let dados = new FormData();
    dados.append("cmd", "aceitar");
    dados.append("usuario_id", usuarioid);
        fetch(url, {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(r => {
        console.log(r);
        if (r === "sucesso"){
            statusbar.innerHTML = "Alterações feitas com sucesso";
            reqStatus.style.transform = "translateY(115px)";
        } else {
            statusbar.innerHTML = "Falha o realizar ação";
            reqStatus.style.transform = "translateY(115px)";
            console.log(r);
        }
    }).catch(err => {
        console.log(err);
        statusbar.innerHTML = "Falha o realizar ação";
        reqStatus.style.transform = "translateY(115px)";
        console.log(r);
    });;
}

function recusar(usuarioid){
    const url = URL_SITE + "/ServerScripts/visual_solic.php";
    let dados = new FormData();
    dados.append("cmd", "recusar");
    dados.append("usuario_id", usuarioid);
        fetch(url, {
        method: "POST",
        body: dados
    }).then(r => { return r.text()}).then(r => {
        console.log(r);
        if (r === "sucesso") {
            statusbar.innerHTML = "Solicitação recusada com sucesso";
            reqStatus.style.transform = "translateY(115px)";
            desativarBotoes();
        } else {
            statusbar.innerHTML = "Falha ao realizar ação";
            reqStatus.style.transform = "translateY(115px)";
        }
    }).catch(err => {
        console.log(err);
        statusbar.innerHTML = "Falha ao realizar ação";
        reqStatus.style.transform = "translateY(115px)";
    });
}

window.recusar = recusar;

function desativarBotoes() {
    btnAceitar.disabled = true;
    btnRecusar.disabled = true;
}