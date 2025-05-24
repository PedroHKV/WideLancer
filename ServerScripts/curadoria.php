<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $cmd = $_POST["cmd"];

        if ($cmd === "denuncia"){

            session_start();
            $denuncia_id = $_POST["denuncia_id"];
            $_SESSION["denuncia_id"] = $denuncia_id;
            echo "sucesso";
        } else if ($cmd === "solicitacao"){
            session_start();
            $solicitacao_id = $_POST["solicitacao_id"];
            $_SESSION["solicitacao_id"] = $solicitacao_id;
            echo "sucesso";
        }
    }

?>