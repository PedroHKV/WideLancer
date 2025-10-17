package com.wideLancer.repositories;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import com.wideLancer.abstractions.RepositoryTemplate;
import com.wideLancer.models.Solicitacao;

public class SolicitacaoRepository extends RepositoryTemplate<Solicitacao> {

    @Override
    protected String getInsertionStatement() {
        return "INSERT INTO Solicitacao(cpf, stripeId, foto, solicitante, feita_em, decisao) VALUES (?, ?, ?, ?, NOW(), 'pendente')";
    }

    @Override
    protected void inserirParametros(PreparedStatement stmt, Solicitacao solicitacao) throws SQLException {
        stmt.setString(1, solicitacao.getCpf());
        stmt.setString(2, solicitacao.getStripeId());
        stmt.setString(3, solicitacao.getFoto());
        stmt.setInt(4, solicitacao.getSolicitante());
    }

    @Override
    protected String getUpdateStatement() {
        return "UPDATE Solicitacao SET cpf = ?, stripeid = ?, foto = ?, solicitante = ?, feita_em = ?, decisao = ?, respondida_em = NOW(), respondida_por = ? WHERE id = ?";
    }

    @Override
    protected void setUpdateParameters(PreparedStatement stmt, Solicitacao solicitacao) throws SQLException {
        stmt.setString(1, solicitacao.getCpf());
        stmt.setString(2, solicitacao.getStripeId());
        stmt.setString(3, solicitacao.getFoto());
        stmt.setInt(4, solicitacao.getSolicitante());
        stmt.setString(5, solicitacao.getFeita_em());
        stmt.setString(6, solicitacao.getDecisao());
        stmt.setInt(7, solicitacao.getRespondidaPor());
        stmt.setInt(8, solicitacao.getId());
    }

    @Override
    protected String selectById() {
        return "SELECT * FROM Solicitacao WHERE id = ?";
    }

    @Override
    protected String selectAll(String filtro) {
        return "SELECT * FROM SolicitacoesUsuarios " + filtro;
    }

    @Override
    protected Solicitacao getClassFromResultSet(ResultSet rs) throws SQLException {
        Solicitacao s = new Solicitacao();
        s.setId(rs.getInt("id"));
        s.setCPF(rs.getString("cpf"));
        s.setStripeId(rs.getString("stripeid"));
        s.setFoto(rs.getString("foto"));
        s.setSolicitante(rs.getInt("solicitante"));
        s.setFeita_em(rs.getString("feita_em"));
        s.setRespondidaEm(rs.getString("respondida_em"));
        s.setRespondidaPor(rs.getInt("respondida_por"));
        s.setDecisao(rs.getString("decisao"));
        return s;
    }

    public String toJson(ResultSet rs) throws SQLException {
        StringBuilder json = new StringBuilder("{");

        json.append("\"id\": ").append(rs.getInt("id")).append(", ");
        json.append("\"cpf\": \"").append(rs.getString("cpf")).append("\", ");
        json.append("\"stripeid\": \"").append(rs.getString("stripeid")).append("\", ");
        json.append("\"foto\": \"").append(rs.getString("foto")).append("\", ");
        json.append("\"solicitanteid\": ").append(rs.getInt("solicitante")).append(", ");
        json.append("\"feita_em\": \"").append(rs.getString("feita_em")).append("\", ");
        json.append("\"respondida_em\": \"").append(rs.getString("respondida_em")).append("\", ");
        json.append("\"respondida_por\": ").append(rs.getInt("respondida_por")).append(", ");
        json.append("\"decisao\": \"").append(rs.getString("decisao")).append("\", ");
        json.append("\"solicitante_nome\": \"").append(rs.getString("nome")).append("\"");

        json.append("}");
        return json.toString();
    }


    // método específico
    public Solicitacao findBySolicitante(int solicitanteId) throws SQLException {
        String sql = "SELECT * FROM Solicitacao WHERE solicitante = ?";
        Solicitacao solicitacao = new Solicitacao();
        try (Connection conn = bd.conectarSql();
            PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, solicitanteId);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                solicitacao = getClassFromResultSet(rs);
            }
        }
        return solicitacao;
    }
}
