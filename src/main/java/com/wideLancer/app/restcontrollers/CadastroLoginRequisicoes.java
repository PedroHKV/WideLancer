package com.wideLancer.app.restcontrollers;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.UsuarioRepository;

import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/")
public class CadastroLoginRequisicoes {

    @PostMapping("/cadastrar")
    public String cadastrarUsuario(
        @RequestParam("nome") String nome,
        @RequestParam("sobrenome") String sobrenome,
        @RequestParam("email") String email,
        @RequestParam("senha") String senha){

        String resp = "serv_err";
        Usuario novoUsuario = new Usuario();
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        novoUsuario.setNome(nome);
        novoUsuario.setSobrenome(sobrenome);
        novoUsuario.setEmail(email);
        novoUsuario.setSenha(senha);
        
        try{
            if(repositorioUsuario.findByEmail(email) != null){
                return "dup_key";
            }
            boolean cadastrado = repositorioUsuario.cadastrar(novoUsuario);
            if (cadastrado){
                resp = "cadastrado";
            }
        } catch ( Exception e ){
            System.err.println("_______________FALHA AO CADASTRAR USUARIO_______________");
            e.printStackTrace();
            System.err.println("_________________________________________________________");
        }
        return resp;
    }

    @PostMapping("/autenticar")
    public String autenticarUsuario( HttpSession sessao, @RequestParam("email") String email, @RequestParam("senha") String senha){
        String autenticado = "serv_err";
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        Usuario usuario = new Usuario();
        int id = 0;
        try{
            //antes de autenticar , verifica se o email existe no bd
            usuario = repositorioUsuario.findByEmail(email);
            if(usuario == null){
                return "em404";
            }
            id = usuario.getId();
            boolean ativo = usuario.isAtivo();
            if (!ativo){
                return "inativo";
            }
            autenticado = usuario.autenticar(senha);
        } catch (Exception e){
            System.err.println("_______________FALHA AO AUTENTICAR USUARIO_______________");
            e.printStackTrace();
            System.err.println("_________________________________________________________");
        }

        if (autenticado.equals("certo")){
            sessao.setAttribute("id", id);
        }

        return autenticado;
    }
}
