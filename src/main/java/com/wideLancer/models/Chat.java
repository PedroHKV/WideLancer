package com.wideLancer.models;

import java.sql.SQLException;
import java.util.ArrayList;
import com.wideLancer.abstractions.Mensagem;
import com.wideLancer.repositories.ChatRepository;

public class Chat {

    private int id;
    private int vendedor;
    private int cliente;
    private boolean ativo;

    public ArrayList<Mensagem> carregarMensagens() throws SQLException{
        ChatRepository repositorioChat = new ChatRepository();
        ArrayList<Mensagem> mensagens =  repositorioChat.carregarMensagensDe(this);
        return mensagens;
    }

    public int getId(){
        return this.id;
    }

    public int getVendedor(){
        return this.vendedor;
    }

    public int getCliente(){
        return this.cliente;
    }

    public boolean getAtivo(){
        return this.ativo;
    }

    public void setId(int id){
        this.id = id;
    }

    public void setVendedor(int vendedor){
        this.vendedor = vendedor;
    }

    public void setCliente(int cliente){
        this.cliente = cliente;
    }

    public void setAtivo(boolean ativo){
        this.ativo = ativo;
    }
}
