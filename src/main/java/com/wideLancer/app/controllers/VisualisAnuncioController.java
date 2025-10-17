package com.wideLancer.app.controllers;

import java.sql.SQLException;
import java.util.ArrayList;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.wideLancer.abstractions.Mensagem;
import com.wideLancer.models.Anuncio;
import com.wideLancer.models.Chat;
import com.wideLancer.models.Proposta;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.ChatRepository;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;


@Controller
@RequestMapping("/")
public class VisualisAnuncioController {
    
    @GetMapping("/portifolio")
    public String fornecerPaginaDePortifolio(Model model, @RequestParam("email") String email){
        AnuncioRepository repositorio = new AnuncioRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Usuario usuario = repositorioUsuario.findByEmail(email);
            ArrayList<Anuncio> anuncios = repositorio.findAll("WHERE anunciante = "+usuario.getId());
            model.addAttribute("portifolio", usuario);
            model.addAttribute("anuncios", anuncios);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR Portifolio____________________");
            e.printStackTrace();
            System.out.println("_______________________________________________________________");
        }
        return "visualis_portifolio.html";
    }

    //dependendo de quem acessa, a pagina muda, nao so da informação acessada
    //as variaves que envolvem 1 pessoa estao relacionadas a quem acessa
    //as que envolvem terceita pessoa estao relacionadas ao outro usuario
    @GetMapping("/chat")
    public String fornecerPaginaDeChat(Model model, HttpSession sessao ){
        ChatRepository repositorioChat = new ChatRepository();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            //carrega os usuarios: vendedor e cliente, e determina qual deles 'eu' sou
            int idChat = (int) sessao.getAttribute("idChat");
            int meuId = (int) sessao.getAttribute("id");
            Chat chat = repositorioChat.findById(idChat);
            int idVendedor = chat.getVendedor();
            Usuario vendedor = repositorioUsuario.findById(idVendedor);
            Usuario cliente = repositorioUsuario.findById(chat.getCliente());
            boolean souOVendedor = (meuId == idVendedor);
            //carrega todas as mensagens do chat
            ArrayList<Mensagem> mensagens = chat.carregarMensagens();
            //carrega todos os chates onde 'eu' participo, juntando o nome dos 'outros' e os ids deles
            ArrayList<Chat> chatsOndeEuParticipo = repositorioChat.findAll("WHERE cliente = "+meuId+" OR vendedor = "+meuId);
            String[][] outros = new String[chatsOndeEuParticipo.size()][2];
            for (int i = 0 ; i < outros.length ; i++){
                Chat outroChat = chatsOndeEuParticipo.get(i);
                if ( outroChat.getId() != idChat ) { 
                    outros[i][0] = (outroChat.getVendedor() == meuId) ? 
                    repositorioUsuario.findById(outroChat.getCliente()).getNomeCompleto() : repositorioUsuario.findById(outroChat.getVendedor()).getNomeCompleto();
                    outros[i][1] = (outroChat.getVendedor() == meuId) ? outroChat.getCliente()+"" : outroChat.getVendedor()+"";
                }
            }
            if ( souOVendedor ){
                boolean possoFazerNovaProposta = true;
                boolean jaHouveUmaPropostaNesteChat = false;
                boolean possoEntregarProduto;
                boolean haUmaPropostaPendente = false;
                for (Mensagem msg : mensagens){
                    if (msg instanceof Proposta){
                        jaHouveUmaPropostaNesteChat = true;
                        Proposta prop = (Proposta) msg;
                        String aceita = prop.getAceita();
                        if ( !aceita.equals("acabada") && !aceita.equals("recusada") ){
                            possoFazerNovaProposta = false;
                        }
                        if (aceita.equals("pendente")){
                            haUmaPropostaPendente = true;
                        }
                    }
                }
                possoEntregarProduto = !possoFazerNovaProposta && jaHouveUmaPropostaNesteChat && !haUmaPropostaPendente;
                model.addAttribute("possoEntregarProduto", possoEntregarProduto);
                model.addAttribute("possoFazerNovaProposta", possoFazerNovaProposta);
            }

            model.addAttribute("eu", souOVendedor ? vendedor : cliente );
            model.addAttribute("outro", souOVendedor ? cliente : vendedor );
            model.addAttribute("souVendedor", souOVendedor);
            model.addAttribute("meuId", meuId);
            model.addAttribute("mensagens", mensagens);
            model.addAttribute("chats", outros);
            
        } catch (SQLException e){
            System.out.println("_______________FALHA AO RENDERIZAR CHAT____________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }

        return "chat.html";
    }

}
