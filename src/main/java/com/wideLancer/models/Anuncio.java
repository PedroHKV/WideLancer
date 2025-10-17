package com.wideLancer.models;

public class Anuncio {

    private int id;
    private String titulo;
    private String descricao;
    private String foto;
    private int anunciante;
    private boolean ativo;

    public void setTitulo(String titulo){ this.titulo = titulo; }
    public void setAtivo(boolean ativo){ this.ativo = ativo; }
    public void setDescricao(String descricao){ this.descricao = descricao; }
    public void setFoto(String foto){ this.foto = foto; }
    public void setAnunciante(int anunciante){ this.anunciante = anunciante; }
    public void setId(int id){ this.id = id; }
    public String getTitulo(){ return this.titulo; }
    public String getDescricao(){ return this.descricao; }
    public String getFoto(){ return this.foto; }
    public int getAnunciante(){ return this.anunciante; }
    public boolean isAtivo(){ return this.ativo; }
    public int getId(){ return this.id; }

}

