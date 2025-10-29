const btnAceitar = document.getElementById('aceit');
const btnRecusar = document.getElementById('rec');
const statusbar = document.getElementById("status");

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

function aceitar(){
    const url = URL_SITE+"/curadoria/aceitar";
        fetch(url, {
        method : "GET",
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
    });
}

function recusar(){
    const url = URL_SITE+"/curadoria/recusar";
        fetch(url, {
        method : "GET",
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
    });
}

