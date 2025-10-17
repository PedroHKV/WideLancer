package com.wideLancer.models;

import com.wideLancer.abstractions.Mensagem;

public class Proposta extends Mensagem{

    private int id;
    private double orcamento;
    private String prazo;
    private String aceita;
    private int chat;

    public int getId(){
        return this.id;
    }

    @Override
    public String getTipo(){
        return "Proposta";
    }

    public int getChat(){
        return this.chat;
    }

    public String getPrazo(){
        return this.prazo;
    }

    public String getAceita(){
        return this.aceita;
    }

    public double getOrcamento(){
        return this.orcamento;
    }

    public void setId(int id){
        this.id = id;
    }

    public void setChat(int chat){
        this.chat = chat;
    }

    public void setPrazo(String prazo){
        this.prazo = prazo;
    }

    public void setAceita(String aceita){
        this.aceita = aceita;
    }

    public void setOrcamento(double orcamento){
        this.orcamento = orcamento;
    }
}
