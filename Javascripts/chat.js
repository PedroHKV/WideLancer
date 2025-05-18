document.addEventListener('DOMContentLoaded', () => {
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

    function scrollToBottom() {
        chatMain.scrollTop = chatMain.scrollHeight;
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
                window.location.href = URL_SITE+"/Templates/chat.php";
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
                        alert("Falha ao enviar mensagem.");
                    }
                });

            } else {
                alert("Por favor, insira um prazo e um orçamento.");
            }
        });
    }

    if (proposta_pendente){
        //informa que a proposta foi aceita
        aceitarBtn.addEventListener('click', () => {
            
        });

        //informa que a proposta foi recusada
        recusarBtn.addEventListener('click', () => {
            
        });
    }
    
    scrollToBottom();
});

