const botao = document.getElementById("botao");
const email = document.getElementById("email");
const senha = document.getElementById("senha");
const display_erros = document.getElementById("statusHTTP");


botao.onclick = () => {
    let em = email.value;
    let sen = senha.value; 
    let valido = validar_credenciais(em, sen);
    if(valido === "valido"){
        let dados = new FormData();
        
        dados.append("email", em );
        dados.append("senha", sen);
        fetch(URL_SITE+"/autenticar", {
            method : "POST", body : dados
        } ).then( r => {return r.text()} ).then( res => {
            console.log(res);
            if( res === "em404"){
                display_erros.innerHTML = "email ou senha errados!";
                display_erros.style.display = "block";
            } else if ( res === "err"){
                display_erros.innerHTML = "email ou senha errados!";
                display_erros.style.display = "block";
            } else if (res === "certo"){
                window.location.href = URL_SITE+"/home";
            } else if (res === "inativo"){
                display_erros.innerHTML = "esta conta foi inativada!";
                display_erros.style.display = "block";
            } else {
                display_erros.innerHTML = "erro interno no servidor!";
                display_erros.style.display = "block";
            }
        }).catch(e => {
            console.log("cath: "+e);
        });
    } else if (valido === "email_nulo") {
        display_erros.innerHTML = "o campo email é obrigatorio";
        display_erros.style.display = "block";
    } else if (valido === "senha_nula"){
        display_erros.innerHTML = "o campo senha é obrigatorio";
        display_erros.style.display = "block";
    } else if (valido === "email_invalido"){
        display_erros.innerHTML = "email invalido";
        display_erros.style.display = "block";
    }
}

function validar_credenciais(em, sen){
    let regex_email = /@\w+.\w+$/
    if (em.trim() === "")
        return "email_nulo";
    else if (sen.trim() === "")
        return "senha_nula";
    else if (!regex_email.test(em))
        return "email_invalido";
    else 
        return "valido";
}