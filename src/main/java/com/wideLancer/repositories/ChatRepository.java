package com.wideLancer.repositories;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

import com.wideLancer.abstractions.Mensagem;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Chat;
import com.wideLancer.models.MensagemComum;
import com.wideLancer.models.Proposta;

public class ChatRepository extends RepositoryTemplate<Chat> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Chat(vendedor, cliente, ativo) VALUES (?, ?, 1)";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Chat chat) throws SQLException {
        stmt.setInt(1, chat.getVendedor());
        stmt.setInt(2, chat.getCliente());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Chat SET vendedor = ?, cliente = ?, ativo = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Chat chat) throws SQLException {
        stmt.setInt(1, chat.getVendedor());
        stmt.setInt(2, chat.getCliente());
        stmt.setBoolean(3, chat.getAtivo());
        stmt.setInt(4, chat.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Chat WHERE id = ?";
    }

    @Override
    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"vendedor\": ").append(rs.getInt("vendedor")).append(", ");
        json.append("\"cliente\": ").append(rs.getInt("cliente")).append(", ");
        json.append("\"ativo\": ").append(rs.getBoolean("ativo"));

        json.append("}");
        return json.toString();
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM Chat " + filtro;
    }

    @Override
    protected Chat getClassFromResultSet(ResultSet rs) throws SQLException {
        Chat chat = new Chat();
        chat.setId(rs.getInt("id"));
        chat.setVendedor(rs.getInt("vendedor"));
        chat.setCliente(rs.getInt("cliente"));
        chat.setAtivo(rs.getBoolean("ativo"));
        return chat;
    }

    public ArrayList<Mensagem> carregarMensagensDe(Chat chat){
        ArrayList<Mensagem> mensagens = new ArrayList<>();
        Database bd = Database.getInstance();
        String sql = "SELECT *, " +
             "CASE " +
             "WHEN tipo COLLATE utf8mb4_unicode_ci = 'MensagemComum' THEN mc_hora " +
             "WHEN tipo COLLATE utf8mb4_unicode_ci = 'Proposta' THEN p_hora " +
             "END AS hora_ordenacao " +
             "FROM Mensagens " +
             "WHERE chat_id = ? " +
             "ORDER BY hora_ordenacao ASC";

        

        try (Connection conn = bd.conectarSql();
            PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setInt(1, chat.getId());
            try (ResultSet rs = stmt.executeQuery()) {
                while (rs.next()) {
                    String tipo = rs.getString("tipo");
                    if ("MensagemComum".equals(tipo)) {
                        MensagemComum m = new MensagemComum();
                        m.setId(rs.getInt("mc_id"));
                        m.setChat(rs.getInt("mc_chat"));
                        m.setEmissor(rs.getInt("mc_emissor"));
                        m.setHora(rs.getString("mc_hora"));
                        m.setTexto(rs.getString("mc_texto"));
                        m.setImagem(rs.getString("mc_imagem"));
                        mensagens.add(m);
                    } else if ("Proposta".equals(tipo)) {
                        Proposta p = new Proposta();
                        p.setId(rs.getInt("p_id"));
                        p.setChat(rs.getInt("p_chat"));
                        p.setHora(rs.getString("p_hora"));
                        p.setAceita(rs.getString("p_aceita"));
                        p.setOrcamento(rs.getDouble("p_orcamento"));
                        p.setPrazo(rs.getString("p_prazo"));
                        mensagens.add(p);
                    }
                }
            }
        } catch (SQLException e) {
            System.out.println("Erro ao carregar mensagens do chat: " + chat.getId());
            e.printStackTrace();
        }
        return mensagens;
    }
}
