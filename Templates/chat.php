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
    $proposta_pendente = false;
    $proposta_aceita = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Stylesheets/chat.css">
    <title>WideLancer - Chat</title>
    <link rel="icon" href="../imagens/logo.png" type="image/png">
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
    <div id="reqStatus">
      <p id="status"></p>
      <input type="button" onclick="translatediv()" id="dispose" value="X">
    </div> 
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
                    //logica para o display das mensagens
                    foreach ($mensagens as $mensagem ){
                        //analiza se o usuario que mandou a msg é o mesmo que esta vendo a tela
                        $myMSG = ($mensagem->getUsuarioId()===$usuario_id);
                        $classe = $myMSG ? "message-row sent" : "message-row received";
                        $foto = $myMSG ? $usuario->getFoto() : $outro->getFoto();

                        if ($mensagem instanceof Proposta){
                            $respondida = !($mensagem->getAceita() === null);
                            //verifica se a proposta foi aceita
                            if(($mensagem->getAceita() !== null) && ($mensagem->getAceita() !== 0)){
                                $proposta_aceita = true;
                            }
                            //decide o que vai apareces de interação nas mensagens de proposta
                            if ( $respondida){
                                $acoes = ($mensagem->getAceita() === 1) ? "<p>Proposta aceita</p>" : "<p>Proposta recusada</p>" ;
                            } else if (!$respondida && !$vendedor) {
                                $acoes = "<button class='btn aceitar' onClick=\"enviar_decisao('aceitar', '".$mensagem->getId()."')\">Aceitar</button><button class='btn recusar' onClick=\"enviar_decisao('recusar', '".$mensagem->getId()."')\"'>Recusar</button>";
                                $proposta_pendente = true;
                            } else if (!$respondida && $vendedor){
                                $acoes = "sem resposta";
                            }

                            echo "<br><br>";
                            echo    "<div class='proposta-card-2' id='proposta-recebida'>".
                                        "<h4>Estimativa do Serviço</h4>".
                                        "<p class='prazo'>será entregue até: ".$mensagem->getPrazo()."</p>".
                                        "<p class='orcamento'>irá custar: ".$mensagem->getOrcamento()."</p><br>".
                                        "<div class='botoes-proposta'>".
                                            $acoes.
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
                        } else if ($mensagem instanceof MensagemProduto){
                            $adquirido = $mensagem->getAdquirido() ? "Produto adquirido" : "Não obtido";
                            echo "<div class='produto'>".
                                    "<div class='infos_btn'>".
                                        "<div class='infos'>".
                                            "<p>Entrega de produto</p>".
                                            "<p style='font-size: 12px; color:#204d61;'>".$adquirido."</p>".
                                        "</div>".
                                        "<input type='button' style='display :".(($vendedor || $mensagem->getAdquirido()) ? "none" : "flex").";' class='botao' onClick='render_pagamento(".$mensagem->getId().")' value='checar'>".
                                    "</div>".
                                  "</div>"; 
                        }
                    }
                ?>
                <div id="statusHTTP">
                
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Digite sua mensagem...">
                <button class="btn enviar-mensagem">Enviar</button>
                <?php echo (($vendedor && !$proposta_aceita && !$proposta_pendente) ? "<button class='btn proposta-btn'>Proposta</button>": NULL); ?>
                <?php echo (($proposta_aceita && $vendedor) ? "<button class='btn' id='produto_ent' onClick='entregar_produto()'>Entregar produto</button>": NULL); ?>
            </div>
            
        </section>
    </main>
    <script>
        const vendedor = (<?php echo ($vendedor ? 1 : 0)?> === 1); 
        const proposta_pendente = (<?php echo ($proposta_pendente ? 1 : 0)?> === 1);            
    </script>
    <script src="../Configuracoes.js"></script>
    <script src="../Javascripts/chat.js"></script>
</body>
</html>