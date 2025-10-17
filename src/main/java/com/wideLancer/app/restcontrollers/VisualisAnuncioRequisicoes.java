package com.wideLancer.app.restcontrollers;

import java.util.ArrayList;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import com.wideLancer.models.Chat;
import com.wideLancer.models.Denuncia;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.ChatRepository;
import com.wideLancer.repositories.DenunciaRepository;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/anuncio")
public class VisualisAnuncioRequisicoes {
    
    @PostMapping("/denuncia")
    public String cadastrarDenuncia(@RequestParam("id") int anuncioId, @RequestParam("motivo") String motivo, HttpSession sessao){
        DenunciaRepository repositorioDenuncia = new DenunciaRepository();
        int idDelator = (int) sessao.getAttribute("id");
        Denuncia denuncia = new Denuncia();
        denuncia.setAnuncioId(anuncioId);
        denuncia.setMotivo(motivo);
        denuncia.setDelator(idDelator);

        try{
            repositorioDenuncia.cadastrar(denuncia);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CADASTRAR ANUNCIO______________________");
            e.printStackTrace();
            System.out.println("_______________________________________________________________");
            return "falha";
        }

        return "cadastrado";
    }

    @PostMapping("defChat")
    public String definirChat( HttpSession sessao, @RequestParam("idAnuncio") int idAnuncio ){
        AnuncioRepository repositorioAnuncio = new AnuncioRepository();
        ChatRepository repositorioChat = new ChatRepository();
        try{
            int idCliente = (int) sessao.getAttribute("id");
            int idVendedor = repositorioAnuncio.findById(idAnuncio).getAnunciante();
            
            ArrayList<Chat> chatsComEstesParticipantes = repositorioChat.findAll("WHERE cliente = "+idCliente+" AND vendedor = "+idVendedor);
            int numeroDeChatsComEstesParticipantes = chatsComEstesParticipantes.size();
            if (numeroDeChatsComEstesParticipantes == 0){
                Chat novoChat = new Chat();
                novoChat.setCliente(idCliente);
                novoChat.setVendedor(idVendedor);
                repositorioChat.cadastrar(novoChat);
                chatsComEstesParticipantes = repositorioChat.findAll("WHERE cliente = "+idCliente+" AND vendedor = "+idVendedor);
            }
            Chat chat = chatsComEstesParticipantes.get(0);
            sessao.setAttribute("idChat", chat.getId());
            
        } catch (Exception e){
            System.out.println("______________FALHA AO DEFINIR SESSAO PARA CHAT_____________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
            return "falha";
        }
        return "sucesso";
    }

}
