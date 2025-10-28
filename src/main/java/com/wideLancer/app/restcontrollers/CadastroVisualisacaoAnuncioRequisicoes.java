package com.wideLancer.app.restcontrollers;

import java.io.File;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

import com.wideLancer.ConfiguracaoUploads;
import com.wideLancer.models.Anuncio;
import com.wideLancer.repositories.AnuncioRepository;
import com.wideLancer.utils.handlers.HandlerStrings;

import jakarta.servlet.http.HttpSession;;

@RestController
@RequestMapping("/anuncios")
public class CadastroVisualisacaoAnuncioRequisicoes {

    @Autowired private HandlerStrings str;
    private final String repositorio = ConfiguracaoUploads.getInstance().getDiretorioAnuncios();

    @PostMapping("/cadastrar")
    public String cadastrarAnuncio(
        HttpSession sessao,
        @RequestParam("titulo") String titulo,
        @RequestParam("descricao") String descricao,
        @RequestParam("imagem") MultipartFile imagem){
        
        int anuncianteId = (int) sessao.getAttribute("id");    
        Anuncio anuncio = new Anuncio();
        String nome = str.normalizarNomeImagem(imagem.getOriginalFilename());
        String caminhoParaSalvarImagem = repositorio + nome;
        String caminhoParaSalvarNoBancoDados = "/uploads/anuncios/"+nome;
        AnuncioRepository repositorio = new AnuncioRepository();
        try{
            imagem.transferTo(new File(caminhoParaSalvarImagem));
            anuncio.setTitulo(titulo);
            anuncio.setDescricao(descricao);
            anuncio.setAnunciante(anuncianteId);
            anuncio.setFoto(caminhoParaSalvarNoBancoDados);
            repositorio.cadastrar(anuncio);
        } catch (Exception e){
            System.out.println("_______________FALHA AO CADASTRAR ANUNCIO____________________");
            e.printStackTrace();
            System.out.println("_____________________________________________________________");
            return "falha";
        }

        return "cadastrado";
    }
}
