<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";
    //usuario.php esta incluido em anuncio.php
    session_start();
    $id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] === "GET"){
      $id_anuncio = $_GET["id"];
      $anuncio = Anuncio::findAnuncioById($id_anuncio);
      $usuario_id = $anuncio->getUsuarioId();
      $vendedor = Usuario::findUsuarioById($usuario_id);
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WideLancer - <?php echo $anuncio->getTitulo(); ?></title>
  <link rel="icon" href="../imagens/logo.png" type="image/png">
  <link rel="stylesheet" href="../Stylesheets/anuncio2.css" />
</head>
  <div id="reqStatus">
      <p id="status"></p>
      <input type="button" onclick="translatediv()" id="dispose" value="X">
  </div>  
  <header>
  <div class="container">
      <img src="../imagens/logo.png" id="logo" style="width: 85px; height: 75px;">
      <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
      </div>
      <div class="topo">
        <h1><?php echo $anuncio->getTitulo()?></h1>
      </div>
      
      <div class="denuncia hid" id="denuncia_">
          <p>Denùnciar post</p>
          <textarea name="" id="motivo" placeholder="motivo da denúncia"></textarea><br>
          <div><input type="button" id="cancelar" onclick="cancelar()" value="cancelar"><input type="button" id="denun" onclick="enviar_denuncia(<?php echo $anuncio->getId();?>)" value="denunciar"></div>
      </div>
      
      <div>
          <div class="availability">
            <span class="available">Sim</span>
            <span class="sale">1</span>
            <div class="quantity">
          </div>
          <input type="button" class="btn" name="" id="" onclick="denunciar()" value="denúncia">  
      </div>
  
      <div class="offer">
        <div class="price-highlight">Clique no botao abaixo para iniciar a sua negociação</div>
        <button id="negoc" onclick="init_negocio(<?php echo $id;?>,<?php echo $usuario_id?>)" class="buy-button">Iniciar Chat</button>
      </div>
    
      <div class="images">
        <img src="<?php echo $anuncio->getFoto()?>" alt="Imagem" />
      </div>
  </div>
</header><br><br><br><br><br><br>
<body>

  <main>

    <section class="description">
      <h2>DESCRIÇÃO DO ANÚNCIO</h2>
      <p><?php echo $anuncio->getDescricao()?></p>
      <br><br>
    </section>

    <aside class="seller-box">
      <h2>Vendedor</h2>
      <img src="<?php echo $vendedor->getFoto();?>" alt="Foto de perfil" class="profile-pic" />
      <span><strong><?php echo $vendedor->getNome()." ".$vendedor->getSobrenome();?></strong> </span>
      
      <span><input type="button" id="portif" onclick="render_portif(<?php echo $vendedor->getId()?>)" value="Conferir Portifolio"></span>
    </aside>
    </section>
  </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../javascripts/visualis_anuncio.js"></script>
</html>