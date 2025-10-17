package com.wideLancer.app.restcontrollers;

import java.io.File;
import java.sql.SQLIntegrityConstraintViolationException;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;
import com.wideLancer.models.Solicitacao;
import com.wideLancer.repositories.SolicitacaoRepository;
import com.wideLancer.utils.handlers.HandlerStrings;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/solicitacoes")
public class HomeRequisicoes {
    private String repositorio = "C:/Users/User/Desktop/WideLancer/uploads/documentos/";
    private HandlerStrings str = new HandlerStrings();

    @PostMapping("/cadastrar")
    public String cadastrarSolicitacao(
        @RequestParam("cpf") String cpf,
        @RequestParam("pix") String stripeId,
        @RequestParam("foto") MultipartFile foto,
        HttpSession sessao){

        boolean cadastrado = false;
        int idSolicitante = (int) sessao.getAttribute("id");
        String nome = str.normalizarNomeImagem(foto.getOriginalFilename());
        String caminhoParaImagemNoBancoDados = "/uploads/documentos/"+nome;
        String caminhoParaSalvarImagem = repositorio + nome;
        File destino = new File(caminhoParaSalvarImagem);
        Solicitacao solicitacao = new Solicitacao();
        SolicitacaoRepository repositorioSolicitacao = new SolicitacaoRepository();
        
        if (!destino.exists()){
            destino.mkdirs();
        }
        try{
            foto.transferTo(destino);
            solicitacao.setCPF(cpf);
            solicitacao.setSolicitante(idSolicitante);
            solicitacao.setStripeId(stripeId);
            solicitacao.setFoto(caminhoParaImagemNoBancoDados);
            solicitacao.setDecisao("Pendente");
            cadastrado = repositorioSolicitacao.cadastrar(solicitacao);

        } catch(SQLIntegrityConstraintViolationException e){
            return "dup_key";
        } catch (Exception e){
            System.out.println("_______________FALHA AO CADASTRAR SOLICITACAO_______________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }

        if ( cadastrado ){
            return "cadastrado";
        }
        return "falha";
    }
    
}
