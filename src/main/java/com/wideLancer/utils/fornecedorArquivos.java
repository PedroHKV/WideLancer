package com.wideLancer.utils;

import java.io.File;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.wideLancer.utils.handlers.HandlerStreams;

import org.springframework.web.bind.annotation.GetMapping;

import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@RestController
@RequestMapping("/uploads")
public class fornecedorArquivos{

    @Autowired private HandlerStreams Out;
    private String repositorio = "C:/Users/User/Desktop/WideLancer/uploads/";

    @GetMapping("{nomePasta}/{nomeImagem}")
    public void fornecerImagemRequisitadaDeUploads(HttpServletResponse res, HttpServletRequest req){

        String[] tokensReq = req.getRequestURI().split("/");
        String nomeImagem = tokensReq[tokensReq.length - 1];
        String nomePasta = tokensReq[tokensReq.length - 2] + "/";
        String caminhoParaImagem = repositorio + nomePasta + nomeImagem;
        File img = new File(caminhoParaImagem);
        try{
            Out.enviarImagem(img, res);
        } catch ( Exception e){
            System.out.println("_______________FALHA AO ENVIAR IMAGEM DE UPLOADS_______________");
            e.printStackTrace();
            System.out.println("_______________________________________________________________");
        }
    }

    @GetMapping("/download/{produto}")
    public void fornecerDownloadDeProduto(HttpServletResponse res, HttpServletRequest req){
        String[] httpTkns = req.getRequestURL().toString().split("/");
        String caminho = repositorio+"produtos/"+ httpTkns[ httpTkns.length - 1 ];
        File produto = new File(caminho);

        String range = req.getHeader("Range");
        long length = produto.length();
        long start = 0;
        long end = length - 1;
        if (range != null && range.startsWith("bytes=")) {
            String[] partes = range.replace("bytes=", "").split("-");
            start = Long.parseLong(partes[0]);
            if (partes.length > 1 && !partes[1].isEmpty()) {
                end = Long.parseLong(partes[1]);
            }
        }

        long chunkSize = end - start + 1;

        try{
            Out.enviarDownloadArquivo(produto, res, chunkSize, start, end, length);
        } catch ( Exception e){
            System.out.println("_______________FALHA AO ENVIAR PRODUTO DE UPLOADS_______________");
            e.printStackTrace();
            System.out.println("________________________________________________________________");
        }
    }

}

