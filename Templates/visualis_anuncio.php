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
  <title>WideLancer</title>
  <link rel="stylesheet" href="../Stylesheets/anuncio2.css" />
</head>
  <header>
  <div class="container">
      <img src="../imagens/logo.png" id="logo" style="width: 85px; height: 75px;">
      <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
      </div>
      <div class="topo">
        <h1><?php echo $anuncio->getTitulo()?></h1>
      </div>
  
      <div class="availability">
        <span class="available">Sim</span>
        <span class="sale">1</span>
        <div class="quantity">
        </div>
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
    <div class="info-verification-wrapper">
      <div class="info-box">
        <h2>CARACTERÍSTICAS</h2>
        <span><strong>Tipo do Anúncio:</strong> Freelance</span>
        <span><strong>Procedência:</strong> Solo</span>
      </div>

      <div class="verifications">
        <h2>Verificações</h2>
        <span>E-mail: Verificado</span>
        <span>Documentos: Não Verificado</span>
      </div>
    </div>

    <section class="description">
      <h2>DESCRIÇÃO DO ANÚNCIO</h2>
      <p><?php echo $anuncio->getDescricao()?></p>
    </section>

    <aside class="seller-box">
      <h2>Vendedor</h2>
      <img src="<?php echo $vendedor->getFoto();?>" alt="Foto de perfil" class="profile-pic" />
      <span><strong><?php echo $vendedor->getNome()." ".$vendedor->getSobrenome();?></strong> 😊</span>
      <span>Membro desde 14/04/2025</span>
      <span>Avaliações positivas: 100%</span>
      <span>Número de avaliações: 3</span>
      <span>Último acesso: há 14 dias</span>
      <span><input type="button" id="portif" onclick="render_portif(<?php echo $vendedor->getId()?>)" value="Conferir Portifolio"></span>
    </aside>

    <section class="guarantee">
      <h2>Entrega garantida</h2>
      <p>ou o seu dinheiro de volta</p>
      <img src="../imagens/SELO GARANTIA.png" alt="Selo Garantia" class="selo-garantia" />
    </section>

    <section class="questions">
      <h2>PERGUNTAS</h2>

      <div class="question">
        <p><strong>jullyano:</strong> Você é formado em alguma coisa?</p>
        <p class="resposta"><strong>Joazinho123 (anunciante):</strong> Sou formado em Engenharia de Software pela PUC.</p>
      </div>

      <div class="question">
        <p><strong>pedrinhoklein82:</strong> Estou super interessado, por favor, responder o chat de orçamento.</p>
        <p class="resposta"><strong>Joazinho123 (anunciante):</strong> Já te respondi lá! Podemos negociar.</p>
      </div>

      <div class="question">
        <p><strong>yurioperdido:</strong> Está online?</p>
        <p class="resposta"><strong>Joazinho123 (anunciante):</strong> Sim, estou disponível agora!</p>
      </div>

      <div class="question-input">
        <p>Você precisa estar logado para fazer uma pergunta</p>
      </div>
    </section>

    <section class="similar-ads">
      <h2>Anúncios parecidos</h2>
      <div class="tags">
        <span>TANANAM TANAM</span>
        <span>PARAM PARAM</span>
        <span>BABILU</span>
        <span>KKKKKKKKKK</span>
        <span>NÃO COMPENSA</span>
      </div>
    </section>
  </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../javascripts/visualis_anuncio.js"></script>
</html>