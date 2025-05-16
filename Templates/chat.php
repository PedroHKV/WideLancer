<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_comum.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Proposta.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_produto.php";

    //Só redirecionar essa página com um GET chamado id contendo o id do chat.

    session_start();
    $usuario_id = $_SESSION["id"];
    $chat_id = $_SESSION["chat_id"];
    $chat = Chat::findChatById($chat_id);
    //apos carregar as informações do chat é necessario carregar a instancia do outro
    //vendedor e saber se o usuario que está vendo a página é o vendedor ou solicitante
    $outro;
    if ($chat->getSolicitante()===$usuario_id){
        $outro = Usuario::findUsuarioById($chat->getAnunciante());
        $vendedor = false;

    } else {
        $outro = Usuario::findUsuarioById($chat->getSolicitante());
        $vendedor = true;
    } 
    // os participantes sao dados pelas variaveis: usuario e outro
    $usuario = Usuario::findUsuarioById($usuario_id);
    $mensagens = $chat->carregarMensagens();

    $outros_chats = Chat::findChatsByUsuarioId($usuario_id);
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
        <img src="../imagens/logo.png" id="logo" style="width: 70px; height: 60px;">
        <div class="container">
            <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
        </div>
        <div id="perfil-container">
            <a href="./home.php" class="btn">Home</a>
        </div>
    </header>
    <main class="chat-layout">
        <aside class="chat-sidebar">
            <h3>Conversas</h3>
            <ul class="chat-list">
                <?php
                    foreach( $outros_chats as $chat){
                        $outro = Usuario::findUsuarioById(($usuario_id === $chat->getSolicitante()) ? $chat->getAnunciante() : $chat->getSolicitante());
                        echo "<li class='chat-item'>".$outro->getNome()." ".$outro->getSobrenome()."</li>";
                    }
                ?>
            </ul>
        </aside>
        <section class="chat-main">
            <div class="chat-header">
                <div id="chat-perfilinfo">
                    <img src="<?php echo $outro->getFoto(); ?>" alt="Foto do usuário" class="user-photo">
                    <span class="user-name"><?php echo $outro->getNome()." ".$outro->getSobrenome();?></span>
                </div>
            </div>
            <div id="mensagens">
                <div class="proposta-card-1" id="proposta-form" style="display: none;">
                    <h4>Proposta de Serviço</h4>
                    <input type="date" class="prazo-trabalho" placeholder="Prazo (ex: 5 dias)">
                    <input type="text" class="input-orcamento" placeholder="Insira seu orçamento (ex: R$ 300)">
                    <div class="botoes-proposta">
                        <button class="enviar-proposta">Enviar</button>
                    </div>
                </div>
                <?php
                    foreach ($mensagens as $mensagem ){
                        $myMSG = ($mensagem->getUsuarioId()===$usuario_id);
                        $classe = $myMSG ? "message-row sent" : "message-row received";
                        $foto = $myMSG ? $usuario->getFoto() : $outro->getFoto();
                        if ($mensagem instanceof Proposta){
                            

                            echo "<br><br>";
                            echo    "<div class='proposta-card-2' id='proposta-recebida'>".
                                        "<h4>Estimativa do Serviço</h4>".
                                        "<p class='prazo'>será entregue até: ".$mensagem->getPrazo()."</p>".
                                        "<p class='orcamento'>irá custar: ".$mensagem->getOrcamento()."</p><br>".
                                        "<div class='botoes-proposta'>".
                                            "<button class='btn aceitar'>Aceitar</button>".
                                            "<button class='btn recusar'>Recusar</button>".
                                        "</div>".
                                    "</div>";
                        } else if ($mensagem instanceof MensagemComum) {
                            echo "<div class='".$classe."'>".
                                    "<img src='".$foto."' class='message-avatar' alt='Você'>".
                                    "<div class='message'>".
                                        "<p>".$mensagem->getTexto()."</p>".
                                        "<span class='timestamp'>".$mensagem->getHorario()."</span>".
                                    "</div>".
                                  "</div>";
                        }
                    }
                ?>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Digite sua mensagem...">
                <button class="btn enviar-mensagem">Enviar</button>
                <?php echo ($vendedor ? "<button class='btn proposta-btn'>Proposta</button>": NULL); ?>
            </div>
            
        </section>
    </main>
    <script src="../Configuracoes.js"></script>
    <script src="../Javascripts/chat.js"></script>
</body>
</html>