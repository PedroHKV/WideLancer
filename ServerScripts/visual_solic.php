<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Solicitacao.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    session_start();
    $solicitacao_id = $_SESSION["solicitacao_id"];
    $solicitacao = Solicitacao::findBySolicitacaoById($solicitacao_id);

       if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $cmd = $_POST["cmd"];
        $usuario_id = $_POST["usuario_id"]; 
        $usuario = Usuario::findUsuarioById($usuario_id);

        if ($cmd === "aceitar"){
            $solicitacao->setDecisao("aceita");
            $usuario->setVendedor(1);
            $usuario->setCpf( $solicitacao->getCpf() );
            $usuario->setStripeid($solicitacao->getPix()); //mudar pix para Stripe ID
            
            
            $solicitacao->salvarUpdates();
            $usuario->salvarUpdates();
            echo "sucesso";
        } else if ( $cmd === "recusar" ){
            $solicitacao->setDecisao("recusada");

            $solicitacao->salvarUpdates();
            echo "sucesso";
 
        }
    }

?>