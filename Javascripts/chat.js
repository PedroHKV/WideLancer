
const mensagens = document.getElementById('mensagens');
const input = document.querySelector('.chat-input input');
const chatMain = document.querySelector('.chat-main');
const sendBtn = document.querySelector('.enviar-mensagem');
const propostaBtn = document.querySelector('.proposta-btn');
const propostaCard1 = document.querySelector('#proposta-form');
const propostaCard2 = document.querySelector('#proposta-recebida');
const prazoInput = document.querySelector('.prazo-trabalho');
const orcamentoInput = document.querySelector('.input-orcamento');
const aceitarBtn = document.querySelector('.aceitar');
const recusarBtn = document.querySelector('.recusar');
const statusTexto = document.querySelector('.status-texto');
const chatInputWrapper = document.querySelector('.chat-input');
const statusIndicador = document.querySelector('.status-indicador');
const proposta_btn = document.querySelector('.enviar-proposta');
const statusbar = document.getElementById("status");
const display_erros = document.getElementById("statusHTTP");

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
            dados.append("cmd", "entrega");
            fetch(URL_SITE+"/ServerScripts/tratar_produto.php", {
                method : "POST",
                body : dados
            }).then(r => {return r.text()}).then( r => {
                if (r === "sucesso"){
                    window.location.href = URL_SITE+"/Templates/chat.php";
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
    dados.append("cliente", "true");
    dados.append("decisao", decisao);
    dados.append("proposta_id", id);
    fetch(URL_SITE+"/ServerScripts/tratar_proposta.php", {
        method:"POST", 
        body: dados 
    }).then(r=>{return r.text()}).then(res=>{
        console.log(res);
        if (res === "salvas"){
            window.location.href = URL_SITE+"/Templates/chat.php";
        } else {
                display_erros.innerHTML = "Falha ao realizar escolha.";
                display_erros.style.display = "block";
                statusbar.innerHTML = "Falha ao realizar ação";
                reqStatus.style.transform = "translateY(115px)";
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
        fetch(URL_SITE+"/ServerScripts/tratar_msg.php", {
            method:"POST", 
            body: dados 
        }).then(r=>{return r.text()}).then(res=>{
                console.log(res);
                if (res === "salvas"){
                    window.location.href = URL_SITE+"/Templates/chat.php";
                } else {
                    display_erros.innerHTML = "Falha ao enviar mensagem.";
                    display_erros.style.display = "block";
                    statusbar.innerHTML = "Falha ao realizar ação";
                    reqStatus.style.transform = "translateY(115px)";
                    console.log(res);
                }
        });
        scrollToBottom();
    }
});

if (vendedor){
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
            fetch(URL_SITE+"/ServerScripts/tratar_proposta.php", {
                method:"POST", 
                body: dados 
            }).then(r=>{return r.text()}).then(res=>{
                console.log(res);
                if (res === "cadastrado"){
                    window.location.href = URL_SITE+"/Templates/chat.php";
                } else { 
                    display_erros.innerHTML = "Por favor, insira um prazo e um orçamento.";
                    display_erros.style.display = "block";
                    statusbar.innerHTML = "Falha ao realizar ação";
                    reqStatus.style.transform = "translateY(115px)";
                    console.log(res);
                }
            });

        } else {
            alert("Por favor, insira um prazo e um orçamento.");
        }
    });
}
scrollToBottom();

