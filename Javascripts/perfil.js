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
// função de validação
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // remove tudo que não for número
    const errorElement = document.getElementById('cpf-error'); // Procurar se existe algum erro prévio
    
    // Se houver um erro prévio, removê-lo
    if (errorElement) {
        errorElement.remove();
    }
    if (cpf.length !== 11) {
        exibirMensagemErro("O CPF deve ter exatamente 11 dígitos.");
        return false;
    }
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
    const cpfTag = document.getElementById("cpf");
    const errorElement = document.createElement("span");
    errorElement.id = 'cpf-error'; // Definindo um id para identificar facilmente o erro
    errorElement.style.color = 'red'; // Cor vermelha para a mensagem
    errorElement.textContent = mensagem; // Texto da mensagem de erro

    // Adiciona o erro abaixo do campo CPF
    cpfTag.parentNode.insertBefore(errorElement, cpfTag.nextSibling);
}

// botão de submit (salvar alterações)
submit.onclick = () => {
    const nome = document.getElementById("nome").value;
    const sobrenome = document.getElementById("sobrenome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const titulo = document.getElementById("titulo") ? document.getElementById("titulo").value : '';
    const cpf = document.getElementById("cpf") ? document.getElementById("cpf").value : '';
    const pix = document.getElementById("chavePIX") ? document.getElementById("chavePIX").value : '';
    const descricao = document.getElementById("txtarea") ? document.getElementById("txtarea").value : '';
    const img = fotos_input.files[0];

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
                return;
            }
        }
    }
    let dados = new FormData();
    dados.append("nome", nome);
    dados.append("sobrenome", sobrenome);
    dados.append("email", email);
    dados.append("senha", senha);
    dados.append("titulo", titulo);
    dados.append("descricao", descricao);
    dados.append("cpf", cpf);
    dados.append("pix", pix);

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
