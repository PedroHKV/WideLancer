const caixa = document.getElementById("caixa");
const solics = document.getElementById("solics");
const forns = document.getElementById("forns");
const curadores = document.getElementById("curadores");
const denuncias = document.getElementById("denuncias");
const clientes = document.getElementById("clientes");

const botoes = [solics, forns, curadores, denuncias, clientes];

//gera o relatorio dos curadores do site
curadores.onclick = () => {
    status_carregando();
    let dados = new FormData();
    dados.append("solicitacao", "curadores");
    fetch(URL_SITE+"/ServerScripts/reqs_curadoria.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Curadores</h3><br>";
        r.forEach(curador => {
            caixa.innerHTML += "<div class='info' onClick = 'redirect("+curador.id+")' >"+
                                  "<p>"+curador.nome +" "+curador.sobrenome+"</p>"+
                                  "<p class='status'>Curador</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio dos fornecedores do site
forns.onclick = () => {
    status_carregando();
    let dados = new FormData();
    dados.append("solicitacao", "fornecedores");
    fetch(URL_SITE+"/ServerScripts/reqs_curadoria.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Fornecedores</h3><br>";
        r.forEach(Fornecedor => {
            caixa.innerHTML += "<div class='info' onClick = 'redirect("+Fornecedor.id+")' >"+
                                  "<p>"+Fornecedor.nome +" "+Fornecedor.sobrenome+"</p>"+
                                  "<p class='status'>Fornecedor</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio dos clientes do site
clientes.onclick = () => {
    status_carregando();
    let dados = new FormData();
    dados.append("solicitacao", "clientes");
    fetch(URL_SITE+"/ServerScripts/reqs_curadoria.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Clientes</h3><br>";
        r.forEach(Cliente => {
            caixa.innerHTML += "<div class='info' onClick = 'redirect("+Cliente.id+")' >"+
                                  "<p>"+Cliente.nome +" "+Cliente.sobrenome+"</p>"+
                                  "<p class='status'>Cliente</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio das denúncias
denuncias.onclick = () => {
    status_carregando();
    let dados = new FormData();
    dados.append("solicitacao", "denuncias")
    fetch(URL_SITE+"/ServerScripts/reqs_curadoria.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.json()}).then( r => { 
        caixa.innerHTML = "<h3>Denúncias</h3><br>";
        r.forEach(denuncia => {
            caixa.innerHTML += "<div class='info' id='"+denuncia.anuncio_id+"' onClick = 'render_pagina_denun("+denuncia.id+")' >"+
                                  "<p>"+denuncia.delator+" fez uma denuncia sobre um anúncio de "+denuncia.acusado+"</p>"+
                                  "<p class='status'>"+(denuncia.pendente ? "pendente" : "esta denuncia já foi avaliada" )+"</p>"+
                               "</div>";
        });
    });
}

function status_carregando(){
    caixa.innerHTML = "<div class='loading-screen'>"+
                        "<div class='spinner'></div>"+
                        "<p>Carregando...</p>"+
                       "</div>";
}

function redirect( id ){
    window.location.href = URL_SITE+"/Templates/perfil.php?id="+id;
}

function render_pagina_denun(id){
    let dados = new FormData();
    dados.append("cmd", "denuncia");
    dados.append("denuncia_id", id);
    fetch(URL_SITE+"/ServerScripts/curadoria.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then( r => {
        if (r === "sucesso"){
            window.location.href = URL_SITE+"/Templates/visual_denuncia.php";
        } else {
            console.log(r);
        }
    });
}