package com.wideLancer.abstractions;

public abstract class Mensagem{

    protected String hora;

    public String getHora(){
        return this.hora;
    }
 
    public void setHora(String hora){
        this.hora = hora;
    }
    
    public abstract String getTipo();
}
