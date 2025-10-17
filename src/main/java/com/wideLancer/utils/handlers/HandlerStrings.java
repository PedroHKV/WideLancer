package com.wideLancer.utils.handlers;

import org.springframework.stereotype.Service;

@Service
public class HandlerStrings {
    
    public String normalizarNomeImagem(String nome){
        String nomeNormalizado = nome;

        nomeNormalizado = nomeNormalizado.replaceAll(" ", "_");
        nomeNormalizado = nomeNormalizado.replaceAll("\\(","");
        nomeNormalizado = nomeNormalizado.replaceAll("\\)","");

        return nomeNormalizado;
    }

}
