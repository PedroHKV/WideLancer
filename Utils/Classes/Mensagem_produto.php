<?php

include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";

class MensagemProduto extends Mensagem implements JsonSerializable {
    private $adquirido;
    private $caminho;

    // Construtor
    public function __construct($id, $adquirido, $caminho, $usuario_id = null, $chat_id = null, $horario = null) {
        parent::__construct($id, $horario, $chat_id, $usuario_id, "produto");
        $this->adquirido = $adquirido;
        $this->caminho = $caminho;
    }

    // Getters
    public function getAdquirido() {
        return $this->adquirido;
    }

    public function getCaminho() {
        return $this->caminho;
    }

    // Setters
    public function setAdquirido($adquirido) {
        $this->adquirido = $adquirido;
    }

    public function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

    // Método de cadastro usando a PROCEDURE
    public function cadastrar() {
        $bd = ConectarSQL();

        $sql = "CALL cadastrar_msg_produto(?, ?, ?)";
        $query = $bd->prepare($sql);
        $query->bind_param("sii", 
            $this->caminho,
            $this->chat_id,
            $this->usuario_id
        );

        $cadastrado = $query->execute();
        $query->close();
        $bd->close();

        return $cadastrado;
    }

    public function salvarUpdates() {
        $bd = ConectarSQL();
        $sql = "UPDATE Mensagem_produto SET adquirido = ?, caminho = ? WHERE id = ?";

        $query = $bd->prepare($sql);
        $id = $this->getId();
        $query->bind_param("isi", $this->adquirido, $this->caminho, $id);

        $atualizado = $query->execute();
        $query->close();
        $bd->close();

        return $atualizado;
    }

    // Métodos estáticos
    public static function findById($id) {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM MensagensView WHERE id = ? AND tipo = 'mensagem_produto'";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $res = $query->get_result();
        if ($res->num_rows > 0) {
            $linha = $res->fetch_assoc();
            $msgProduto = new MensagemProduto(
                $linha["id"],
                $linha["adquirido"],
                $linha["caminho"],
                $linha["usuario_id"],
                $linha["chat_id"],
                $linha["horario"]
            );

            $query->close();
            $bd->close();
            return $msgProduto;
        }

        $query->close();
        $bd->close();
        return null;
    }

    public static function deleteById($id) {
        $bd = ConectarSQL();
        $sql = "DELETE FROM Mensagem_produto WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);

        $sucesso = $query->execute();
        $query->close();
        $bd->close();

        return $sucesso;
    }

    public function jsonSerialize() {
        return [
            "id" => $this->getId(),
            "adquirido" => $this->adquirido,
            "caminho" => $this->caminho
        ];
    }
}
?>
