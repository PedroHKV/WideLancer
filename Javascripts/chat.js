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
    function scrollToBottom() {
        chatMain.scrollTop = chatMain.scrollHeight;
    }
    sendBtn.addEventListener('click', () => {
        const msgContent = input.value.trim();
        if (msgContent !== '') {
            const msg = document.createElement('div');
            msg.className = 'message-row sent';
            msg.innerHTML = `
                <img src="../imagens/usuario2.jpg" class="message-avatar" alt="Você">
                <div class="message">
                    <p>${msgContent}</p>
                    <span class="timestamp">${new Date().toLocaleString()}</span>
                </div>
            `;
            mensagens.appendChild(msg);
            input.value = '';
            scrollToBottom();
        }
    });
    propostaBtn.addEventListener('click', () => {
        propostaCard1.style.display = (propostaCard1.style.display === 'none' || propostaCard1.style.display === '') ? 'block' : 'none';
    });
    document.querySelector('.enviar-proposta').addEventListener('click', () => {
        const prazo = prazoInput.value;
        const orcamento = orcamentoInput.value;
        if (prazo && orcamento) {
            propostaCard2.querySelector('.prazo').textContent = `Prazo: ${prazo}`;
            propostaCard2.querySelector('.orcamento').textContent = `Orçamento: ${orcamento}`;
            propostaCard2.style.display = 'block';
            propostaCard1.style.display = 'none';
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

