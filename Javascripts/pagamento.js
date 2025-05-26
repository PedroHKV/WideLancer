const cardElementDiv = document.getElementById("card-element");
let stripe, card; // <-- declare fora do bloco

async function enviar_pagamento(preco, StripeId){
    const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: "card",
        card: card
    });

    if (error) {
        document.getElementById("card-errors").textContent = error.message;
    } else {
        let dados = new FormData();
        dados.append("pagamento_id", paymentMethod.id); 
        dados.append("preco", preco);
        dados.append("vendedor_id", StripeId);
        fetch(URL_SITE+"/ServerScripts/tratar_pagamento.php", {
            method : "POST",
            body : dados
        }).then(r => r.text()).then(res => {
            console.log(res);
            if (res === "sucesso"){
                window.location.href = URL_SITE+"/Templates/chat.php";
            }
        }).catch ( err => {
            console.log(err);
        });
    }
}

if (cardElementDiv) {
    //caso o produto não tenha sido pago
    stripe = Stripe(chave_publica); // atribui à variável global
    const elements = stripe.elements();
    card = elements.create("card"); // atribui à variável global
    card.mount("#card-element");

    card.onchange = (event) => {
        const displayError = document.getElementById("card-errors");
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = "";
        }
    };
}
