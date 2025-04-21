<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $solicitante = $_POST["solicitante"];
        $anunciante = $_POST["anunciante"];

        $chat = Chat::findChatByParticipantes($solicitante, $anunciante);
        if ( isset($chat) ){
        } else {
            $chat = new Chat(NULL, $solicitante, $anunciante);
            $chat->cadastrar();
            $chat = Chat::findChatByParticipantes($solicitante, $anunciante);
        }
        echo $chat->getId();
    }

?>