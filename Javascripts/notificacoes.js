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

function redirect (id){
    console.log("cheguei")
    let dados = new FormData();
    dados.append("chat", id);
    fetch(URL_SITE + "/ServerScripts/processa_chat.php", {
      method : "POST", 
      body : dados
    }).then(r => {return r.text()}).then(res => {
      console.log(res);
      const http = URL_SITE + "/Templates/chat.php";
      window.location.href = http;
    }).catch(r => {console.log(r);})
  }
  

