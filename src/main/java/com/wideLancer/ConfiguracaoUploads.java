 package com.wideLancer;

import java.io.File;

public class ConfiguracaoUploads{
    private static ConfiguracaoUploads instancia;

    private final String baseDir = System.getProperty("user.home") + File.separator + "Desktop" + File.separator + "WideLancer" + File.separator + "uploads";

    private final String diretorioDocumentos = baseDir + File.separator + "documentos" + File.separator;
    private final String diretorioAnuncios   = baseDir + File.separator + "anuncios" + File.separator;
    private final String diretorioProdutos   = baseDir + File.separator + "produtos" + File.separator;
    private final String diretorioPerfis     = baseDir + File.separator + "perfis" + File.separator;

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