<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";

    if ($_SERVER["REQUEST_METHOD"]==="POST"){
        session_start();
        $usuario_id = $_SESSION["id"];
        $chat_id = $_SESSION["chat_id"];
        $mensagem = $_POST["msg_cnt"];
        $horario = date("Y-m-d H:i:s");
        $MSG = new Mensagem (null, $mensagem, $horario, $chat_id, $usuario_id );
        $cadastrada = $MSG->cadastrar();
        if ($cadastrado){
            echo "cadastrado";
        } else {
            echo "falha";
        }
    }
?>