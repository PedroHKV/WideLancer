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
    fetch(URL_SITE+"/curadoria/curadores", {
        method : "GET",
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Curadores</h3><br>";
        const tamanho = r.length;
        let count = 0;
        r.forEach(curador => {
            count++;
            if (count === tamanho){
                return;
            }
            caixa.innerHTML += "<div class='info' onClick = \"redirect('"+curador.email+"')\" >"+
                                  "<p>"+curador.nome +" "+curador.sobrenome+"</p>"+
                                  "<p class='status'>Curador</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio dos fornecedores do site
forns.onclick = () => {
    status_carregando();
    fetch(URL_SITE+"/curadoria/fornecedores", {
        method : "GET",
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Fornecedores</h3><br>";
        const tamanho = r.length;
        let count = 0;
        r.forEach(Fornecedor => {
            count++;
            if (count === tamanho){
                return;
            }
            caixa.innerHTML += "<div class='info' onClick = \"redirect('"+Fornecedor.email+"')\" >"+
                                  "<p>"+Fornecedor.nome +" "+Fornecedor.sobrenome+"</p>"+
                                  "<p class='status'>Fornecedor</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio dos clientes do site
clientes.onclick = () => {
    status_carregando();
    fetch(URL_SITE+"/curadoria/clientes", {
        method : "GET",
    }).then(r => {return r.json()}).then( r => {
        caixa.innerHTML = "<h3>Clientes</h3><br>";
        const tamanho = r.length;
        let count = 0;
        r.forEach(Cliente => {
            count++;
            if (count === tamanho){
                return;
            }
            caixa.innerHTML += "<div class='info' onClick = \"redirect('"+Cliente.email+"')\" >"+
                                  "<p>"+Cliente.nome +" "+Cliente.sobrenome+"</p>"+
                                  "<p class='status'>Cliente</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio das denúncias
denuncias.onclick = () => {
    status_carregando();
    fetch(URL_SITE+"/curadoria/denuncias", {
        method : "GET",
    }).then(r => {return r.json()}).then( r => { 
        caixa.innerHTML = "<h3>Denúncias</h3><br>";
        const tamanho = r.length;
        let count = 0;
        classificarDenuncias(r);
        r.forEach(denuncia => {
            count++;
            if (count === tamanho){
                return;
            }
            caixa.innerHTML += "<div class='info' id='"+denuncia.anuncio_id+"' onClick = 'render_pagina_denun("+denuncia.id+")' >"+
                                  "<p>"+denuncia.delator+" fez uma denuncia sobre um anúncio de "+denuncia.acusado+"</p>"+
                                  "<p class='status'>"+((denuncia.pendente === "pendente") ? "pendente" : "esta denuncia já foi avaliada" )+"</p>"+
                               "</div>";
        });
    });
}

//gera o relatorio das solicitações
solics.onclick = () => {
    status_carregando();
    fetch(URL_SITE+"/curadoria/solicitacoes", {
        method : "GET",
    }).then(r => {return r.json()}).then( r => { 
        caixa.innerHTML = "<h3>Solicitacoes</h3><br>";
        const tamanho = r.length;
        let count = 0;
        classificarSolicitacoes(r);
        r.forEach(solicitacao => {
            count++;
            if (count === tamanho){
                return;
            }
            caixa.innerHTML += "<div class='info' id='"+solicitacao.id+"' onClick = 'render_pagina_solic("+solicitacao.id+")' >"+
                                  "<p>"+solicitacao.solicitante_nome+" solicitou permissão para fornecer serviços online</p>"+
                                  "<p class='status'>"+solicitacao.decisao+"</p>"+
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

function redirect( email ){
    window.location.href = URL_SITE+"/portifolio?email="+email;
}

function render_pagina_denun(id){
    let dados = new FormData();
    dados.append("denuncia_id", id);
    fetch(URL_SITE+"/curadoria/defDenuncia", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then( r => {
        if (r === "sucesso"){
            window.location.href = URL_SITE+"/curadoria/denuncia";
        } else {
            console.log(r);
        }
    });
}

function render_pagina_solic(id){
    let dados = new FormData();
    dados.append("solicitacao_id", id);
    fetch(URL_SITE+"/curadoria/visual_solic", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then( r => {
        if (r === "sucesso"){
            window.location.href = URL_SITE+"/curadoria/solicitacao";
        } else {
            console.log(r);
        }
    });
}


function classificarSolicitacoes(arr){
    let alterado = true;
    while (alterado){
        alterado = false;
        for(let i = 0; i < arr.length - 2; i++){ // - 2 porque o ultimo elemento sempre é: {}
            if (arr[i].decisao !== "pendente" && arr[i + 1].decisao === "pendente"){
                const temp = arr[i];
                arr[i] = arr[i + 1];
                arr[i + 1] = temp;
                alterado = true;
            }
        }
    }
}

function classificarDenuncias(arr){
    let alterado = true;
    while (alterado){
        alterado = false;
        for(let i = 0; i < arr.length - 2; i++){ // - 2 porque o ultimo elemento sempre é: {}
            if (arr[i].pendente !== "pendente" && arr[i + 1].pendente === "pendente"){
                const temp = arr[i];
                arr[i] = arr[i + 1];
                arr[i + 1] = temp;
                alterado = true;
            }
        }
    }
}