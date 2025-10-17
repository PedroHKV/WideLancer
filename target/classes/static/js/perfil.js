const servicos = document.getElementById('servicos');
const voltar = document.getElementById("voltar");
const servicosCards = Array.from(document.getElementsByClassName("servico"));
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

const nome_tag = document.getElementById("nome");
const sobrenome_tag = document.getElementById("sobrenome");
const email_tag = document.getElementById("email");
const senha_tag = document.getElementById("senha");
const cpf_tag = document.getElementById("cpf_doc");
const doc_div = document.getElementById("cadas_solic");
const doc_input = document.getElementById("documento");
const doc_lab = document.getElementById("documento_lab");
const doc_enviar = document.getElementById("doc_enviar");
const cancelar_btn = document.getElementById("cancelar_btn");
const btn_solic = document.getElementById("cadas_solic_btn");
const pix_tag = document.getElementById("chavePIX");
const titulo_tag = document.getElementById("titulo");
const descricao_tag = document.getElementById("txtarea");
const fotos_input = document.getElementById("infoto");
const fotos_img = document.getElementById("foto_lab");

const submit = document.getElementById("submit");


// controle do carrossel
let index = 0;
const totalSlides = document.querySelectorAll('.servico').length;

nextBtn.addEventListener('click', () => {
    index = (index + 1) % totalSlides;
    servicos.style.transform = `translateX(-${index * 100}%)`;
});

prevBtn.addEventListener('click', () => {
    index = (index - 1 + totalSlides) % totalSlides;
    servicos.style.transform = `translateX(-${index * 100}%)`;
});

// carregamento da foto
fotos_input.oninput = () => {
    let img = fotos_input.files[0];
    let url = URL.createObjectURL(img);
    fotos_img.src = url;
}

// botão de submit (salvar alterações)
submit.onclick = () => {
    const nome = document.getElementById("nome").value;
    const sobrenome = document.getElementById("sobrenome").value;
    const email = document.getElementById("email").value;
    const titulo = document.getElementById("titulo") ? document.getElementById("titulo").value : '';
    const descricao = document.getElementById("txtarea") ? document.getElementById("txtarea").value : '';
    const img = fotos_input.files[0];

    let http = URL_SITE+"/perfil/alteracoes";
    let dados = new FormData();
    dados.append("nome", nome);
    dados.append("sobrenome", sobrenome);
    dados.append("email", email);
    dados.append("titulo", titulo);
    dados.append("descricao", descricao);

    if (img) {
        dados.append("img", img);
        console.log("img enviada");
        http += "ComImagem";
    }

    fetch(http, {
        method: "POST",
        body: dados
    }).then(r => r.text())
    .then(res => {
        console.log(res);
        if (res === "sucesso") {
            window.location.href = URL_SITE + "/perfil";
        }
    }).catch(e => {
        console.log(e);
    });
}

// controle do botão de voltar
voltar.onclick = () => {
    window.location.href = URL_SITE + "/home";
}

// para renderizar a página de um anuncio
servicosCards.forEach(servic => {
    servic.onclick = () => {
        const id = servic.id;
        window.location.href = URL_SITE + "/pesquisa/anuncio?id=" + id;
    }
});
