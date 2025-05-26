<?php

    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_produto.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Produto.php";

    session_start();
    $usuario_id = $_SESSION["id"];
    $chat_id = $_SESSION["chat_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $cmd = $_POST["cmd"];

        if ($cmd === "entrega"){
            //quando um vendedor entrega o produto
            $produto = $_FILES["produto"];
            $nome = basename($produto["name"]);
            $nomeSeguro = uniqid() . "_" . str_replace(" ", "", $nome);

            
            $caminho = "../Uploads/produtos/" . $nomeSeguro;
            $hora = date("Y-m-d H:i:s");

            move_uploaded_file($produto["tmp_name"], $caminho);

            $msg_produto = new MensagemProduto(null, 0, $caminho, $usuario_id, $chat_id, $hora);
            $msg_produto->cadastrar();

            echo "sucesso";
        } else if ($cmd === "coleta"){
            //cria uma sessão para a pagina de pagamento
            $produto_id = $_POST["produto_id"];
            $_SESSION["produto_id"] = $produto_id;
            echo "sucesso";
        } else if ($cmd === "download"){
            $produto_id = $_POST["id"];
            $produto = Produto::findProdutoById($produto_id);
            $caminho_relativo = $produto->getCaminho();

            if (!$caminho_relativo || !file_exists($caminho_relativo)) {
                http_response_code(404);
                echo "Arquivo não encontrado: $caminho_relativo";
                exit;
            }

            $nome = basename($caminho_relativo);

            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $nome . "\"");
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($caminho_relativo));
            readfile($caminho_relativo);
            exit;

        }
    }

?>