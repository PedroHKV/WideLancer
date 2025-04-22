<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";
    //Só redirecionar essa página com um GET chamado id contendo o id do chat.

    session_start();
    $usuario_id = $_SESSION["id"];
    $chat_id = $_SESSION["chat_id"];
    $chat = Chat::findChatById($chat_id);
    $outro;
    if ($chat->getSolicitante()===$usuario_id){
        $outro = Usuario::findUsuarioById($chat->getAnunciante());
        $vendedor = false;

    } else {
        $outro = Usuario::findUsuarioById($chat->getSolicitante());
    } 
    
    $usuario = Usuario::findUsuarioById($usuario_id);
    $mensagens = Mensagem::findMensagensByChatId($chat_id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Stylesheets/chat.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="container">
            <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
        </div>
        <div id="perfil-container">
            <a href="./perfil.php" class="btn">Perfil</a>
        </div>
    </header>
    <main class="chat-layout">
        <aside class="chat-sidebar">
            <h3>Conversas</h3>
            <ul class="chat-list">
                <li class="chat-item">João</li>
                <li class="chat-item">Maria</li>
                <li class="chat-item">Carlos</li>
            </ul>
        </aside>
        <section class="chat-main">
            <div class="chat-header">
                <div id="chat-perfilinfo">
                    <img src="../imagens/usuario2.jpg" alt="Foto do usuário" class="user-photo">
                    <span class="user-name">João Silva</span>
                </div>
                <div class="status-indicador">
                    <span class="status-texto">🕒 Em andamento...</span>
                </div>
            </div>
            <div id="mensagens">
                <?php
                    foreach ($mensagens as $mensagem ){
                        $myMSG = ($mensagem->getUsuarioId()===$usuario_id);
                        $classe = $myMSG ? "message-row sent" : "message-row received";
                        $foto = $myMSG ? $usuario->getFoto() : $outro->getFoto();
                        echo "<div class='".$classe."'>".
                                "<img src='".$foto."' class='message-avatar' alt='Você'>".
                                "<div class='message'>".
                                    "<p>".$mensagem->getTexto()."</p>".
                                    "<span class='timestamp'>".$mensagem->getHorario()."</span>".
                                "</div>".
                              "</div>";
                    }
                ?>
                <div class="proposta-card-1" id="proposta-form" style="display: none;">
                    <h4>Proposta de Serviço</h4>
                    <input type="text" class="prazo-trabalho" placeholder="Prazo (ex: 5 dias)">
                    <input type="text" class="input-orcamento" placeholder="Insira seu orçamento (ex: R$ 300)">
                    <div class="botoes-proposta">
                        <button class="enviar-proposta">Enviar</button>
                    </div>
                </div>
                <div class="proposta-card-2" id="proposta-recebida" style="display: none;">
                    <h4>Proposta de Serviço</h4>
                    <p class="prazo">Prazo: 5 dias</p>
                    <p class="orcamento">Orçamento: R$ 500,00</p>
                    <div class="botoes-proposta">
                        <button class="btn aceitar">Aceitar</button>
                        <button class="btn recusar">Recusar</button>
                    </div>
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Digite sua mensagem...">
                <button class="btn enviar-mensagem">Enviar</button>
                <button class="btn proposta-btn">Proposta</button>
            </div>
            
        </section>
    </main>
    <script src="../Configuracoes.js"></script>
    <script src="../Javascripts/chat.js"></script>
</body>
</html>