package com.wideLancer.app.restcontrollers;

import java.io.File;
import java.util.ArrayList;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

import com.wideLancer.abstractions.Mensagem;
import com.wideLancer.models.Chat;
import com.wideLancer.models.MensagemComum;
import com.wideLancer.models.Produto;
import com.wideLancer.models.Proposta;
import com.wideLancer.repositories.ChatRepository;
import com.wideLancer.repositories.MensagemComumRepository;
import com.wideLancer.repositories.ProdutoRepository;
import com.wideLancer.repositories.PropostaRepository;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/chat")
public class ChatRequisicoes {

    private String repositorio = "C:/Users/User/Desktop/WideLancer/uploads/produtos";

    @PostMapping("/cadasMensagem")
    public String cadastrarNovaMensagem(
        HttpSession sessao,
        @RequestParam(value="msg_cnt", required=false) String texto ){

        MensagemComumRepository repositorioMensagemComum = new MensagemComumRepository();
        try{
            int idChat = (int) sessao.getAttribute("idChat");
            int emissorId = (int) sessao.getAttribute("id");

            MensagemComum msg = new MensagemComum();
            msg.setChat(idChat);
            msg.setEmissor(emissorId);
            msg.setTexto(texto);
            repositorioMensagemComum.cadastrar(msg);
            return "sucesso";
        } catch (Exception e){
            System.out.println("______________FALHA AO CADASTRAR MENSAGEM_COMUM_____________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
            return "falha";
        }
    }

    @PostMapping("/defChat")
    public String definirChat(HttpSession sessao, @RequestParam("idOutro") String idOutro){
        int meuId = (int) sessao.getAttribute("id");
        ChatRepository repositorioChat = new ChatRepository();
        String filtro = "WHERE ((vendedor = "+idOutro+" AND cliente = "+meuId+") OR (vendedor = "+meuId+" AND cliente = "+idOutro+"))";
        try{
            ArrayList<Chat> chatArr = repositorioChat.findAll(filtro);
            Chat chat = chatArr.get(0);
            sessao.setAttribute("idChat", chat.getId());
        } catch ( Exception e){
            System.out.println("______________FALHA AO DEFINIR ID DE CHAT___________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
            return "falha";
        }
        return "sucesso";
    }

    @PostMapping("cadasProposta")
    public String cadastrarProposta(HttpSession sessao, @RequestParam("prazo") String praso, @RequestParam("orcamento") double orcamento){
        int idChat = (int) sessao.getAttribute("idChat");
        PropostaRepository repositorioProposta = new PropostaRepository();
        try{
            Proposta proposta = new Proposta();
            proposta.setOrcamento(orcamento);
            proposta.setPrazo(praso);
            proposta.setChat(idChat);
            repositorioProposta.cadastrar(proposta);

        } catch ( Exception e ){
            System.out.println("______________FALHA AO CADASTRAR PROPOSTA__________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
            return "falha";
        }
        return "sucesso";
    }

    @PostMapping("/tratarProposta")
    public String tratarProposta(@RequestParam("decisao") String decisao, @RequestParam("proposta_id") int idProposta, HttpSession sessao){
        int idChat = (int) sessao.getAttribute("idChat");
        ChatRepository repositorioChat = new ChatRepository();
        PropostaRepository repositorioProposta = new PropostaRepository();
        try{
            Chat chat = repositorioChat.findById(idChat);
            Proposta proposta = repositorioProposta.findById(idProposta);
            // garante que, caso o usuario mude o id no front, o sistema nao salve a alteração
            chat.carregarMensagens();
            ArrayList<Mensagem> mensagens = chat.carregarMensagens();
            boolean contemProposta = false;
            for (Mensagem msg : mensagens){
                if ( msg instanceof Proposta ){
                    Proposta prop = (Proposta) msg;
                    if (prop.getId() == proposta.getId()){
                        contemProposta = true;
                        break;
                    }
                }
            }
            if (contemProposta){
                proposta.setAceita(decisao);
                repositorioProposta.salvarEstadoAtual(proposta);
            } else {
                return "proposta nao encontrada no chat";
            }
            
        } catch (Exception e){
            System.out.println("______________FALHA AO SALVAR RESPOSTA DE PROPOSTA__________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________________");
            return "falha";
        }
        return "sucesso";
    };

    @PostMapping("/entregarProduto")
    public String entregarProduto(HttpSession sessao, @RequestParam("produto") MultipartFile produto){
        int idChat = (int) sessao.getAttribute("idChat");
        int idVendedor = (int) sessao.getAttribute("id");
        String filtro = "WHERE chat = "+idChat+" AND aceita = 'aceita'";
        ChatRepository repositorioChat = new ChatRepository();
        ProdutoRepository repositorioProduto = new ProdutoRepository();
        PropostaRepository repositorioProposta = new PropostaRepository();
        String nomeArquivo = produto.getOriginalFilename();
        String caminhoParaSalvarArquivo = repositorio +"/"+nomeArquivo;
        String caminhoParaSalvarNoBandoDeDados = "/uploads/download/"+nomeArquivo;
        try{
            Produto product = new Produto();
            Proposta proposta = repositorioProposta.findAll(filtro).get(0);
            Chat chat = repositorioChat.findById(idChat);
            produto.transferTo(new File(caminhoParaSalvarArquivo));
            
            proposta.setAceita("acabada");
            product.setUrl(caminhoParaSalvarNoBandoDeDados);
            product.setDono(chat.getCliente());
            product.setEmissor(idVendedor);
            product.setPreco(proposta.getOrcamento());
            repositorioProduto.cadastrar(product);
            repositorioProposta.salvarEstadoAtual(proposta);
        } catch (Exception e){
            System.out.println("______________FALHA AO REALIZAR A ENTREGA DE PRODUTO__________________");
            e.printStackTrace();
            System.out.println("______________________________________________________________________");
            return "falha";
        }
        return "sucesso";
    }
}
