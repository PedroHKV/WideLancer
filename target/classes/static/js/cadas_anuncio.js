const titulo = document.getElementById("nome");
const descricao = document.getElementById("descric");
const foto = document.getElementById("infile");
const infoto = document.getElementById("input_file");
const submit = document.getElementById("botao");
const alertDiv = document.getElementById("alert");

function alertar(msg){
    alertDiv.innerHTML = msg;
}

foto.oninput = () => {
    let img = foto.files[0];
    let url = URL.createObjectURL(img);
    infoto.innerHTML = "<img src ='"+url+"' id='foto' style='width:100%;height:100px;border-radius:5px;'>"
};

submit.onclick = () => {
    let tituloAnuncio = titulo.value;
    let descript = descricao.value;
    let imagem = foto.files[0];

    let valido = (tituloAnuncio.trim() !== "") && (descript.trim() !== "");
    if (valido){
        let dados = new FormData();
        dados.append("titulo", tituloAnuncio);
        dados.append("descricao", descript);
        dados.append("imagem", imagem);
        fetch(URL_SITE+"/anuncios/cadastrar", {
            method : "POST",
            body : dados
        }).then(r => {return r.text();}).then(res => {
            console.log(res);
            if (res === "cadastrado"){
                window.location.href = URL_SITE+'/perfil';
            }
        }).catch(e => {
            alertar(e);
        });
    } else {
        alertar("todos os textos devem ser preenchidos");
    }
};