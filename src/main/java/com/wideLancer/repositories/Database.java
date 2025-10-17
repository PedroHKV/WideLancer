package com.wideLancer.repositories;
import java.sql.*;

public class Database {

    private static Database instancia;
    private String url = "jdbc:mysql://127.0.0.1:3306/WideLancer";
    private String usuario = "root";
    private String senha = "";

    // método público estático para obter a instância única: Singleton
    public static synchronized Database getInstance() {
        if (instancia == null) {
            instancia = new Database();
        }
        return instancia;
    }

    public Connection conectarSql() throws SQLException{
        Connection conn = DriverManager.getConnection(url, usuario, senha);
        return conn;
    }

    public boolean executarSql(String comando){
        try{
            Connection conn = DriverManager.getConnection(url, usuario, senha);
            PreparedStatement stmt = conn.prepareStatement(comando);
            int linhasAfetadas = stmt.executeUpdate();
            conn.close();
            return (linhasAfetadas > 0);
        } catch (Exception e){
            System.out.println("_______________FALHA AO EXECUTAR COMANDO SQL____________________");
            e.printStackTrace();
            System.out.println("________________________________________________________________");
            return false;
        }
    }
}
