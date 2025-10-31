const cardElementDiv = document.getElementById("card-element");
const submit = document.getElementById("submit");
const metodoPagamentoSelect = document.getElementById("metodo-pagamento");
const cardContainer = document.getElementById("card-container");
let stripe, card;

// Inicializa Stripe apenas se houver formulário de cartão
if (cardElementDiv) {
    stripe = Stripe(chave_publica); 
    const elements = stripe.elements();
    card = elements.create("card");
    card.mount("#card-element");

    card.onchange = (event) => {
        const displayError = document.getElementById("card-errors");
        displayError.textContent = event.error ? event.error.message : "";
    };
}

// Alterna visibilidade do campo de cartão
if (metodoPagamentoSelect && cardContainer) {
    metodoPagamentoSelect.addEventListener("change", () => {
        const metodo = metodoPagamentoSelect.value;
        cardContainer.style.display = (metodo === "cartao") ? "block" : "none";
    });
}

// Função de envio de pagamento
async function enviarPagamento(preco, StripeId) {
    const metodo = metodoPagamentoSelect ? metodoPagamentoSelect.value : "cartao";

    const dados = new FormData();
    dados.append("vendedor_id", StripeId);
    dados.append("tipo", metodo);

    if (metodo === "cartao") {
        if (!stripe || !card) return;

        const { error, paymentMethod } = await stripe.createPaymentMethod({
            type: "card",
            card: card
        });

        if (error) {
            document.getElementById("card-errors").textContent = error.message;
            return;
        }

        dados.append("pagamento_id", paymentMethod.id);
    } 
    // Para Pix ou Boleto, pagamento_id pode ficar vazio ou gerar ID interno
    else {
        dados.append("pagamento_id", ""); 
    }

    const res = await fetch(`${URL_SITE}/pagamento/receberPagamento`, {
        method: "POST",
        body: dados
    }).then(r => r.text());

    if (res === "sucesso") {
        window.location.href = `${URL_SITE}/produtos`;
    } else {
        document.getElementById("card-errors").textContent = "Erro no pagamento!";
    }
}

submit?.addEventListener("click", () => {
    enviarPagamento("46", "46"); 
});