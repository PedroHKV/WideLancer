package com.wideLancer.repositories;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Proposta;

public class PropostaRepository extends RepositoryTemplate<Proposta> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Proposta(hora, aceita, prazo, chat, orcamento) VALUES (NOW(), 'pendente', ?, ?, ?)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Proposta proposta) throws SQLException {
        stmt.setString(1, proposta.getPrazo());
        stmt.setInt(2, proposta.getChat());
        stmt.setDouble(3, proposta.getOrcamento());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Proposta SET aceita = ?, prazo = ?, orcamento = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Proposta proposta) throws SQLException {
        stmt.setString(1, proposta.getAceita());
        stmt.setString(2, proposta.getPrazo());
        stmt.setDouble(3, proposta.getOrcamento());
        stmt.setInt(4, proposta.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Proposta WHERE id = ?";
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Proposta " + filtro;
    }
    
    @Override
    public String toJson(ResultSet rs) throws SQLException {
    StringBuilder json = new StringBuilder("{");

    json.append("\"id\": ").append(rs.getInt("id")).append(", ");
    json.append("\"hora\": \"").append(rs.getString("hora")).append("\", ");
    json.append("\"aceita\": \"").append(rs.getString("aceita")).append("\", ");
    json.append("\"prazo\": \"").append(rs.getString("prazo")).append("\", ");
    json.append("\"chat\": ").append(rs.getInt("chat")).append(", ");
    json.append("\"orcamento\": ").append(rs.getDouble("orcamento"));

    json.append("}");
    return json.toString();
}

    @Override
    protected Proposta getClassFromResultSet(ResultSet rs) throws SQLException {
        Proposta proposta = new Proposta();
        proposta.setId(rs.getInt("id"));
        proposta.setChat(rs.getInt("chat"));
        proposta.setHora(rs.getString("hora"));
        proposta.setAceita(rs.getString("aceita"));
        proposta.setOrcamento(rs.getDouble("orcamento"));
        proposta.setPrazo(rs.getString("prazo"));
        return proposta;
    }
}
