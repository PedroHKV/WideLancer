<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $solicitacao = $_POST["solicitacao"];

        if ($solicitacao === "curadores"){
            $usuarios = Usuario::findUsuariosByFuncao("curador");
            echo json_encode($usuarios);
        } else if ($solicitacao === "fornecedores"){
            $usuarios = Usuario::findUsuariosByFuncao("vendedor");
            echo json_encode($usuarios);
        } else if ($solicitacao === "clientes"){
            $usuarios = Usuario::findUsuariosByFuncao("cliente");
            echo json_encode($usuarios);
        }
    }

?>