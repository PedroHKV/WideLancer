function adicionarNotificacao(titulo, mensagem, link = "#") {
  const container = document.querySelector('.notificacoes-container');

  const novaNotificacao = document.createElement('div');
  novaNotificacao.classList.add('notificacao');

  const bolinha = document.createElement('span');
  bolinha.classList.add('bolinha-vermelha');

  novaNotificacao.innerHTML = `
    <h3>${titulo}</h3>
    <p>${mensagem} <a href="${link}">Ver mais</a></p>
  `;


  novaNotificacao.appendChild(bolinha);
  container.appendChild(novaNotificacao);

  document.addEventListener('click', function (e) {
    if (e.target.closest('.notificacao')) {
      const bolinha = e.target.closest('.notificacao').querySelector('.bolinha-vermelha');
      if (bolinha) {
        bolinha.remove();
      }
    }
  });
}

adicionarNotificacao("Pagamento Recebido", "Você recebeu R$ 200,00 pelo projeto de edição de vídeo.");
adicionarNotificacao("Mensagem nova", "Um cliente enviou uma mensagem sobre o serviço de tradução.");