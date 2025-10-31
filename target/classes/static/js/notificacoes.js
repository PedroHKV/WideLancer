const chats = Array.from(document.getElementsByClassName("notificacao"));

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
  let dados = new FormData();
  dados.append("idOutro", id);
  fetch(URL_SITE + "/chat/defChat", {
    method : "POST", 
    body : dados
  }).then(r => {return r.text()}).then(r => {
    if ( r === "sucesso"){
      const http = URL_SITE + "/chat";
      window.location.href = http;
    } else {
      console.log(r);
    }
  }).catch(r => {console.log(r);})
}

chats.forEach(chat => {
  chat.onclick = () =>{ 
    const id = chat.id;
    redirect(id);
  };
});

