<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    
    session_start();
    $usuario_id = $_SESSION["id"];
    $chats = Chat::findChatsByUsuarioId($usuario_id);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notificações - WideLancer</title>
  <link rel="stylesheet" href="../Stylesheets/notificações.css" />
</head>
<body>

  <header>
    <div id="log">
      <img src="../imagens/logo.png" id="logo" style="width: 90px; height: 80px;">
      <div class="logo">
        <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
      </div>
    </div>  
    <div class="perfil">
      <a href="./home.php" class="btn">Home</a>
    </div>
  </header>

  <main class="notificacoes-container">
    <h2>Suas Notificações</h2>

    <?php
        
        foreach ($chats as $chat) {
          $outro = Usuario::findUsuarioById(($usuario_id === $chat->getSolicitante()) ? $chat->getAnunciante() : $chat->getSolicitante());
          echo "<div onClick = 'redirect(".$chat->getId().")' class='notificacao'>".
                  "<h3>Você iniciou uma negociação com: ".$outro->getNome()." ".$outro->getSobrenome()."</h3>".
                  "<p>Você recebeu uma nova proposta para seu serviço de design de logotipo.</p>".
                "</div>";
        }
    ?>
  </main>
  <script src="../Configuracoes.js"></script>
  <script src="../javascripts/notificacoes.js"></script>
</body>
</html>
