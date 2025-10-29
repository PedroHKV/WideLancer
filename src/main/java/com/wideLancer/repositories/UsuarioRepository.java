package com.wideLancer.repositories;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Usuario;

public class UsuarioRepository extends RepositoryTemplate<Usuario> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Usuario(nome, sobrenome, email, senha, vendedor, curador, foto, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Usuario usuario) throws SQLException {
        stmt.setString(1, usuario.getNome());
        stmt.setString(2, usuario.getSobrenome());
        stmt.setString(3, usuario.getEmail());
        stmt.setString(4, usuario.getSenha());
        stmt.setBoolean(5, false); // vendedor default
        stmt.setBoolean(6, false); // curador default
        stmt.setString(7, "images/usuario_icone.png"); // foto default
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Usuario SET cpf = ?, stripeid = ?, foto = ?, nome = ?, sobrenome = ?, email = ?, senha = ?, ativo = ?, curador = ?, vendedor = ?, titulo_portifolio = ?, descricao_portifolio = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Usuario usuario) throws SQLException {
        stmt.setString(1, usuario.getCpf());
        stmt.setString(2, usuario.getStripeId());
        stmt.setString(3, usuario.getFoto());
        stmt.setString(4, usuario.getNome());
        stmt.setString(5, usuario.getSobrenome());
        stmt.setString(6, usuario.getEmail());
        stmt.setString(7, usuario.getSenha());
        stmt.setBoolean(8, usuario.isAtivo());
        stmt.setBoolean(9, usuario.isCurador());
        stmt.setBoolean(10, usuario.isVendedor());
        stmt.setString(11, usuario.getTituloPortifolio());
        stmt.setString(12, usuario.getDescricaoPortifolio());
        stmt.setInt(13, usuario.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Usuario WHERE id = ?";
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Usuario " + filtro;
    }

    @Override
    protected Usuario getClassFromResultSet(ResultSet rs) throws SQLException {
        Usuario usuario = new Usuario();
        usuario.setId(rs.getInt("id"));
        usuario.setNome(rs.getString("nome"));
        usuario.setSobrenome(rs.getString("sobrenome"));
        usuario.setEmail(rs.getString("email"));
        usuario.setSenha(rs.getString("senha"));
        usuario.setCpf(rs.getString("cpf"));
        usuario.setStripeId(rs.getString("stripeid"));
        usuario.setCurador(rs.getBoolean("curador"));
        usuario.setVendedor(rs.getBoolean("vendedor"));
        usuario.setFoto(rs.getString("foto"));
        usuario.setAtivo(rs.getBoolean("ativo"));
        usuario.setTituloPortifolio(rs.getString("titulo_portifolio"));
        usuario.setDescricaoPortifolio(rs.getString("descricao_portifolio"));
        return usuario;
    }

    @Override
    protected String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"nome\": \"").append(rs.getString("nome")).append("\", ");
        json.append("\"sobrenome\": \"").append(rs.getString("sobrenome")).append("\", ");
        json.append("\"email\": \"").append(rs.getString("email")).append("\", ");
        json.append("\"senha\": \"").append(rs.getString("senha")).append("\", ");
        json.append("\"cpf\": \"").append(rs.getString("cpf")).append("\", ");
        json.append("\"stripeid\": \"").append(rs.getString("stripeid")).append("\", ");
        json.append("\"curador\": ").append(rs.getBoolean("curador")).append(", ");
        json.append("\"vendedor\": ").append(rs.getBoolean("vendedor")).append(", ");
        json.append("\"foto\": \"").append(rs.getString("foto")).append("\", ");
        json.append("\"ativo\": ").append(rs.getBoolean("ativo")).append(", ");
        json.append("\"titulo_portifolio\": \"").append(rs.getString("titulo_portifolio")).append("\", ");
        json.append("\"descricao_portifolio\": \"").append(rs.getString("descricao_portifolio")).append("\"");

        json.append("}");
        return json.toString();
    }


    // método específico
    public Usuario findByEmail(String email) throws SQLException {
        Usuario usuario = new Usuario();
        String sql = "SELECT * FROM Usuario WHERE email = ?";
        try (Connection conn = bd.conectarSql(); PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, email);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                usuario = getClassFromResultSet(rs);
            }
        }
        return usuario;
    }
}
