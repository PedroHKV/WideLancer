package com.wideLancer.repositories;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.MensagemComum;

public class MensagemComumRepository extends RepositoryTemplate<MensagemComum> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO MensagemComum(hora, texto, imagem, emissor, chat) VALUES (NOW(), ?, ?, ?, ?)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, MensagemComum mensagem) throws SQLException {
        stmt.setString(1, mensagem.getTexto());
        stmt.setString(2, mensagem.getImagem());
        stmt.setInt(3, mensagem.getEmissor());
        stmt.setInt(4, mensagem.getChat());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE MensagemComum SET texto = ?, imagem = ?, emissor = ?, chat = ?, hora = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, MensagemComum mensagem) throws SQLException {
        stmt.setString(1, mensagem.getTexto());
        stmt.setString(2, mensagem.getImagem());
        stmt.setInt(3, mensagem.getEmissor());
        stmt.setInt(4, mensagem.getChat());
        stmt.setString(5, mensagem.getHora());
        stmt.setInt(6, mensagem.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM MensagemComum WHERE id = ?";
    }

    @Override
    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"hora\": \"").append(rs.getString("hora")).append("\", ");
        json.append("\"texto\": \"").append(rs.getString("texto")).append("\", ");
        json.append("\"imagem\": \"").append(rs.getString("imagem")).append("\", ");
        json.append("\"emissor\": ").append(rs.getInt("emissor")).append(", ");
        json.append("\"chat\": ").append(rs.getInt("chat"));

        json.append("}");
        return json.toString();
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM MensagemComum " + filtro;
    }

    @Override
    protected MensagemComum getClassFromResultSet(ResultSet rs) throws SQLException {
        MensagemComum mensagem = new MensagemComum();
        mensagem.setId(rs.getInt("id"));
        mensagem.setHora(rs.getString("hora"));
        mensagem.setTexto(rs.getString("texto"));
        mensagem.setImagem(rs.getString("imagem"));
        mensagem.setEmissor(rs.getInt("emissor"));
        mensagem.setChat(rs.getInt("chat"));
        return mensagem;
    }
}
