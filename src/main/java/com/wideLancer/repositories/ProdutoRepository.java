package com.wideLancer.repositories;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Produto;

public class ProdutoRepository extends RepositoryTemplate<Produto> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Produto(urlProduto, entrega, dono, emissor, pago, preco) VALUES (?, NOW(), ?, ?, 0, ?)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Produto produto) throws SQLException {
        stmt.setString(1, produto.getUrl());
        stmt.setInt(2, produto.getDono());
        stmt.setInt(3, produto.getEmissor());
        stmt.setDouble(4, produto.getPreco());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Produto SET urlProduto = ?, entrega = ?, dono = ?, emissor = ?, pago = ?, preco = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Produto produto) throws SQLException {
        stmt.setString(1, produto.getUrl());
        stmt.setString(2, produto.getHoraEntrega());
        stmt.setInt(3, produto.getDono());
        stmt.setInt(4, produto.getEmissor());
        stmt.setBoolean(5, produto.getPago());
        stmt.setDouble(6, produto.getPreco());
        stmt.setInt(7, produto.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Produto WHERE id = ?";
    }

    @Override
    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"urlProduto\": \"").append(rs.getString("urlProduto")).append("\", ");
        json.append("\"entrega\": \"").append(rs.getString("entrega")).append("\", ");
        json.append("\"dono\": ").append(rs.getInt("dono")).append(", ");
        json.append("\"emissor\": ").append(rs.getInt("emissor")).append(", ");
        json.append("\"pago\": ").append(rs.getBoolean("pago")).append(", ");
        json.append("\"preco\": ").append(rs.getDouble("preco"));

        json.append("}");
        return json.toString();
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Produto " + filtro;
    }

    @Override
    protected Produto getClassFromResultSet(ResultSet rs) throws SQLException {
        Produto produto = new Produto();
        produto.setId(rs.getInt("id"));
        produto.setUrl(rs.getString("urlProduto"));
        produto.setDono(rs.getInt("dono"));
        produto.setEmissor(rs.getInt("emissor"));
        produto.setHoraEntrega(rs.getString("entrega"));
        produto.setPago(rs.getBoolean("pago"));
        produto.setPreco(rs.getDouble("preco"));
        return produto;
    }
}
