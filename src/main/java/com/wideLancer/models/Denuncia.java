package com.wideLancer.models;

public class Denuncia {

    private int id;
    private String motivo;
    private int delator;
    private int anuncioId;
    private String decisao;
    private int avaliadaPor;

    public int getId(){
        return this.id;
    }

    public int getDelator(){
        return this.delator;
    }

    public int getAnuncioId(){
        return this.anuncioId;
    }

    public String getMotivo() {
        return this.motivo;
    }

    public String getDecisao(){
        return this.decisao;
    }

    public int getAvaliadaPor(){
        return this.avaliadaPor;
    }

    public void setId(int id){
        this.id = id;
    }

    public void setMotivo(String motivo){
        this.motivo = motivo;
    }

    public void setDelator( int delator){
        this. delator = delator;
    }

    public void setAnuncioId(int anuncioId){
        this.anuncioId = anuncioId;
    }
    
    public void setDecisao (String decisao){
        this.decisao = decisao;
    }

    public void setAvaliadaPor(int avaliadaPor){
        this.avaliadaPor = avaliadaPor;
    }
}
