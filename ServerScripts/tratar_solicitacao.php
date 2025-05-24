<?php

    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Solicitacao.php";

    session_start();
    $usuario_id = $_SESSION["id"];


    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        $cmd = $_POST["cmd"];

        if ( $cmd === "solicitar" ){
            $cpf = $_POST["cpf"];
            $pix = $_POST["pix"];
            $foto = $_FILES["foto"];
            
            $caminho = "../Uploads/solicitacoes/".$foto["name"];

            move_uploaded_file($foto["tmp_name"], $caminho);
            $solicitacao = new Solicitacao(null, $cpf, $pix, $caminho, "pendente", $usuario_id);
            $cadastrado = $solicitacao->cadastrar();

            echo $cadastrado ? "sucesso" : "falha";
        }


    }

?>