const nome = document.getElementById("nome");
const descricao = document.getElementById("descric");
const foto = document.getElementById("infile");
const infoto = document.getElementById("input_file");
const submit = document.getElementById("botao");

foto.oninput = () => {
    let img = foto.files[0];
    let url = URL.createObjectURL(img);
    infoto.innerHTML = "<img src ='"+url+"' id='foto' style='width:100%;height:100px;border-radius:5px;'>"
};

submit.onclick = () => {
    let name = nome.value;
    let descript = descricao.value;
    let imagem = foto.files[0];

    let valido = (name.trim() !== "") && (descript.trim() !== "");
    if (valido){
        let dados = new FormData();
        dados.append("nome", name);
        dados.append("descricao", descript);
        dados.append("imagem", imagem);
        fetch(URL_SITE+"/ServerScripts/cadastro_anuncio.php", {
            method : "POST",
            body : dados
        }).then(r => {return r.text();}).then(res => {
            console.log(res);
            alert(res);
        }).catch(e => {
            alert(e);
        });
    } else {
        alert("todos os textos devem ser preenchidos");
    }
};