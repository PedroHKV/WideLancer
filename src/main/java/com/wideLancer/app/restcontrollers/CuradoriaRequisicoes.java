package com.wideLancer.app.restcontrollers;

import java.sql.SQLException;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.wideLancer.models.Anuncio;
import com.wideLancer.models.Denuncia;
import com.wideLancer.models.Solicitacao;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.DenunciaRepository;
import com.wideLancer.repositories.SolicitacaoRepository;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/curadoria")
public class CuradoriaRequisicoes {
    
    @GetMapping("/solicitacoes")
    public String fornecerSolicitacoes(){
        String jsonSolicitacoes = "[]";
        SolicitacaoRepository repositorioSolicitacao = new SolicitacaoRepository();
        try{
            jsonSolicitacoes = repositorioSolicitacao.findAllJSON("");
        }catch (Exception e){
            System.out.println("_______________FALHA AO CONSULTAR SOLICITACOES_______________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }
        return jsonSolicitacoes;
    }

    @GetMapping("/fornecedores")
    public String fornecerListaDeFornecedores(){
        String jsonFornecedores = "[]";
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            jsonFornecedores = repositorioUsuario.findAllJSON("WHERE vendedor = 1");
        } catch ( Exception e ){
            System.out.println("_______________FALHA AO LISTAR FORNECEDORES__________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }

        return jsonFornecedores;
    }

    @GetMapping("/curadores")
    public String fornecerListaDeCuradores(){
        String jsonFornecedores = "[]";
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            jsonFornecedores = repositorioUsuario.findAllJSON("WHERE curador = 1");
        } catch ( Exception e ){
            System.out.println("_______________FALHA AO LISTAR CURADORES____________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }

        return jsonFornecedores;
    }

    @GetMapping("/clientes")
    public String fornecerListaDeClientes(){
        String jsonFornecedores = "[]";
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            jsonFornecedores = repositorioUsuario.findAllJSON("WHERE curador = 0 AND vendedor = 0");
        } catch ( Exception e ){
            System.out.println("_______________FALHA AO LISTAR CLIENTES______________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }

        return jsonFornecedores;
    }

    @GetMapping("/denuncias")
    public String fornecerListaDeDenuncias(){
        String jsonDenuncias = "[]";
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        try{
            jsonDenuncias = repositorioDenuncia.findAllJSON("");
        } catch ( Exception e ){
            System.out.println("_______________FALHA AO LISTAR Denuncias_____________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
        }
        return jsonDenuncias;
    }

    @PostMapping("/visual_solic")
    public String salvarIdDeSolicitacao(HttpSession sessao , @RequestParam("solicitacao_id") String idSolicitacao){
        sessao.setAttribute("idSolicitacao", idSolicitacao);
        return "sucesso";
    }

    @GetMapping("/aceitar")
    public String aceitarSolicitacao(HttpSession sessao){
        SolicitacaoRepository repositorioSolicitacao = new SolicitacaoRepository();
        int idSolicitacao = Integer.parseInt( (String) sessao.getAttribute("idSolicitacao"));
        int idCuradorQueRespondeu = (int) sessao.getAttribute("id");
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Solicitacao solicitacao = repositorioSolicitacao.findById(idSolicitacao);
            int idSolicitante = solicitacao.getSolicitante();
            Usuario solicitante = repositorioUsuario.findById(idSolicitante);

            solicitacao.setDecisao("aceita");
            solicitacao.setRespondidaPor(idCuradorQueRespondeu);
            solicitante.setVendedor(true);
            solicitante.setCpf(solicitacao.getCpf());
            solicitante.setStripeId(solicitacao.getStripeId());
            repositorioSolicitacao.salvarEstadoAtual(solicitacao);
            repositorioUsuario.salvarEstadoAtual(solicitante);
        } catch (Exception e){
            System.out.println("_______________FALHA AO ACEITAR SOLICITACAO__________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }

        return "sucesso";
    }

    @GetMapping("/recusar")
    public String recusarSolicitacao(HttpSession sessao){
        SolicitacaoRepository repositorioSolicitacao = new SolicitacaoRepository();
        int idSolicitacao = Integer.parseInt( (String) sessao.getAttribute("idSolicitacao"));
        int idCuradorQueRespondeu = (int) sessao.getAttribute("id");
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Solicitacao solicitacao = repositorioSolicitacao.findById(idSolicitacao);
            int idSolicitante = solicitacao.getSolicitante();
            Usuario solicitante = repositorioUsuario.findById(idSolicitante);

            solicitacao.setDecisao("recusada");
            solicitacao.setRespondidaPor(idCuradorQueRespondeu);
            solicitante.setVendedor(false);
            repositorioSolicitacao.salvarEstadoAtual(solicitacao);
            repositorioUsuario.salvarEstadoAtual(solicitante);
        } catch (Exception e){
            System.out.println("_______________FALHA AO RECUSAR SOLICITACAO__________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }

        
        return "sucesso";
    }

    @PostMapping("defDenuncia")
    public String salvarIdDaDenuncia(@RequestParam("denuncia_id") int idDenuncia, HttpSession sessao){
        sessao.setAttribute("idDenuncia", idDenuncia);
        return "sucesso";
    }

    @GetMapping("/ignorarDenuncia")
    public String ignorarDenuncia(HttpSession sessao){
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        int idDenuncia = (int) sessao.getAttribute("idDenuncia");
        int idCurador = (int) sessao.getAttribute("id");
        try{
            Denuncia denuncia = repositorioDenuncia.findById(idDenuncia);
            denuncia.setDecisao("ignorada");
            denuncia.setAvaliadaPor(idCurador);
            repositorioDenuncia.salvarEstadoAtual(denuncia);
        } catch (SQLException e){
            System.out.println("_______________FALHA AO IGNORAR DENUNCIA_____________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }

        return "sucesso";
    }

    @GetMapping("/excluirAnuncio")
    public String excluirAnuncio(HttpSession sessao){
        int idDenuncia = (int) sessao.getAttribute("idDenuncia");
        int idCurador = (int) sessao.getAttribute("id");
        AnuncioRepository repositorioAnuncio = new AnuncioRepository();
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        try{
            Denuncia denuncia = repositorioDenuncia.findById(idDenuncia);
            Anuncio anuncio = repositorioAnuncio.findById(denuncia.getAnuncioId());
            anuncio.setAtivo(false);
            denuncia.setAvaliadaPor(idCurador);
            denuncia.setDecisao("anuncio_banido");
            repositorioAnuncio.salvarEstadoAtual(anuncio);
            repositorioDenuncia.salvarEstadoAtual(denuncia);
        }  catch (SQLException e){
            System.out.println("_______________FALHA AO EXCLUIR ANUNCIO______________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }
        return "sucesso";
    }

    @GetMapping("/banirVendedor")
    public String banirVendedor(HttpSession sessao){
        int idDenuncia = (int) sessao.getAttribute("idDenuncia");
        int idCurador = (int) sessao.getAttribute("id");
        AnuncioRepository repositorioAnuncio = new AnuncioRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        try{
            Denuncia denuncia = repositorioDenuncia.findById(idDenuncia);
            Anuncio anuncio = repositorioAnuncio.findById(denuncia.getAnuncioId());
            Usuario vendedor = repositorioUsuario.findById(anuncio.getAnunciante());
            vendedor.setAtivo(false);
            denuncia.setDecisao("vendedor_banido");
            denuncia.setAvaliadaPor(idCurador);
            repositorioUsuario.salvarEstadoAtual(vendedor);
            repositorioDenuncia.salvarEstadoAtual(denuncia);
        } catch (Exception e){
            System.out.println("_______________FALHA AO BANIR VENDEDOR_______________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }

        return "sucesso";
    }

}
