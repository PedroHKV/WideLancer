package com.wideLancer.models;

import com.wideLancer.abstractions.Mensagem;

public class MensagemComum extends Mensagem{

    private int id;
    private String texto;
    private String imagem;
    private int emissor;
    private int chat;

    @Override
    public String getTipo(){
        return "MensagemComum";
    }

    public int getId(){
        return this.id;
    }

    public int getEmissor(){
        return this.emissor;
    }

    public int getChat(){
        return this.chat;
    }

    public String getImagem(){
        return this.imagem;
    }

    public String getTexto(){
        return this.texto;
    }

    public void setId(int id){
        this.id = id;
    }

    public void setEmissor(int emissor){
        this.emissor = emissor;
    }

    public void setChat(int chat){
        this.chat = chat;
    }

    public void setImagem(String imagem){
        this.imagem = imagem;
    }

    public void setTexto(String texto){
        this.texto = texto;
    }
}
