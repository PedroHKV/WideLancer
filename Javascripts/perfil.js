const servicos = document.getElementById('servicos');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const btn_add_anuncio = document.querySelector("#addservic input");
const nome_tag = document.getElementById("nome");
const sobrenome_tag = document.getElementById("sobrenome");
const email_tag = document.getElementById("email");
const senha_tag = document.getElementById("senha");
const pix_tag = document.getElementById("chavePIX");
const descricao_tag =document.getElementById("txtarea");
const fotos_input = document.getElementById("infoto");
const fotos_img = document.getElementById("foto_lab");

const submit = document.getElementById("submit");
const nome_initial = document.getElementById("nome").value;
const sobrenome_initial = document.getElementById("sobrenome").value;
const email_initial = document.getElementById("email").value;
const senha_initial = document.getElementById("senha").value;
const pix_initial = document.getElementById("chavePIX").value;
const descricao_initial =document.getElementById("txtarea").value;

//controle do carrossel
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

//redirecionar para cadastro de anuncio
btn_add_anuncio.onclick = () => {
    window.location.href = URL_SITE+"/Templates/cadas_anuncio.html";
}

//carregamento da foto
fotos_input.oninput = () => {
    let img = fotos_input.files[0];
    let url = URL.createObjectURL(img);
    fotos_img.src = url;
}

//edição de informações

//se for informada a chave pix o usuario é promovido
//a vendendor e ganha um portifolio
submit.onclick = () => {
    const nome = document.getElementById("nome").value;
    const sobrenome = document.getElementById("sobrenome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const pix = document.getElementById("chavePIX").value;
    const descricao =document.getElementById("txtarea").value;
    const img = fotos_input.files[0];

    let houve_mudanca = false;
    let dados = new FormData();

    if ( !(nome_initial === nome) ){
        dados.append("nome", nome);
        houve_mudanca = true; 
    }
    if ( !(sobrenome_initial === sobrenome) ){
        dados.append("sobrenome", sobrenome);
        houve_mudanca = true;
    }
    if ( !(email_initial === email) ){
        dados.append("email", email);
        houve_mudanca = true;
    }
    if ( !(senha_initial === senha) ){
        dados.append("senha", senha);
        houve_mudanca = true;
    }
    if ( !(pix_initial === pix) ){
        dados.append("pix", pix);
        houve_mudanca = true;
    }
    if ( !(descricao_initial === descricao) ){
        dados.append("descricao", descricao);
        houve_mudanca = true;
    }
    
    console.log(img);
    if ( !(img == null || img == undefined) ){
        dados.append("img", img);
        houve_mudanca = true;
        console.log("img enviada");
    }

    if (houve_mudanca){
        fetch(URL_SITE+"/ServerScripts/update_usuario.php", {
            method : "POST",
            body : dados
        }).then(r => { return r.text()}).then(res => {
            console.log(res);
        }).catch( e => {console.log(e);});
    }
    

    

}
