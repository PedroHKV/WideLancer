package com.wideLancer.app.controllers;

import java.sql.SQLException;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.wideLancer.models.Anuncio;
import com.wideLancer.models.Denuncia;
import com.wideLancer.models.Solicitacao;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.DenunciaRepository;
import com.wideLancer.repositories.SolicitacaoRepository;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;

@Controller
@RequestMapping("/curadoria")
public class CuradoriaController {
    
    @GetMapping("/solicitacao")
    public String fornecerPaginaDeVisualisacaoDeSolicitacao(Model model, HttpSession session){
        int idSolicitacao = Integer.parseInt( (String) session.getAttribute("idSolicitacao") );
        SolicitacaoRepository repositorioSolicitacao = new SolicitacaoRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Solicitacao solicitacao = repositorioSolicitacao.findById(idSolicitacao);
            int idSolicitante = solicitacao.getSolicitante();
            Usuario solicitante = repositorioUsuario.findById(idSolicitante); 
            model.addAttribute("solicitante", solicitante);
            model.addAttribute("solicitacao", solicitacao);

            if (!solicitacao.getDecisao().equals("pendente")){
                Usuario quemRespondeuASolicitacao = repositorioUsuario.findById(solicitacao.getRespondidaPor());
                String nomeDeQuemRespondeu = quemRespondeuASolicitacao.getNome()+" "+quemRespondeuASolicitacao.getSobrenome();
                String statusSolicitacao = "esta solicitacao foi "+solicitacao.getDecisao()+" por "+nomeDeQuemRespondeu+ " em:\n "+solicitacao.getRespondidaEm();
                model.addAttribute("status", statusSolicitacao);
            }
        } catch ( SQLException e ){
            System.out.println("_______________FALHA AO CARREGAR SOLICITACAO_______________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }
        
        return "visual_solic.html";
    }

    @GetMapping("/denuncia")
    public String fornecerPaginaDeVisualisacaoDeDenuncia(Model model, HttpSession sessao){
        int idDenuncia = (int) sessao.getAttribute("idDenuncia");
        AnuncioRepository repositorioAnuncio = new AnuncioRepository();
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Denuncia denuncia = repositorioDenuncia.findById(idDenuncia);
            int anuncioId = denuncia.getAnuncioId();
            Anuncio anuncio = repositorioAnuncio.findById(anuncioId);
            Usuario delator = repositorioUsuario.findById(denuncia.getDelator());
            Usuario anunciante = repositorioUsuario.findById(anuncio.getAnunciante());
            int quantosDenunciaramOAnuncio = repositorioDenuncia.findAll("WHERE anuncio = "+anuncioId).size();

            model.addAttribute("denuncia", denuncia);
            model.addAttribute("anuncio", anuncio);
            model.addAttribute("delator", delator);
            model.addAttribute("anunciante", anunciante);
            model.addAttribute("numDenuncias", quantosDenunciaramOAnuncio);

            String decisao = denuncia.getDecisao();
            if (!decisao.equals("pendente")){
                String decisaoTh = "";
                Usuario avaliador = repositorioUsuario.findById(denuncia.getAvaliadaPor());
                if (decisao.equals("ignorada")){
                    decisaoTh = "esta denuncia foi ignorada por "+avaliador.getEmail();
                } else if (decisao.equals("anuncio_banido")){
                    decisaoTh = "o anuncio desta denuncia foi banido por "+avaliador.getEmail();
                } else if ( decisao.equals("vendedor_banido")){
                    decisaoTh = "este vendedor foi banido por "+avaliador.getEmail();
                }

                model.addAttribute("decisao", decisaoTh );
            }
            } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR DENUNCIA___________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }

        return "visual_denuncia.html";
    }
}
