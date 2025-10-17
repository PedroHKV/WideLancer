const btnIgnorar = document.getElementById('ign');
const btnExcluirAnuncio = document.getElementById('esc');
const btnBanirAnunciante = document.getElementById('ban_anun');
const statusbar = document.getElementById("status");
const url = URL_SITE+"/ServerScripts/visual_denuncia.php";
const btnVisualAnunc = document.getElementsByClassName("visual_anunc")[0];

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

btnVisualAnunc.onclick = () => {
    const anuncioId = btnBanirAnunciante.id;
    window.location.href = URL_SITE+"/pesquisa/anuncio?id="+anuncioId;
}

btnIgnorar.onclick = () => {
    fetch(URL_SITE+"/curadoria/ignorarDenuncia", {
        method : "GET",
    }).then(r => { return r.text()}).then(r => {
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
};

btnExcluirAnuncio.onclick = () => {
    fetch(URL_SITE+"/curadoria/excluirAnuncio", {
        method : "GET",
    }).then(r => { return r.text()}).then(r => {
        if (r === "sucesso"){
            statusbar.innerHTML = "Anuncio excluido com sucesso";
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

btnBanirAnunciante.onclick = () => {
    fetch(URL_SITE+"/curadoria/banirVendedor", {
        method : "GET",
    }).then(r => { return r.text()}).then(r => {
        if (r === "sucesso"){
            statusbar.innerHTML = "Usuario banido com sucesso";
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
    });
}

