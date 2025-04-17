<?php
    include "../Utils/Classes/Anuncio.php";
    // Usuaio.php está contido em Anuncio.php
    // portifolio.php esta incluido em Usuario.php

    session_start();
    $id = $_SESSION["id"];
    $usuario = Usuario::findUsuarioById($id);
    $portifolio = Portifolio::findPortifolioByUsuario_id($id);
    $anuncios = Anuncio::findAnunciosByUserId($id);
    
    $foto = $usuario->getFoto();
    if ( !isset($foto) ){
        $foto = "../imagens/usuario_icone.png";
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
                <div id="foto">
                    <label for="infoto"><img id="foto_lab" src="<?php echo $foto; ?>" alt=""></label>
                    <input type="file" name="" id="infoto">
                </div>
                <div id="inputs">
                    <input type="text" value="<?php echo $usuario->getNome();?>" placeholder="Nome" id="nome">
                    <input type="text" value="<?php echo $usuario->getSobrenome();?>" placeholder="Sobrenome" id="sobrenome">
                    <input type="email" value="<?php echo $usuario->getEmail();?>" placeholder="Email" id="email">
                    <input type="password" value="<?php echo $usuario->getSenha();?>" placeholder="Senha" id="senha">
                    <input type="text" value="<?php echo $usuario->getPix();?>" placeholder="chavePIX" id="chavePIX">
                    <input type="text" placeholder="titulo" id="titulo" value="<?php echo ($usuario->isVendedor() ? $portifolio->getTitulo() :  Null) ?>">
                    <textarea id="txtarea" placeholder="Escreva sobre voce"><?php echo ($usuario->isVendedor() ? $portifolio->getDescricao() :  Null) ?></textarea>
                </div>
                <div id="btn_div">
                    <input type="button" id="submit" value="salvar">
                </div>
            </div>
            <div id="direita">
                <div id="header">
                    <p id="nome"><?php echo $usuario->getNome()." ".$usuario->getSobrenome()?></p>
                    <div id="fotoport">
                        <label for="infotoport"><img src="<?php echo $foto;?>" alt=""></label>
                    </div>
                </div>
                <div id="informacoes">
                    <br><br><br><br>
                    <h2><?php echo $portifolio->getTitulo();?></h2>
                    <p id="descricao"><?php echo $portifolio->getDescricao() ?></p>
                    <h2>Quais serviços eu presto?</h2>
                    <div id="addservic">
                        <input type="button" value="novo anuncio">
                    </div><br><br>
                    <div class="servicos-container">
                        <div class="servicos" id="servicos">
                            <?php
                                foreach ($anuncios as $anuncio){
                                    echo "<div class='servico'>". 
                                              "<img src='".$anuncio->getFoto()."' alt=''".
                                              "<p>".$anuncio->getTitulo()."</p>".
                                          "</div>";
                                }
                            ?>
                            <div class="servico">
                                <img src="" alt="">
                                <p>Servico</p>
                            </div>
                            <div class="servico">
                                <img src="" alt="">
                                <p>Servico</p>
                            </div>
                            <div class="servico">
                                <img src="" alt="">
                                <p>Servico</p>
                            </div>
                            <div class="servico">
                                <img src="" alt="">
                                <p>Servico</p>
                            </div>
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