<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Proposta.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Venda.php";

    session_start();
    $chat_id = $_SESSION["chat_id"];

    //verifica se um cliente decidindo algo sobre a proposta ou um servidor mandando uma
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        if (isset($_POST["cliente"])){
            //caso seja um cliente tomando alguma decisão
            $decisao = $_POST["decisao"];
            $proposta_id = $_POST["proposta_id"];

            $proposta = Proposta::findPropostaById($proposta_id);

            if ($decisao === "aceitar"){
                $proposta->setAceita(1);
                $dataAtual = date("Y-m-d H:i:s");

                $venda = new Venda(null,$dataAtual,  $proposta->getPrazo(),1, $chat_id);
                $venda->cadastrar();
            } else {
                $proposta->setAceita(0);
            }

            $proposta->salvarUpdates();
            echo "salvas";
        } else {
            //caso seja um fornecedor cadastrando uma proposta
            session_start();
            $orcamento = $_POST["orcamento"];
            $prazo = $_POST["prazo"];
            $usuario_id = $_SESSION["id"];
            $chat_id = $_SESSION["chat_id"];
            
            $proposta = new Proposta(Null, $orcamento, $prazo, 0, $usuario_id, $chat_id, NULL);
            $cadastrada = $proposta->cadastrar();

            if ($cadastrada){
                echo "cadastrado";
            } else {
                echo "falha";
            }
        }
    }

?>