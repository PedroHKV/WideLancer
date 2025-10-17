package com.wideLancer.app.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.wideLancer.models.Anuncio;
import com.wideLancer.models.Usuario;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.repositories.UsuarioRepository;

@Controller
@RequestMapping("/pesquisa")
public class PesquisaController {
    
    @GetMapping("/anuncio")
    public String fornecerPaginaDoAnuncio(Model model, @RequestParam("id") int id){
        UsuarioRepository repositorioUsuario = new UsuarioRepository();
        AnuncioRepository repositorio = new AnuncioRepository();
        try{
            Anuncio anuncio = repositorio.findById(id);
            Usuario usuario = repositorioUsuario.findById(anuncio.getAnunciante());
            model.addAttribute("anunciante", usuario);
            model.addAttribute("anuncio", anuncio);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CARREGAR ANUNCIO____________________");
            e.printStackTrace();
            System.out.println("____________________________________________________________");
        }
        return "visualis_anuncio.html";
    }
}
