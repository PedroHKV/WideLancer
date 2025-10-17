const pagarBtns = Array.from(document.getElementsByClassName("button"));

pagarBtns.forEach(btn => {
    btn.onclick = () => {
        const idProduto = btn.id;
        let dados = new FormData();
        dados.append("idProduto", idProduto);
        fetch(URL_SITE+"/produtos/defProduto", {
            method : "POST",
            body : dados
        }).then( r => {return r.text()}).then( r => {
            if (r === "sucesso"){
                window.location.href = URL_SITE+"/produtos/pagamento";
            }
        });
    }
});

