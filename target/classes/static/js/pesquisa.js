const pegarBarra = document.getElementById ("search-bar");
const voltar = document.getElementById ("volta");
const anuncios = Array.from(document.getElementsByClassName("card"));

pegarBarra.onchange = () => {
    const baseHTTP = URL_SITE+"/pesquisa?query=";
    let pesquisa = pegarBarra.value;
    pesquisa = pesquisa.replaceAll(" ", "_");
    const http = baseHTTP + pesquisa;
    window.location.href = http;
}

voltar.onclick = () => {
    window.location.href=URL_SITE + "/home";
}

anuncios.forEach(anuncio => {
    anuncio.onclick = () =>{
        const id = anuncio.id;
        const http = URL_SITE+"/pesquisa/anuncio?id="+id;
        window.location.href = http;
    }
})

