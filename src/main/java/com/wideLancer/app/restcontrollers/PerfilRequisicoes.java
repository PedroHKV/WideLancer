package com.wideLancer.app.restcontrollers;

import java.io.File;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.UsuarioRepository;
import com.wideLancer.utils.handlers.HandlerStrings;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/perfil")
public class PerfilRequisicoes {

    private String repositorio = "C:/Users/User/Desktop/WideLancer/uploads/perfis/";
    @Autowired HandlerStrings str;


    @PostMapping("/alteracoes")
    public String salvarAlteracoes(
        HttpSession sessao,
        @RequestParam("nome") String nome,
        @RequestParam("sobrenome") String sobrenome,
        @RequestParam("email") String email,
        @RequestParam("titulo") String titulo,
        @RequestParam("descricao") String descricao){

        String salvas = "falha";
        int usuarioId = (int) sessao.getAttribute("id");
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            Usuario usuario = repositorioUsuario.findById(usuarioId);
            usuario.setNome(nome);
            usuario.setSobrenome(sobrenome);
            usuario.setEmail(email);
            usuario.setTituloPortifolio(titulo);
            usuario.setDescricaoPortifolio(descricao);
            salvas = repositorioUsuario.salvarEstadoAtual(usuario) ? "sucesso" : "falha";
        } catch (Exception e){
            System.out.println("_______________FALHA AO ATUALIZAR CONTA DE USUARIO_______________");
            e.printStackTrace();
            System.out.println("_________________________________________________________________");
        }

        return salvas;
    }

    @PostMapping("/alteracoesComImagem")
    public String salvarAlteracoes(
        HttpSession sessao,
        @RequestParam("nome") String nome,
        @RequestParam("sobrenome") String sobrenome,
        @RequestParam("email") String email,
        @RequestParam("titulo") String titulo,
        @RequestParam("descricao") String descricao,
        @RequestParam("img") MultipartFile foto){

        String salvas = "falha";
        int usuarioId = (int) sessao.getAttribute("id");
        String nomeFoto = str.normalizarNomeImagem(foto.getOriginalFilename());
        String caminhoParaSalvarImagem = repositorio + nomeFoto;
        String caminhoParaSalvarNoBancoDados = "/uploads/perfis/"+nomeFoto;
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        try{
            foto.transferTo(new File(caminhoParaSalvarImagem));
            Usuario usuario = repositorioUsuario.findById(usuarioId);
            usuario.setNome(nome);
            usuario.setSobrenome(sobrenome);
            usuario.setEmail(email);
            usuario.setFoto(caminhoParaSalvarNoBancoDados);
            usuario.setTituloPortifolio(titulo);
            usuario.setDescricaoPortifolio(descricao);
            salvas = repositorioUsuario.salvarEstadoAtual(usuario) ? "sucesso" : "falha";
        } catch (Exception e){
            System.out.println("_______________FALHA AO ATUALIZAR CONTA DE USUARIO_______________");
            e.printStackTrace();
            System.out.println("_________________________________________________________________");
        }

        return salvas;
    }


}
