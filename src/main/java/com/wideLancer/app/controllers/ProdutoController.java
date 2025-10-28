package com.wideLancer.app.controllers;

import java.io.File;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.wideLancer.ConfiguracaoUploads;
import com.wideLancer.models.Produto;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.ProdutoRepository;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;


@Controller
@RequestMapping("/produtos")
public class ProdutoController {
    private final String repositorio = ConfiguracaoUploads.getInstance().getDiretorioProdutos();;
    private final String[] medidas = {" B", " kB", " MB", " GB", " TB"};

    @GetMapping("/pagamento")
    public String fornecerPaginaDePagamento(Model model, HttpSession sessao){
        int produtoId = (int) sessao.getAttribute("idProduto");
        ProdutoRepository repositorioProduto = new ProdutoRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Produto produto = repositorioProduto.findById(produtoId);
            int vendedorId = produto.getEmissor();
            Usuario vendedor = repositorioUsuario.findById(vendedorId);
            String[] tokensProduto = produto.getUrl().split("/");
            String nomeProduto = tokensProduto[tokensProduto.length - 1];
            File produtoFile = new File(repositorio+"/"+nomeProduto);

            long tamanho = produtoFile.length();//em Bytes
            int medidaIndice = 0;
            while (tamanho > 1024) {
                tamanho /= 1024;
                medidaIndice++;
            }
            String tamanhoStr = tamanho+medidas[medidaIndice];


            System.out.println(tamanho);
            model.addAttribute("produto", produto);
            model.addAttribute("vendedor", vendedor);
            model.addAttribute("tamanho", tamanhoStr);
        } catch ( Exception e){
            System.out.println("_______________FALHA AO CARREGAR PRODUTO_____________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }

        return "pagamento.html";
    }
}
