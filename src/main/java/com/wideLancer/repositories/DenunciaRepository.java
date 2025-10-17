package com.wideLancer.repositories;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Denuncia;

public class DenunciaRepository extends RepositoryTemplate<Denuncia> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Denuncia(motivo, delator, anuncio, decisao) VALUES (?, ?, ?, 'pendente')";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Denuncia denuncia) throws SQLException {
        stmt.setString(1, denuncia.getMotivo());
        stmt.setInt(2, denuncia.getDelator());
        stmt.setInt(3, denuncia.getAnuncioId());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Denuncia SET motivo = ?, delator = ?, anuncio = ?, decisao = ?, avaliada_por = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Denuncia denuncia) throws SQLException {
        stmt.setString(1, denuncia.getMotivo());
        stmt.setInt(2, denuncia.getDelator());
        stmt.setInt(3, denuncia.getAnuncioId());
        stmt.setString(4, denuncia.getDecisao());
        stmt.setInt(5, denuncia.getAvaliadaPor());
        stmt.setInt(6, denuncia.getId());
    }

    @Override
    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"motivo\": \"").append(rs.getString("motivo")).append("\", ");
        json.append("\"delator\": ").append(rs.getInt("delator")).append(", ");
        json.append("\"anuncio\": ").append(rs.getInt("anuncio")).append(", ");
        json.append("\"decisao\": \"").append(rs.getString("decisao")).append("\", ");
        json.append("\"avaliada_por\": ").append(rs.getInt("avaliada_por"));

        json.append("}");
        return json.toString();
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Denuncia WHERE id = ?";
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Denuncia " + filtro;
    }

    @Override
    protected Denuncia getClassFromResultSet(ResultSet rs) throws SQLException {
        Denuncia denuncia = new Denuncia();
        denuncia.setId(rs.getInt("id"));
        denuncia.setMotivo(rs.getString("motivo"));
        denuncia.setDelator(rs.getInt("delator"));
        denuncia.setAnuncioId(rs.getInt("anuncio"));
        denuncia.setDecisao(rs.getString("decisao"));
        denuncia.setAvaliadaPor(rs.getInt("avaliada_por"));
        return denuncia;
    }
}
