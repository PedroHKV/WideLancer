const botao = document.getElementById("botao");
const email = document.getElementById("email");
const senha = document.getElementById("senha");
const display_erros = document.getElementById("statusHTTP");


botao.onclick = () => {
    let em = email.value;
    let sen = senha.value; 
    let valido = (em.trim() !== "") && (sen.trim() !== "")
    if(valido){
        let dados = new FormData();
        dados.append("email", em );
        dados.append("senha", sen);
        fetch(URL_SITE+"/ServerScripts/login.php", {
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
                window.location.href = URL_SITE+"/Templates/home.php";
            }
        }).catch(e => {
            console.log("cath: "+e);
        });
    }
}