const pegarBarra = document.getElementById("search-bar");
const btn_sim = document.getElementById("conv_sim");
const btn_nao = document.getElementById("conv_nao");
const conviteDiv = document.getElementById("convite");
const inputsConviteDiv = document.getElementById("inputs_solic");
const convitesBtnsSimNao = document.getElementById("convite_acoes");
const conviteAviso = document.getElementById("convite_aviso");
const cancelaBtn = document.getElementById("cancelar");
const convitePergunta = document.getElementById("convite_perg");
const err = document.getElementById("err");
const cpf_tag = document.getElementById("cpf_tag");
const img = document.getElementById("img");
const img_lab = document.getElementById("foto");
const imagem_in = document.getElementById("imagem_in");
const submitSolicBtn = document.getElementById("confirmar");
const reqStatus = document.getElementById("reqStatus");
const aviso = document.getElementById("status");

// controle da barra de pesquisa
pegarBarra.onchange = () => {
    const baseHTTP = URL_SITE+"/pesquisa?query=";
    let pesquisa = pegarBarra.value;
    pesquisa = pesquisa.replaceAll(" ", "_");
    const http = baseHTTP + pesquisa;
    window.location.href = http;
}

function convidarParaSerVendedor(){
    conviteDiv.classList.remove("inativo");
    conviteDiv.classList.add("ativo");
}

btn_nao.onclick = () =>{
    conviteDiv.classList.remove("ativo");
    conviteDiv.classList.add("inativo");
}

btn_sim.onclick = () =>{
    convitePergunta.classList.add("inativo");
    convitesBtnsSimNao.classList.remove("ativo");
    convitesBtnsSimNao.classList.add("inativo");
    inputsConviteDiv.classList.remove("inativo");
    inputsConviteDiv.classList.add("ativo");
    conviteAviso.innerHTML = "preencha os campos e forneça uma foto segurando um documento oficial com foto";
}

cancelaBtn.onclick = () =>{
    conviteDiv.classList.remove("ativo");
    inputsConviteDiv.classList.remove("ativo");
    conviteDiv.classList.add("inativo");
    inputsConviteDiv.classList.add("inativo");
    convitePergunta.classList.remove("inativo");
    convitesBtnsSimNao.classList.remove("inativo");
    convitePergunta.classList.add("ativo");
    convitesBtnsSimNao.classList.add("ativo");
    conviteAviso.innerHTML = "Você precisa de uma conta de vendedor para poder fazer anuncios de serviços";
}

//validações e envio das informações da solicitação

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // remove tudo que não for número
    
    if (/^(\d)\1{10}$/.test(cpf)) {
        exibirMensagemErro("O CPF não pode ser composto por números repetidos.");
        return false;
    }
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) {
        exibirMensagemErro("CPF inválido, tente novamente.");
        return false;
    }

    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) {
        exibirMensagemErro("CPF inválido, tente novamente.");
        return false;
    }
    return true;
}

function exibirMensagemErro(mensagem) {
    err.style.display = "none";
    err.innerHTML = mensagem;
    err.style.display = "flex";
}

cpf_tag.oninput = () => {
    let cpf = cpf_tag.value.replace(/\D/g, ''); // Remove tudo que não é número
    if (cpf.length > 11) cpf = cpf.slice(0, 11); // Limita a 11 dígitos

    // Formatar como 000.000.000-00
    let cpfFormatado = cpf;
    if (cpf.length > 9) {
        cpfFormatado = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    } else if (cpf.length > 6) {
        cpfFormatado = cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
    } else if (cpf.length > 3) {
        cpfFormatado = cpf.replace(/(\d{3})(\d{1,3})/, "$1.$2");
    }
    
    cpf_tag.value = cpfFormatado;
}

imagem_in.onchange = () =>{
    let bytes_img = imagem_in.files[imagem_in.files.length - 1];
    let url = URL.createObjectURL(bytes_img);
    img_lab.innerHTML = "<img style='max-width:50px; max-height:50px; border-radius:5px; border:none;' src = '"+url+"'>";
}

submitSolicBtn.onclick = () =>{
    const cpf = document.getElementById("cpf_tag").value ;
    const pix = document.getElementById("stripe_tag").value ;
    const doc_foto = imagem_in.files;
    // VALIDAÇÕES CPF
    if (cpf) {
        const cpfLimpo = cpf.replace(/\D/g, ''); 
        if (cpf) {
            const cpfLimpo = cpf.replace(/\D/g, ''); 
            
            // Só números permitidos
            if (!/^\d+$/.test(cpfLimpo)) {
                exibirMensagemErro("O CPF deve conter apenas números de 0 a 9.");
                return;
            }
            
            if (cpfLimpo.length !== 11) {
                exibirMensagemErro("O CPF deve ter exatamente 11 dígitos.");
                return;
            }
            
            if (!validarCPF(cpfLimpo)) {
                exibirMensagemErro("CPF invalido");
                return;
            }
        }
    } else {
        exibirMensagemErro("O campo CPF é obrigatorio.");
        return;
    }

    if (!pix){
        exibirMensagemErro("o campo: Stripe Id é obrigatório");
        return;
    }

    if ( doc_foto.length === 0){
        exibirMensagemErro("é necessário incluir uma foto do RG");
    }

    let dados = new FormData();
    dados.append("cpf", cpf);
    dados.append("pix", pix);
    dados.append("foto", doc_foto[doc_foto.length - 1]);
    fetch(URL_SITE+"/solicitacoes/cadastrar", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then(res => {
        console.log(res);
        if (res === "cadastrado"){
            aviso.innerHTML = "solicitação cadastrada com sucesso, aguarde enquanto analizamos a validade das informações";
        } else if(res === "dup_key") {
            aviso.innerHTML = "você ja enviou uma solicitação";
        } else {
            aviso.innerHTML = "falha ao enviar solicitação";
        }
        reqStatus.style.transform = "translateY(115px)";
        cancelaBtn.click();
    }).catch(erro => {
        console.log(erro);
    })
} 

function translatediv(){
    reqStatus.style.transform = "translateY(-115px)";
}