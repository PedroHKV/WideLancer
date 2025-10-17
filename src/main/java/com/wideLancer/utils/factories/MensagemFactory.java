package com.wideLancer.utils.factories;

import com.wideLancer.abstractions.Mensagem;
import com.wideLancer.models.*;

public class MensagemFactory {

    public static Mensagem criarMensagem(String tipo, int idChat, int emissorId, String texto, Double orcamento, String prazo) {
        switch (tipo.toLowerCase()) {
            case "comum":
                MensagemComum msgComum = new MensagemComum();
                msgComum.setChat(idChat);
                msgComum.setEmissor(emissorId);
                msgComum.setTexto(texto);
                return msgComum;

            case "proposta":
                Proposta proposta = new Proposta();
                proposta.setChat(idChat);
                proposta.setOrcamento(orcamento != null ? orcamento : 0);
                proposta.setPrazo(prazo);
                return proposta;

            default:
                throw new IllegalArgumentException("Tipo de mensagem inválido: " + tipo);
        }
    }
}
