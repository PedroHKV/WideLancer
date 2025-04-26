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


    propostaBtn.addEventListener('click', () => {
        propostaCard1.style.display = (propostaCard1.style.display === 'none' || propostaCard1.style.display === '') ? 'flex' : 'none';
    });


    document.querySelector('.enviar-proposta').addEventListener('click', () => {
        const prazo = prazoInput.value;
        const orcamento = orcamentoInput.value;
        if (prazo && orcamento) {

            let dados = new FormData();
            dados.append("msg_cnt", "<?><;><.>proposta<?><;><.>");
            dados.append("prazo", prazo);
            dados.append("orcamento", orcamento);
            fetch(URL_SITE+"/ServerScripts/tratar_msg.php", {
                method:"POST", 
                body: dados 
            }).then(r=>{return r.text()}).then(res=>{
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


    aceitarBtn.addEventListener('click', () => {
        propostaCard2.style.display = 'none';
        statusTexto.textContent = '🕒 Em andamento...';
        statusIndicador.style.backgroundColor = '#0077aa';
        alert("Proposta aceita! A conversa está em andamento.");
    });


    recusarBtn.addEventListener('click', () => {
        propostaCard2.style.display = 'none';
        statusTexto.textContent = '❌ Proposta recusada.';
        statusIndicador.style.backgroundColor = '#e60000';
        alert('Proposta recusada.');
    });

    
    scrollToBottom();
});

