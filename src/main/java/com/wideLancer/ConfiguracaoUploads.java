 package com.wideLancer;

import java.io.File;

public class ConfiguracaoUploads{
    private static ConfiguracaoUploads instancia;

    private final String diretorioDocumentos = "C:/Users/User/Desktop/WideLancer/uploads/documentos/" ;
    private final String diretorioAnuncios = "C:/Users/User/Desktop/WideLancer/uploads/anuncios/" ;
    private final String diretorioProdutos = "C:/Users/User/Desktop/WideLancer/uploads/produtos" ;
    private final String diretorioPerfis = "C:/Users/User/Desktop/WideLancer/uploads/perfis/" ;

    public static ConfiguracaoUploads getInstance(){
      if (instancia == null){
         instancia = new ConfiguracaoUploads();
      }
      return instancia;
    }

    public void criarRepositorioUploads(){
      try{
         File[] dirs = {
            new File(diretorioDocumentos),
            new File(diretorioAnuncios), 
            new File(diretorioProdutos), 
            new File(diretorioPerfis)
         };

         for (File dir : dirs)
            if (!dir.exists())
               dir.mkdirs();

      } catch (Exception e){
         System.out.println("_______________FALHA AO INICIALIZAR REPOSITORIOS DE UPLOADS____________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________________________");
      }
    }

    public String getDiretorioDocumentos(){
      return diretorioDocumentos;
    }

    public String getDiretorioProdutos(){
      return diretorioProdutos;
    }

    public String getDiretorioAnuncios(){
      return diretorioAnuncios;
    }

    public String getDiretorioPerfis(){
      return diretorioPerfis;
    }

 }