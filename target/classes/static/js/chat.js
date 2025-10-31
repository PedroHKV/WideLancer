const mensagens = document.getElementById('mensagens');
const input = document.querySelector('.chat-input input');
const chatMain = document.querySelector('.chat-main');
const sendBtn = document.querySelector('.enviar-mensagem');
const propostaBtn = document.querySelector('.proposta-btn');
const propostaCard1 = document.querySelector('#proposta-form');
const propostaCard2 = document.querySelector('#proposta-recebida');
const prazoInput = document.querySelector('.prazo-trabalho');
const orcamentoInput = document.querySelector('.input-orcamento');
const statusTexto = document.querySelector('.status-texto');
const chatInputWrapper = document.querySelector('.chat-input');
const statusIndicador = document.querySelector('.status-indicador');
const proposta_btn = document.querySelector('.enviar-proposta');
const statusbar = document.getElementById("status");
const outrosChatsBtns = Array.from(document.getElementsByClassName("chat-item"));
const aceitarBtn = document.getElementsByClassName("aceitar")[0];
const recusarBtn = document.getElementsByClassName("recusar")[0];
const produtoBtn = document.getElementsByClassName("produto-btn")[0];

function scrollToBottom() {
    chatMain.scrollTop = chatMain.scrollHeight;
}

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}

function entregar_produto(){
    const file_input = document.createElement("input");
    file_input.type = "file";
    file_input.style.display = "none";
    file_input.click();
    file_input.onchange = () => {
        const file = file_input.files[0];
        const nome = file.name;
        const extensao = nome.split('.').pop().toLowerCase();
        if ( extensao === "zip" ){
            const dados = new FormData();
            dados.append("produto", file );
            fetch(URL_SITE+"/chat/entregarProduto", {
                method : "POST",
                body : dados
            }).then(r => {return r.text()}).then( r => {
                if (r === "sucesso"){
                    window.location.href = URL_SITE+"/chat";
                } else {
                    console.log(r);
                }
            });
        } else {
            statusbar.innerHTML = "o produto deve estar zipado para o envio";
            reqStatus.style.transform = "translateY(115px)";
        }
        
    } 
}

function enviar_decisao(decisao, id){
    let dados = new FormData();
    dados.append("decisao", decisao);
    dados.append("proposta_id", id);
    fetch(URL_SITE+"/chat/tratarProposta", {
        method:"POST", 
        body: dados 
    }).then(r=>{return r.text()}).then(res=>{
        console.log(res);
        if (res === "sucesso"){
            window.location.href = URL_SITE+"/chat";
        } else { 
            console.log(res);
        }
    });
}

//redireciona para a pagina de pagamento
function render_pagamento( id ){
    let dados = new FormData();
    dados.append("cmd", "coleta");
    dados.append("produto_id", id);

    fetch(URL_SITE+"/ServerScripts/tratar_produto.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then(r => {
        console.log(r);
        if (r === "sucesso"){
            window.location.href = URL_SITE+"/Templates/pagamento.php";
        }
    }).catch(e => {
        console.log(e);
    });
}

//envia a mensagem como uma mensagem comum
sendBtn.addEventListener('click', () => {
    const msgContent = input.value.trim();
    if (msgContent !== '') {
        
        input.value = '';

        let dados = new FormData();
        dados.append("msg_cnt",msgContent);
        fetch(URL_SITE+"/chat/cadasMensagem", {
            method:"POST", 
            body: dados 
        }).then(r=>{return r.text()}).then(res=>{
            if (res === "sucesso"){
                window.location.href = URL_SITE+"/chat";
            }
            console.log(res);
        });
        scrollToBottom();
    }
});

outrosChatsBtns.forEach(chat => {
    chat.onclick = () => {
        const idOutroUsuario = chat.id;
        let dados = new FormData();
        dados.append("idOutro", idOutroUsuario);
        fetch(URL_SITE+"/chat/defChat", {
            method : "POST",
            body : dados
        }).then( r => {return r.text()}).then( r => {
            if (r === "sucesso"){
                window.location.href = URL_SITE+"/chat";
            }
        } )
    }
});

if (propostaBtn){
    //cria a caixa de dialogo para enviar proposta
    propostaBtn.addEventListener('click', () => {
        propostaCard1.style.display = (propostaCard1.style.display === 'none' || propostaCard1.style.display === '') ? 'flex' : 'none';
    });

    //envia a proposta
    document.querySelector('.enviar-proposta').addEventListener('click', () => {
        const prazo = prazoInput.value;
        const orcamento = orcamentoInput.value;
        if (prazo && orcamento) {

            let dados = new FormData();
            dados.append("prazo", prazo);
            dados.append("orcamento", orcamento);
            fetch(URL_SITE+"/chat/cadasProposta", {
                method:"POST", 
                body: dados 
            }).then(r=>{return r.text()}).then(res=>{
                console.log(res);
                if (res === "sucesso"){
                    window.location.href = URL_SITE+"/chat";
                } else { 
                    alert("Falha ao enviar mensagem.");
                }
            });

        } else {
            alert("Por favor, insira um prazo e um orçamento.");
        }
    });
}
if (recusarBtn && aceitarBtn){
    aceitarBtn.onclick = () => {
        enviar_decisao("aceita", aceitarBtn.id);
    }

    recusarBtn.onclick = () => {
        enviar_decisao("recusada", aceitarBtn.id);
    }
}
if (produtoBtn){
    produtoBtn.onclick = () => {
        entregar_produto();
    }
}
scrollToBottom();

