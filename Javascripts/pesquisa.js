const pegarBarra = document.getElementById ("search-bar");

function render_anuncio( id ){
    const http = URL_SITE+"/Templates/visualis_anuncio.php?id="+id;
    window.location.href = http;
}

pegarBarra.onchange = () => {
    const baseHTTP = URL_SITE+"/Templates/pesquisa.php?query=";
    let pesquisa = pegarBarra.value;
    pesquisa = pesquisa.replaceAll(" ", "+");
    const http = baseHTTP + pesquisa;
    window.location.href = http;
}