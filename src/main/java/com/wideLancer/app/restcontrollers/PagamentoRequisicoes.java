package com.wideLancer.app.restcontrollers;

import java.sql.SQLException;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import com.wideLancer.abstractions.PagamentoStrategy;
import com.wideLancer.models.Produto;
import com.wideLancer.repositories.ProdutoRepository;
import com.wideLancer.utils.pagamentos.PagamentoStrategyFactory;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/pagamento")
public class PagamentoRequisicoes {

    private final ProdutoRepository produtoRepository = new ProdutoRepository();
    
    @PostMapping("/receberPagamento")
    public String registrarPagamentoDeProduto(
        @RequestParam("tipo") String tipo, // "cartao", "pix" ou "boleto"
        @RequestParam("pagamento_id") String pagamentoId,
        @RequestParam(value = "vendedor_id") String vendedorStripeId,
        HttpSession sessao
    ) {
        int produtoId = (int) sessao.getAttribute("idProduto");
        Produto produto;

        try {
            produto = produtoRepository.findById(produtoId);
            double preco = produto.getPreco();
            PagamentoStrategy pagamento = PagamentoStrategyFactory.criar(tipo, pagamentoId, vendedorStripeId);
            boolean sucesso = pagamento.pagar(preco, produto);
            if (sucesso) {
                produto.setPago(true);
                produtoRepository.salvarEstadoAtual(produto);

                return "sucesso";
            } else {
                return "falha pagamento";
            }

        } catch (SQLException e) {
            System.out.println("_______________FALHA AO REGISTRAR PAGAMENTO DE PRODUTO_____________________");
            e.printStackTrace();
            System.out.println("___________________________________________________________________________");
            return "falha sql";
            
        }
    }
}
