package com.wideLancer.abstractions;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.ArrayList;

import com.wideLancer.repositories.Database;

public abstract class RepositoryTemplate<T> {
    protected static Database bd = Database.getInstance();

    public RepositoryTemplate() {
        
    }

    public final boolean cadastrar(T entity) throws SQLException {
        String sql = getInsertionStatement();
        try (Connection conn = bd.conectarSql();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            inserirParametros(stmt, entity);
            int linhasAfetadas = stmt.executeUpdate();
            return linhasAfetadas > 0;
        }
    }

    public final boolean salvarEstadoAtual(T entity) throws SQLException {
        String sql = getUpdateStatement();
        try (Connection conn = bd.conectarSql();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            setUpdateParameters(stmt, entity);
            int linhasAfetadas = stmt.executeUpdate();
            return linhasAfetadas > 0;
        }
    }

    public final T findById(int id) throws SQLException {
        String sql = selectById();
        try (Connection conn = bd.conectarSql();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                return getClassFromResultSet(rs);
            }
        }
        return null;
    }

    public final ArrayList<T> findAll(String filtro) throws SQLException {
        String sql = selectAll(filtro);
        ArrayList<T> list = new ArrayList<>();
        try (Connection conn = bd.conectarSql();
            PreparedStatement stmt = conn.prepareStatement(sql);
            ResultSet rs = stmt.executeQuery()) {
            while (rs.next()) {
                list.add(getClassFromResultSet(rs));
            }
        }
        return list;
    }

    public final String findAllJSON(String filtro) throws SQLException{
        StringBuilder json = new StringBuilder("[");
        String sql = selectAll(filtro);

        try (Connection conn = bd.conectarSql();
             PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            while (rs.next()) {
                String itemJson = toJson(rs);
                json.append(itemJson).append(", ");
            }
        }

        json.append("{} ]");
        return json.toString();
    }

    // Métodos abstratos que as subclasses devem implementar
    protected abstract String getInsertionStatement();
    protected abstract void inserirParametros(PreparedStatement stmt, T entity) throws SQLException;
    protected abstract String getUpdateStatement();
    protected abstract void setUpdateParameters(PreparedStatement stmt, T entity) throws SQLException;
    protected abstract String selectById();
    protected abstract String selectAll(String filtro);
    protected abstract String toJson(ResultSet rs) throws SQLException;
    protected abstract T getClassFromResultSet(ResultSet rs) throws SQLException;
}
