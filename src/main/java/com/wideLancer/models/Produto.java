package com.wideLancer.models;

public class Produto {
    private int id;
    private String url;
    private String horaEntrega;
    private int dono;
    private int emissor;
    private boolean pago;
    private double preco;

    public int getId(){
        return this.id;
    }

    public int getDono(){
        return this.dono;
    }

    public int getEmissor(){
        return this.emissor;
    }

    public String getHoraEntrega(){
        return this.horaEntrega;
    }

    public boolean getPago(){
        return this.pago;
    }

    public String getUrl(){
        return this.url;
    }

    public double getPreco(){
        return this.preco;
    }

    public String getFileName(){
        String[] tokens = this.url.split("/");
        String nome = tokens[tokens.length - 1]; 
        return nome;
    }

    public void setUrl( String url){
        this.url = url;
    }

    public void setPreco(double preco){
        this.preco = preco;
    }

    public void setHoraEntrega(String horaEntrega){
        this.horaEntrega = horaEntrega;
    }

    public void setPago(boolean pago){
        this.pago = pago;
    }

    public void setDono(int dono){
        this.dono = dono;
    }

    public void setEmissor(int emissor){
        this.emissor = emissor;
    }

    public void setId(int id){
        this.id = id;
    }
}
