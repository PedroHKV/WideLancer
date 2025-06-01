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
const err = document.getElementById("err");

const submit = document.getElementById("submit");

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

// Função para exibir a mensagem de erro
function exibirMensagemErro(mensagem) {
    err.style.display = "none";
    err.innerHTML = mensagem;
    err.style.display = "flex";
}


//formatação do campo de CPF
cpf_tag.addEventListener('input', () => {
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
});

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

//controle da caixa de dialogo de envio de solicitação
doc_input.onchange = () => {
    let bytes_img = doc_input.files[doc_input.files.length - 1];
    let url = URL.createObjectURL(bytes_img);
    doc_lab.innerHTML = "<img style='width:100%; height:100%; border-radius:5px; border:none;' src = '"+url+"'>";
} 

doc_enviar.onclick = () => {
    doc_div.classList.remove("inativo");
    doc_div.classList.add("ativo");
}

cancelar_btn.onclick = () => {
    doc_div.classList.remove("ativo");
    doc_div.classList.add("inativo");
}

// submit (PARA SOLICITAR CONTA DE FORNECEDOR)
btn_solic.onclick = () => {
    const cpf = document.getElementById("cpf_doc").value ;
    const pix = document.getElementById("chavePIX_doc").value ;
    const doc_foto = doc_input.files;
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
    }

    // VALIDAÇÃO Stripe ID
    const stripeRegex = /^acct_[a-zA-Z0-9]+$/;
    if (!pix) {
        exibirMensagemErro("O campo: Stripe ID é obrigatório");
        return;
    }
    if (!stripeRegex.test(pix)) {
        exibirMensagemErro("Stripe ID inválido! Deve começar com 'acct_' seguido de letras ou números.");
        return;
    }

    if ( doc_foto.length === 0){
        exibirMensagemErro("é necessário incluir uma foto do RG");
    }

    let dados = new FormData();
    dados.append("cmd", "solicitar");
    dados.append("cpf", cpf);
    dados.append("pix", pix);
    dados.append("foto", doc_foto[doc_foto.length - 1]);
    fetch(URL_SITE+"/ServerScripts/tratar_solicitacao.php", {
        method : "POST",
        body : dados
    }).then(r => {return r.text()}).then(res => {
        console.log(res);
        if (res === "sucesso"){
            window.location.href = URL_SITE+"/Templates/perfil.php";
        }
    }).catch(erro => {
        console.log(erro);
    })
}

// redirecionar para cadastro de anuncio
btn_add_anuncio.onclick = () => {
    window.location.href = URL_SITE + "/Templates/cadas_anuncio.html";
}

// carregamento da foto
fotos_input.oninput = () => {
    let img = fotos_input.files[0];
    let url = URL.createObjectURL(img);
    fotos_img.src = url;
}

// edição de informações
// mostra caixa de confirmação de exclusao
btn_esc_anuncio.onclick = () => {
    let div = document.getElementById("confirm");
    div.style.display = "block";
    requestAnimationFrame(() => {
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
    dados.append("id", id);

    fetch(URL_SITE + "/ServerScripts/delete_anuncio.php", {
        method: "POST",
        body: dados
    }).then(r => r.text()).then(res => {
        console.log(res);
        if (res === "excluido") {
            window.location.href = URL_SITE + "/Templates/perfil.php";
        } else {
            console.log(res);
        }
    }).catch(e => {
        console.log(e);
    })
}

// botão de submit (salvar alterações)
submit.onclick = () => {
    const nome = document.getElementById("nome").value;
    const sobrenome = document.getElementById("sobrenome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const pix = document.getElementById("chavePIX").value;
    const titulo = document.getElementById("titulo") ? document.getElementById("titulo").value : '';
    const descricao = document.getElementById("txtarea") ? document.getElementById("txtarea").value : '';
    const img = fotos_input.files[0];

    let dados = new FormData();
    dados.append("nome", nome);
    dados.append("sobrenome", sobrenome);
    dados.append("email", email);
    dados.append("senha", senha);
    dados.append("chavePix", pix);
    dados.append("titulo", titulo);
    dados.append("descricao", descricao);

    if (img) {
        dados.append("img", img);
        console.log("img enviada");
    }

    fetch(URL_SITE + "/ServerScripts/update_usuario.php", {
        method: "POST",
        body: dados
    }).then(r => r.text())
    .then(res => {
        console.log(res);
        if (res === "sucesso") {
            window.location.href = URL_SITE + "/Templates/perfil.php";
        }
    }).catch(e => {
        console.log(e);
    });
}

// controle do botão de voltar
voltar.onclick = () => {
    window.location.href = URL_SITE + "/Templates/home.php";
}

// função para renderizar a página de um anuncio
function render_anuncio(id) {
    window.location.href = URL_SITE + "/Templates/visualis_anuncio.php?id=" + id;
}
