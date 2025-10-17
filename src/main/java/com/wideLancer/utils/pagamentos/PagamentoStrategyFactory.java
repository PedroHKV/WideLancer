package com.wideLancer.utils.pagamentos;

import com.wideLancer.abstractions.PagamentoStrategy;

public class PagamentoStrategyFactory {

    public static PagamentoStrategy criar(String metodo, String pagamentoId, String vendedorStripe) {
        switch (metodo.toLowerCase()) {
            case "cartao":
                return new PagamentoCartao(pagamentoId);   
            default:
                throw new IllegalArgumentException("Método de pagamento inválido: " + metodo);
        }
    }
}