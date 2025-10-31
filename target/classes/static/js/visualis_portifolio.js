const voltarBtn = document.getElementById("voltar");
const servicosCards = Array.from(document.getElementsByClassName("servico"));

voltarBtn.onclick = () => {
    
}

// para renderizar a página de um anuncio
servicosCards.forEach(servic => {
    servic.onclick = () => {
        const id = servic.id;
        window.location.href = URL_SITE + "/pesquisa/anuncio?id=" + id;
    }
});