<?php
    include "../Utils/Classes/Usuario.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        //o id é auto gerado
        //o cpf e a foto serao definidos depois
        $USUARIO = new Usuario(Null, $email, $senha, $nome, $sobrenome, Null, Null, false , false );
        $Cadastrado = $USUARIO->cadastrar();

        if ( $Cadastrado ){
            echo "cadastrado";
        } else {
            // vai ter uma pagina pra 404
            echo "404";
        }
    }

?>