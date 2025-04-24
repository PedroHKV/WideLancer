const servicos = document.getElementById('servicos');
const voltar = document.getElementById("voltar");

const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const btn_add_anuncio = document.getElementById("novo_anunc");
const btn_esc_anuncio = document.getElementById("esc");
const btn_mod_anuncio = document.getElementById("mod");
const sim_btn = document.getElementById("sim");
const nao_btn = document.getElementById("nao");

const nome_tag = document.getElementById("nome");
const sobrenome_tag = document.getElementById("sobrenome");
const email_tag = document.getElementById("email");
const senha_tag = document.getElementById("senha");
const cpf_tag = document.getElementById("cpf");
const pix_tag = document.getElementById("chavePIX");
const titulo_tag = document.getElementById("titulo");
const descricao_tag =document.getElementById("txtarea");
const fotos_input = document.getElementById("infoto");
const fotos_img = document.getElementById("foto_lab");


const submit = document.getElementById("submit");

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
//mostra caixa de confirmação de exclusao
btn_esc_anuncio.onclick = () => {
    let div = document.getElementById("confirm");
    div.style.display = "block";
    requestAnimationFrame( () => {
        div.classList.add("show");
    });
}

nao_btn.onclick = () => {
    let div = document.getElementById("confirm");
    div.classList.remove('show');
    setTimeout(() => div.style.display = 'none', 600);
}

sim_btn.onclick = () => {
    let div = document.getElementById("confirm");
    const anuncio = document.querySelectorAll(".servico").item(index);
    let id = anuncio.id;
    let dados = new FormData();
    dados.append("id",id);

    fetch(URL_SITE+"/ServerScripts/delete_anuncio.php",{
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then( res => {
        console.log(res);
        if (res === "excluido"){
            window.location.href = URL_SITE+"/Templates/perfil.php";
        } else {
            console.log(res);
        }
    }).catch( e=> {
        console.log(e);
    })
    
}


//se for informada a chave pix o usuario é promovido
//a vendendor e ganha um portifolio
submit.onclick = () => {
    const nome = document.getElementById("nome").value;
    const sobrenome = document.getElementById("sobrenome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const titulo = document.getElementById("titulo").value;
    const cpf = document.getElementById("cpf").value;
    const pix = document.getElementById("chavePIX").value;
    const descricao =document.getElementById("txtarea").value;
    const img = fotos_input.files[0];

    let houve_mudanca = false;
    let dados = new FormData();

    dados.append("nome", nome);
    dados.append("sobrenome", sobrenome);
    dados.append("email", email);
    dados.append("senha", senha);
    dados.append("titulo", titulo);
    dados.append("descricao", descricao);
    dados.append("cpf", cpf);
    dados.append("pix", pix);
    dados.append("titulo", titulo);
    dados.append("descricao", descricao);

    if ( !(img == null || img == undefined) ){
        dados.append("img", img);
        houve_mudanca = true;
        console.log("img enviada");
    }
    fetch(URL_SITE+"/ServerScripts/update_usuario.php", {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(res => {
        console.log(res);
        if ( res === "sucesso" ){
            window.location.href = URL_SITE+"/Templates/perfil.php";
        }
    }).catch( e => {console.log(e);});
}

//cobtrole do botao de voltar
voltar.onclick = () => {
    window.location.href = URL_SITE+"/Templates/home.php";
}

//função para reenderizar a pagina de um anuncio
function render_anuncio(id){
    window.location.href = URL_SITE+"/Templates/visualis_anuncio.php?id="+id;
}

