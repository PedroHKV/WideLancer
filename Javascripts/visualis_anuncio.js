function render_portif( id ){
    const http = URL_SITE+"/Templates/perfil.php?id="+id;
    window.location.href = http;
}

function init_negocio(id, usuario_id){
    let dados = new FormData();
    dados.append("solicitante" , id);
    dados.append("anunciante", usuario_id);
    fetch(URL_SITE+"/ServerScripts/iniciar_negocio.php", {
        method : "POST",
        body : dados
    }).then(r => { return r.text()}).then(res => {
        const http = URL_SITE+"/Templates/chat.php";
        window.location.href=http;

    }).catch(e => {
        console.log(e);
    })
}