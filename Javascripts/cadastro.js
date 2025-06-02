const in_nome = document.getElementsByName("nome")[0];
const in_sobrenome = document.getElementsByName("sobrenome")[0];
const in_email = document.getElementsByName("email")[0];
const in_senha = document.getElementsByName("senha")[0];
const statusHTTP = document.getElementById("statusHTTP");
const listaERROS = document.querySelector("#statusHTTP div");


const submit = document.getElementById("btn");

function renderErro(nome, sobrenome , email, senha){
    let erros = "";
    if (nome.trim() == ""){
        erros += "<p>O campo nome é obrigatorio!</p>";
        in_nome.style.borderBottom = "3px solid rgb(196, 29, 29)";
    } else { in_nome.style.borderBottom = "1px solid black";}
    if (sobrenome.trim() == ""){
        erros += "<p>O campo Sobrenome é obrigatorio!</p>";
        in_sobrenome.style.borderBottom = "3px solid rgb(196, 29, 29)";
    } else { in_sobrenome.style.borderBottom = "1px solid black";}
    if(email.trim() == ""){
        erros += "<p>O campo Email é obrigatorio!</p>";
        in_email.style.borderBottom = "3px solid rgb(196, 29, 29)";
    } else { in_email.style.borderBottom = "1px solid black";}
    if (senha.trim() == ""){
        erros += "<p>O campo Senha é obrigatorio!</p>";
        in_senha.style.borderBottom = "3px solid rgb(196, 29, 29)";
    } else { in_senha.style.borderBottom = "1px solid black";}
    listaERROS.innerHTML = erros;
    statusHTTP.style.display = "flex";
}

submit.onclick = () => {
    let nome = in_nome.value;
    let sobrenome = in_sobrenome.value;
    let email = in_email.value;
    let senha = in_senha.value;

    let valido = 
    (nome.trim() != "") && (sobrenome.trim() != "") && (email.trim() != "") && (senha.trim() != "");
    
    if (valido){
        let dados = new FormData();
        dados.append("nome", nome);
        dados.append("sobrenome", sobrenome);
        dados.append("email", email);
        dados.append("senha", senha);

        //nao sera esperada uma resposta , porque caso a requisição seja
        //bem sucedida o browser será redirecionado para a pagina de login
        fetch(URL_SITE+"/ServerScripts/cadastro.php", {
            method : "POST",
            body : dados
        }).then(r => {return r.text()}).then(r => {
            if (r == "cadastrado"){
                window.location.href = URL_SITE+"/Templates/login.php";
            } else {
                console.log(r);
            }
            
        }).catch(e => { console.log(e);
        });
        console.log("http enviado");
    } else {
        renderErro(nome, sobrenome, email, senha);
    }

}