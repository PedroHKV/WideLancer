package com.wideLancer.app.controllers;


import java.sql.SQLException;
import java.util.ArrayList;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import com.wideLancer.models.Anuncio;
import com.wideLancer.models.Chat;
import com.wideLancer.models.Produto;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.ChatRepository;
import com.wideLancer.repositories.ProdutoRepository;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;



@Controller
@RequestMapping("/")
public class MainController {
    
    @GetMapping("/login")
    public String fornecerPaginaDeLogin(){
        return "login.html";
    }

    @GetMapping("/cadastro")
    public String fornecerPaginaDeCadastro(){
        return "cadastro.html";
    }

    @GetMapping("/home")
    public String fornecerPaginaHome(Model model, HttpSession sessao) throws SQLException{
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        int id = (int) sessao.getAttribute("id");
        Usuario usuario = repositorioUsuario.findById(id);
        model.addAttribute("usuario", usuario);
        return "home.html";
    }

    @GetMapping("/perfil")
    public String fornecerPaginaDePerfil(Model model, HttpSession sessao) throws SQLException{
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        int id = (int) sessao.getAttribute("id");
        AnuncioRepository repositorio = new AnuncioRepository();
        Usuario usuario = repositorioUsuario.findById(id);
        ArrayList<Anuncio> anunciosDeUsuario = repositorio.findAll("WHERE anunciante = "+id);
        model.addAttribute("anuncios", anunciosDeUsuario);
        model.addAttribute("usuario", usuario);
        return "perfil.html";
    }

    @GetMapping("/curadoria")
    public String fornecerPaginaDeCuradoria(Model model, HttpSession sessao) throws SQLException{
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        int id = (int) sessao.getAttribute("id");
        Usuario usuario = repositorioUsuario.findById(id);
        model.addAttribute("usuario", usuario);
        return "curadoria.html";
    }

    @GetMapping("/formulario_anuncio")
    public String fornecerPaginaFormularioAnuncio(){
        return "cadas_anuncio.html";
    }

    @GetMapping("/pesquisa")
    public String fornecerPaginaDePesquisa(Model model, @RequestParam("query") String query){
        //query = 'desenvolvimento_de_site' ex:
        AnuncioRepository repositorioAnuncio = new AnuncioRepository();
        try{
            ArrayList<Anuncio> anuncios = repositorioAnuncio.findAllByQuery(query);
            model.addAttribute("anuncios", anuncios);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR ANUNCIOS___________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }
        return "pesquisa.html";
    }

    @GetMapping("/chats")
    public String fornecerPaginaDeChats(HttpSession sessao, Model model){
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        ChatRepository repositorioChat = new ChatRepository();
        try{
            int id = (int) sessao.getAttribute("id");
            ArrayList<Chat> chats = repositorioChat.findAll("WHERE vendedor = "+id+" OR cliente = "+id);
            String[][] chatComOutroUsuario = new String[chats.size()][2];
            int i = -1;
            for (Chat chat : chats){
                i++;
                int idOutro = (chat.getVendedor() == id) ? chat.getCliente() : chat.getVendedor() ;
                Usuario outro = repositorioUsuario.findById(idOutro);
                chatComOutroUsuario[i][0] = outro.getId()+"";
                chatComOutroUsuario[i][1] = outro.getNomeCompleto();
            }
            model.addAttribute("chats", chatComOutroUsuario);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR CHATS______________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }
        return "notificacoes.html";
    }

    @GetMapping("/produtos")
    public String fornecerPaginaDeProdutos(Model model, HttpSession sessao){
        int id = (int) sessao.getAttribute("id");
        ProdutoRepository repositorioProduto = new ProdutoRepository();
        try{
            ArrayList<Produto> produtos = repositorioProduto.findAll("WHERE dono = "+id );
            model.addAttribute("produtos", produtos);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR PRODUTOS______________________");
            e.printStackTrace();
            System.out.println("_______________________________________________________________");
        }
        return "historico_compra.html";
    }
}

