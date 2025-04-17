let index = 3; // anúncio 3 como principal (índice 2)
const totalAnuncios = 7; // Total de anúncios
const anuncios = Array.from(document.querySelectorAll('.anuncio'));
let count = 0;
const pegarBarra = document.getElementById("search-bar");

attAnuncio();


function attAnuncio() {
        // Atualiza a visibilidade e o tamanho dos anúncios
        for (let i = 0; i < anuncios.length; i++) {
            if (i === index) {
                // O anúncio principal ficará grande
                anuncios[i].classList.add('principal');
                anuncios[i].classList.remove('extra');
            } else {
                // Os outros anúncios ficarão pequenos
                anuncios[i].classList.add('extra');
                anuncios[i].classList.remove('principal');
            }
    }
}

function renderAnunciosR() {
    count++;
    if (count % 3 == 0){
        const renderMem = anuncios[0];
        const renderMem1 = anuncios[1];
        const div = document.getElementsByClassName("container-anuncio")[0];
        anuncios.splice(0,2);
        anuncios.push(renderMem);
        anuncios.push(renderMem1);
        console.log(div.innerHTML);
    
        div.innerHTML = "";
        anuncios.forEach(anuncio => {
            div.appendChild(anuncio);
        })
    }
}

function moveCarousel(direction) {
    const container = document.querySelector('.container-anuncio');

    // Lógica para mover os anúncios para a direita ou para a esquerda
    if (direction === 'right') {
        // Move para o próximo anúncio
        index = (index + 1) % (totalAnuncios); // Se chegar ao último, vai para o primeiro

    } else if (direction === 'left') {
        // Move para o anúncio anterior
        index = (index - 1 + totalAnuncios) % totalAnuncios; // Se chegar ao primeiro, vai para o último
    }

        // Atualiza a visibilidade e o tamanho dos anúncios
        for (let i = 0; i < anuncios.length; i++) {
            if (i === index) {
                // O anúncio principal ficará grande
                anuncios[i].classList.add('principal');
                anuncios[i].classList.remove('extra');
            } else {
                // Os outros anúncios ficarão pequenos
                anuncios[i].classList.add('extra');
                anuncios[i].classList.remove('principal');
            }
    }

    // Ajusta a posição do contêiner para mover os anúncios
    const translateXValue = -(index - 3) * 320; // leva em conta o número de anúncios visíveis e a largura de cada anúncio
    container.style.transition = 'transform 0.5s ease'; // Adiciona transição suave para o movimento
    container.style.transform = `translateX(${translateXValue}px)`;
}
// controle da barra de pesquisa
pegarBarra.onchange = () => {
    const baseHTTP = URL_SITE+"/Templates/pesquisa.php?query=";
    let pesquisa = pegarBarra.value;
    pesquisa = pesquisa.replaceAll(" ", "+");
    const http = baseHTTP + pesquisa;
    window.location.href = http;
}
