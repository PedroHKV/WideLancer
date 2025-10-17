package com.wideLancer.models;

public class Solicitacao {
    private int id;
    private String cpf;
    private String stripeId;
    private String foto;
    private String feita_em;
    private String respondida_em;
    private int solicitante;
    private int respondida_por;
    private String decisao;

    public void setId(int id){
        this.id = id;
    }

    public void setCPF (String cpf){
        this.cpf = cpf;
    }
    
    public void setStripeId (String stripeId){
        this.stripeId = stripeId;
    }

    public void setFoto (String foto){
        this.foto = foto;
    }

    public void setFeita_em (String feita_em){
        this.feita_em = feita_em;
    }

    public void setRespondidaEm (String respondida_em){
        this.respondida_em = respondida_em;
    }

    public void setSolicitante (int solicitante){
        this.solicitante = solicitante;
    }

    public void setRespondidaPor (int respondida_por){
        this.respondida_por = respondida_por;
    }

    public void setDecisao( String decisao ){
        this.decisao = decisao;
    }

     public String getCpf (){
        return this.cpf;
    }
    
    public String getStripeId (){
        return this.stripeId;
    }

    public String getFoto (){
        return this.foto;
    }

    public String getFeita_em (){
        return this.feita_em;
    }

    public String getRespondidaEm (){
        return this.respondida_em;
    }

    public int getSolicitante (){
        return this.solicitante;
    }

    public int getRespondidaPor (){
        return this.respondida_por;
    }

    public int getId(){
        return this.id;
    }

    public String getDecisao(){
        return this.decisao;
    }
}
