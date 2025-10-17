package com.wideLancer.utils.pagamentos;

import com.wideLancer.abstractions.PagamentoStrategy;
import com.wideLancer.models.Produto;
import com.stripe.Stripe;
import com.stripe.exception.StripeException;
import com.stripe.model.PaymentIntent;
import com.stripe.param.PaymentIntentCreateParams;

public class PagamentoCartao implements PagamentoStrategy {

    private String pagamentoId;

    public PagamentoCartao(String pagamentoId){
        this.pagamentoId = pagamentoId;
    }

    @Override
    public boolean pagar(double valor, Produto produto){
        Stripe.apiKey = "";

        try {
            PaymentIntentCreateParams params = PaymentIntentCreateParams.builder()
            .setAmount((long)(valor * 100)) // valor em centavos
            .setCurrency("brl")
            .setPaymentMethod(this.pagamentoId)
            .setConfirm(true)
            .setAutomaticPaymentMethods(
                PaymentIntentCreateParams.AutomaticPaymentMethods.builder()
                    .setEnabled(true)
                    .setAllowRedirects(PaymentIntentCreateParams.AutomaticPaymentMethods.AllowRedirects.NEVER)
                    .build()
            )
            .build();


            PaymentIntent intent = PaymentIntent.create(params);

            if ("succeeded".equals(intent.getStatus())) {
                produto.setPago(true);
                return true;
            }

        } catch (StripeException e) {
            e.printStackTrace();
        }

        return false;
    }
}
