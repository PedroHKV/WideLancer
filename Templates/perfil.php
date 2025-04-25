<?php
    include "../Utils/Classes/Anuncio.php";
    // Usuario.php está contido em Anuncio.php
    // portifolio.php esta incluido em Usuario.php

    //a variavel usuario representa o usuario que possui o portifolio, nao o que
    //esta visualizando a pagina
    if (isset($_GET["id"])){
        // parte destinada para quando o usuario acessar o portifolio de
        //outra pessoa
        session_start();
        $visualizador_id = $_SESSION["id"];
        $id_vendedor = $_GET["id"];
        $usuario = Usuario::findUsuarioById($id_vendedor);
        $portifolio = Portifolio::findPortifolioByUsuario_id($id_vendedor);
        $anuncios = Anuncio::findAnunciosByUserId($id_vendedor);

        $editavel = false;

        $foto = $usuario->getFoto();
        if ( !isset($foto) ){
            $foto = "../imagens/usuario_icone.png";
        }
    } else{
        //nesse caso o usuario esta acessando o proprio perfil
        session_start();
        $id = $_SESSION["id"];
        $usuario = Usuario::findUsuarioById($id);
        $portifolio = Portifolio::findPortifolioByUsuario_id($id);
        $anuncios = Anuncio::findAnunciosByUserId($id);

        $editavel = true;

        $foto = $usuario->getFoto();
        if ( !isset($foto) ){
            $foto = "../imagens/usuario_icone.png";
        }
    // Verificação de permissões
    $temCpf = $usuario->getCpf() ? "flex" : 'none';
    $temPix = $usuario->getPix() ? "flex" : 'none';    
    $nTemCpf = $usuario->getCpf() ? "none" : 'flex';
    $nTemPix = (! $usuario->getPix() && $usuario->getCpf()) ? "flex" : 'none';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Stylesheets/perfil.css">
</head>
<body>
    <main>
        <div>
            <div id="esquerda">
                <?php
                    if ($editavel){
                        echo "<div id='foto'>
                                <img id='cam' src='../imagens/camera.png'>
                                 <label for='infoto'><img id='foto_lab' src=' ".$foto."' alt=''></label>
                                 <input type='file' name='' id='infoto'>
                             </div>";
                    } 
                ?>
                <div id="inputs">
                    <input type="text" value="<?php echo $usuario->getNome();?>" placeholder="Nome" id="nome">
                    <input type="text" value="<?php echo $usuario->getSobrenome();?>" placeholder="Sobrenome" id="sobrenome">
                    <input type="email" value="<?php echo $usuario->getEmail();?>" placeholder="Email" id="email">
                    <?php 
                        if ($editavel){
                          echo "<input type='password' value='" . $usuario->getSenha() . "' placeholder='Senha' id='senha'> 
                                <h3 style = 'display:".$nTemCpf.";'>Torne-se um cliente para poder contratar serviços!</h3> 
                                <input type='text' value='" . $usuario->getCpf() . "' placeholder='CPF' id='cpf'> 
                                <h3 style = 'display:".$nTemPix." ;'>Torne-se um vendedor também! basta adicionar as seguintes informações</h3> 
                                <input type='text' style = 'display:".$temCpf.";' value='" . $usuario->getPix() . "' placeholder='chavePIX' id='chavePIX'> 
                                <input type='text' style = 'display:".$temPix.";' placeholder='titulo' id='titulo' value='" . ($usuario->isVendedor() ? $portifolio->getTitulo() :  "") . "'> 
                                <textarea id='txtarea' style = 'display:".$temPix.";' placeholder='Escreva sobre voce'>" . ($usuario->isVendedor() ? $portifolio->getDescricao() :  "") . "</textarea>";
                        } else {
                            echo "<input type='text' value='" . $usuario->getPix() . "' placeholder='chavePIX' id='chavePIX'>";
                        }
                    ?>

                </div>
                <?php
                    if ($editavel){
                        echo "<div id='btn_div'>
                                  <input type='button' id='submit' value='salvar'>
                              </div><br><br>";
                    }
                ?>
            </div>
            <div id="direita">
                <div id="header">
                    <p id="nome"><?php echo $usuario->getNome()." ".$usuario->getSobrenome()?></p>
                    <div id="fotoport">
                        <label for="infotoport"><img src="<?php echo $foto;?>" alt=""></label>
                    </div>
                    <input type="button" id="voltar" value="< Home">
                </div>
                <div id="notif">

                </div>
                <div id="informacoes">
                    <br><br><br><br>
                    <h2><?php echo $portifolio->getTitulo();?></h2>
                    <p id="descricao"><?php echo $portifolio->getDescricao() ?></p>
                    <div id="confirm">
                        <p>Tem certeza que deseja excluir este anuncio?</p>
                        <br>
                        <div id="simounao">
                            <input type="button" id="sim" value="sim">
                            <input type="button" id="nao" value="nao">
                        </div>
                    </div>
                    <h2>Meus Serviços</h2>
                    <?php
                        if ($editavel){
                            echo "<div id='addservic'>".
                                      "<input type='button' style = 'display:".$temPix.";' id='novo_anunc' value='novo anuncio'>".
                                      "<input type='button' style = 'display:".$temPix.";' id='esc' value='excluir'>".
                                 "</div><br><br>";
                        }
                    ?>
                    <div class="servicos-container">
                        <div class="servicos" id="servicos">
                            <?php
                                foreach ($anuncios as $anuncio){
                                    echo "<div class='servico' onClick='render_anuncio(".$anuncio->getId().")' >". 
                                              "<img src='".$anuncio->getFoto()."' alt=''/>".
                                              "<p>".$anuncio->getTitulo()."</p>".
                                          "</div>";
                                }
                            ?>
                        </div>
                        <button id="prevBtn">❮</button>
                        <button id="nextBtn">❯</button>
                    </div>
                    <div>

                    </div>

                          
                    </div>
                </div>
            </div>
    </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../Javascripts/perfil.js"></script>
</html>