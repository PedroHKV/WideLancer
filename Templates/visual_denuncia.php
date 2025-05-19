<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Denuncia.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";

    session_start();
    $denuncia_id = $_SESSION["denuncia_id"];
    $denuncia = Denuncia::findDenunciaById($denuncia_id);

    $delator_id = $denuncia->getDelator();
    $delator = Usuario::findUsuarioById($delator_id);

    $anuncio_id = $denuncia->getAnuncioId();
    $anuncio = Anuncio::findAnuncioById($anuncio_id);

    $vendedor_id = $anuncio->getUsuarioId();
    $vendedor = Usuario::findUsuarioById($vendedor_id);

    $numero_denuncias = count(Denuncia::findDenunciasByVendedorId($vendedor_id));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Stylesheets/visual_denuncia.css">
</head>
<body>
    <header>
        <div>
            <img src="../imagens/logo.png" id="logo" style="width: 90px; height: 80px;">
            <div class="container">
                <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
            </div>
        </div>
        <div>
            <div class="login-container">
                <a href="./login.html" class="btn">Login</a>
            </div>
            <div id="perfil-container">
                <a href="./perfil.php" class="btn">Perfil</a>
            </div>
            <div class="login-container">
                <a href="./notificacoes.php" class="btn">Notificações</a>
            </div>
        </div>
    </header>
    <div id="reqStatus">
      <p id="status"></p>
      <input type="button" onclick="translatediv()" id="dispose" value="X">
    </div> 
    <main>
        <div id="horizontal">
            <div id="acoes">

                <div id="status_denuncia" <?php echo ($denuncia->getPendente() ? "style='display:none;'" : "");?>>
                    <?php
                        if ( $denuncia->getDecisao() === "ignorada"){
                            echo "esta denuncia foi ignorada";
                        } else if ( $denuncia->getDecisao() === "anuncio_excluido" ){
                            echo "o anuncio denunciado foi excluido";
                        } else if ( $denuncia->getDecisao() === "vendedor_banido"){
                            echo "este usuario foi banido";
                        }
                    ?>
                </div>

                <input type="button" disabled = "<?php echo ($denuncia->getPendente() ? "false" : "true")?>" id="ign" value="ignorar">
                <input type="button" disabled = "<?php echo ($denuncia->getPendente() ? "false" : "true")?>" id="esc" value="excluir anuncio">
                <input type="button" disabled = "<?php echo ($denuncia->getPendente() ? "false" : "true")?>" id="ban_anun" value="banir anunciante">
            </div>
            <div id="anuncio">
                <img src="" alt="" id="anuncio_img">
                <div id="descricao">

                </div>
            </div>
            <div id="motivacao">
                <div id="dados_denuncia">
                    <div id="envolvidos">
                        <div><b>Delator:</b> <?php echo $delator->getNome()." ".$delator->getSobrenome();?></div>
                        <div><b>Anunciante:</b> <?php echo $vendedor->getNome()." ".$vendedor->getSobrenome();?></div>
                    </div>
                    <div id="motivo">
                        <h2>Motivo da denuncia:</h2>
                        <p id="motivo_texto"><?php echo $denuncia->getMotivo();?></p>
                    </div>
                </div>
            </div>
            <div id="dados_anunciante">
                <div id="foto">
                    <img src="<?php echo $vendedor->getFoto();?>" alt="">
                </div><br>
                <div class="info"><b>Nome:</b> <?php echo $vendedor->getNome()." ".$vendedor->getSobrenome();?></div><br>
                <div class="info"><b>Email:</b> <?php echo $vendedor->getEmail()?></div><br>
                <div class="info"><b>CPF:</b> <?php echo $vendedor->getCpf()?></div><br>
                <div class="info"><b>Pix:</b> <?php echo $vendedor->getPix()?></div><br>
                <div class="info"><b>n° denuncias:</b> <?php echo $numero_denuncias;?></div><br>
            </div>
        </div>

    </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../javascripts/visual_denuncia.js"></script>
</html>