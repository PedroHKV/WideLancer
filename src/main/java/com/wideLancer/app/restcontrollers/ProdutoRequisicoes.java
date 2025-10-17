package com.wideLancer.app.restcontrollers;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/produtos")
public class ProdutoRequisicoes {
    
    @PostMapping("/defProduto")
    public String definirProduto(@RequestParam("idProduto") int idProduto, HttpSession sessao){
        sessao.setAttribute("idProduto", idProduto);
        return "sucesso";
    }
}
