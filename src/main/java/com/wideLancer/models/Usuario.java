package com.wideLancer.models;

import java.sql.SQLException;


public class Usuario{
    private int id;
    private String email;
    private String senha;
    private String nome;
    private String sobrenome;
    private String stripeid;
    private String cpf;
    private boolean ativo;
    private String foto;
    private boolean vendedor;
    private boolean curador;
    private String tituloPortifolio;
    private String descricaoPortifolio;

    public String autenticar(String senha) throws SQLException{
        String senhaSalva = this.senha;
        if (!senhaSalva.equals(senha))
            return "err"; // a senha informada esta errada
        return "certo"; // usuario autenticado com sucesso
    }

    public void setId(int id){
        this.id = id;
    }

    public void setEmail(String email){
        this.email = email;
    }

    public void setSenha(String senha){
        this.senha = senha;
    }

    public void setNome(String nome){
        this.nome = nome;
    }

    public void setSobrenome(String sobrenome){
        this.sobrenome = sobrenome;
    }

    public void setStripeId(String strid){
        this.stripeid = strid;
    }

    public void setCpf(String cpf){
        this.cpf = cpf;
    }

    public void setAtivo(boolean ativo){
        this.ativo = ativo;
    }

    public void setVendedor(boolean vendedor){
        this.vendedor = vendedor;
    }

    public void setCurador(boolean curador){
        this.curador = curador;
    }

    public void setFoto(String foto){
        this.foto = foto;
    }

    public void setDescricaoPortifolio(String decricao){
        this.descricaoPortifolio = decricao;
    }

    public void setTituloPortifolio(String titulo){
        this.tituloPortifolio = titulo;
    }

    public String getEmail(){
        return this.email;
    }

    public int getId(){
        return this.id;
    }

    public boolean isCurador(){
        return this.curador;
    }

    public boolean isVendedor(){
        return this.vendedor;
    }

    public String getFoto(){
        return this.foto;
    }

    public String getNome(){
        return this.nome;
    }

    public String getSobrenome(){
        return this.sobrenome;
    }

    public String getSenha(){
        return this.senha;
    }

    public String getCpf(){
        return this.cpf;
    }

    public String getStripeId(){
        return this.stripeid;
    }

    public boolean isAtivo(){
        return this.ativo;
    }

    public String getTituloPortifolio(){
        return this.tituloPortifolio;
    }

    public String getDescricaoPortifolio(){
        return this.descricaoPortifolio;
    }

    public String getNomeCompleto(){
        return (this.nome + " " + this.sobrenome);
    }
}
