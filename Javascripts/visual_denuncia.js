const btnIgnorar = document.getElementById('ign');
const btnExcluirAnuncio = document.getElementById('esc');
const btnBanirAnunciante = document.getElementById('ban_anun');
const statusbar = document.getElementById("status");
const url = URL_SITE+"/ServerScripts/visual_denuncia.php";

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

btnIgnorar.onclick = () => {
    let dados = new FormData();
    dados.append("cmd", "ignorar");
    fetch(url, {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(r => {
        if (r === "sucesso"){
            statusbar.innerHTML = "Alterações feitas com sucesso.";
            reqStatus.style.transform = "translateY(115px)";
        } else {
            statusbar.innerHTML = "Falha ao realizar ação.";
            reqStatus.style.transform = "translateY(115px)";
            console.log(r);
        }
    }).catch(err => {
        console.log(err);
        statusbar.innerHTML = "Falha ao realizar ação.";
        reqStatus.style.transform = "translateY(115px)";
        console.log(r);
    });;
};

btnExcluirAnuncio.onclick = () => {
    let dados = new FormData();
    dados.append("cmd", "esc_anun");
    fetch(url, {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(r => {
        if (r === "sucesso"){
            statusbar.innerHTML = "Anúncio excluido com sucesso.";
            reqStatus.style.transform = "translateY(115px)";
        } else {
            statusbar.innerHTML = "Falha ao realizar ação.";
            reqStatus.style.transform = "translateY(115px)";
            console.log(r);
        }
    }).catch(err => {
        console.log(err);
        statusbar.innerHTML = "Falha ao realizar ação.";
        reqStatus.style.transform = "translateY(115px)";
        console.log(r);
    });;
}

btnBanirAnunciante.onclick = () => {
    let dados = new FormData();
    dados.append("cmd", "esc_vend");
    fetch(url, {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(r => {
        if (r === "sucesso"){
            statusbar.innerHTML = "Usuário banido com sucesso.";
            reqStatus.style.transform = "translateY(115px)";
        } else {
            statusbar.innerHTML = "Falha ao realizar ação.";
            reqStatus.style.transform = "translateY(115px)";
            console.log(r);
        }
    }).catch(err => {
            console.log(err);
            statusbar.innerHTML = "Falha ao realizar ação.";
            reqStatus.style.transform = "translateY(115px)";
            console.log(r);
    });
}

