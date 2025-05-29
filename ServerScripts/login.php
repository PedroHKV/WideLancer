<?php   
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include "C:/xampp/htdocs/WideLancer_Artefato/Configuracoes.php";
    
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $usuario = Usuario::findUsuarioByEmail($email);
    
    if($usuario != null){
        if($usuario->isAtivo() != 0){
            if($senha == $usuario->getSenha()){
                session_start();
                $_SESSION["id"] = $usuario->getId();
                echo "certo";
            } else {
                echo "err";
            }
        } else{
            echo "banido";
        }
    } else {
        echo "em404";
    }

?>