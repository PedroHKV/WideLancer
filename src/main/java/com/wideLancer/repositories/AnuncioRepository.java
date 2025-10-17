package com.wideLancer.repositories;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Anuncio;

public class AnuncioRepository extends RepositoryTemplate<Anuncio> {

    public AnuncioRepository() {
        super();
    }

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Anuncio(titulo, descricao, foto, anunciante, ativo) VALUES (?, ?, ?, ?, 1)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Anuncio anuncio) throws SQLException {
        stmt.setString(1, anuncio.getTitulo());
        stmt.setString(2, anuncio.getDescricao());
        stmt.setString(3, anuncio.getFoto());
        stmt.setInt(4, anuncio.getAnunciante());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Anuncio SET titulo = ?, descricao = ?, foto = ?, anunciante = ?, ativo = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Anuncio anuncio) throws SQLException {
        stmt.setString(1, anuncio.getTitulo());
        stmt.setString(2, anuncio.getDescricao());
        stmt.setString(3, anuncio.getFoto());
        stmt.setInt(4, anuncio.getAnunciante());
        stmt.setBoolean(5, anuncio.isAtivo());
        stmt.setInt(6, anuncio.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Anuncio WHERE id = ?";
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Anuncio " + filtro;
    }

    @Override
    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"titulo\": \"").append(rs.getString("titulo")).append("\", ");
        json.append("\"descricao\": \"").append(rs.getString("descricao")).append("\", ");
        json.append("\"foto\": \"").append(rs.getString("foto")).append("\", ");
        json.append("\"anunciante\": ").append(rs.getInt("anunciante")).append(", ");
        json.append("\"ativo\": ").append(rs.getBoolean("ativo"));

        json.append("}");
        return json.toString();
    }

    @Override
    protected Anuncio getClassFromResultSet(ResultSet rs) throws SQLException {
        Anuncio anuncio = new Anuncio();
        anuncio.setId(rs.getInt("id"));
        anuncio.setTitulo(rs.getString("titulo"));
        anuncio.setDescricao(rs.getString("descricao"));
        anuncio.setFoto(rs.getString("foto"));
        anuncio.setAnunciante(rs.getInt("anunciante"));
        anuncio.setAtivo(rs.getBoolean("ativo"));
        return anuncio;
    }

    // método específico, fora do template
    public ArrayList<Anuncio> findAllByQuery(String query) throws SQLException {
        ArrayList<Anuncio> anuncios = new ArrayList<>();
        String[] tokens = query.split("_");
        if (tokens.length == 0) return anuncios;

        String sqlBase = "SELECT * FROM Anuncio WHERE ";
        for (int i = 0; i < tokens.length - 1; i++) {
            sqlBase += "(titulo LIKE ?) OR ";
        }
        sqlBase += "(titulo LIKE ?)"; // último token

        try (Connection conn = bd.conectarSql();
             PreparedStatement stmt = conn.prepareStatement(sqlBase)) {

            for (int i = 1; i <= tokens.length; i++) {
                stmt.setString(i, "%" + tokens[i - 1] + "%");
            }

            ResultSet resultado = stmt.executeQuery();
            while (resultado.next()) {
                Anuncio anuncio = getClassFromResultSet(resultado);
                if (anuncio.isAtivo()) {
                    anuncios.add(anuncio);
                }
            }
        }
        return anuncios;
    }
}
