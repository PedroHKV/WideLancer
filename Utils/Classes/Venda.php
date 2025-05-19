<?php

include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";

class Venda implements JsonSerializable {
    private $id;
    private $data_init;
    private $data_termino;
    private $andamento;
    private $chat_id;

    // Construtor
    public function __construct($id, $data_init, $data_termino, $andamento, $chat_id) {
        $this->id = $id;
        $this->data_init = $data_init;
        $this->data_termino = $data_termino;
        $this->andamento = $andamento;
        $this->chat_id = $chat_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getDataInit() {
        return $this->data_init;
    }

    public function getDataTermino() {
        return $this->data_termino;
    }

    public function getAndamento() {
        return $this->andamento;
    }

    public function getChatId() {
        return $this->chat_id;
    }

    // Setters
    public function setDataInit($data_init) {
        $this->data_init = $data_init;
    }

    public function setDataTermino($data_termino) {
        $this->data_termino = $data_termino;
    }

    public function setAndamento($andamento) {
        $this->andamento = $andamento;
    }

    public function setChatId($chat_id) {
        $this->chat_id = $chat_id;
    }

    // Cadastrar nova venda
    public function cadastrar() {
        $bd = ConectarSQL();
        $sql = "INSERT INTO Venda(data_init, data_termino, andamento, chat_id)
                VALUES (?, ?, ?, ?)";

        $query = $bd->prepare($sql);
        $query->bind_param(
            "ssii",
            $this->data_init,
            $this->data_termino,
            $this->andamento,
            $this->chat_id
        );

        $cadastrado = $query->execute();
        $query->close();
        $bd->close();
        return $cadastrado;
    }

    // Atualizar venda existente
    public function salvarUpdates() {
        $bd = ConectarSQL();
        $sql = "UPDATE Venda SET data_init = ?, data_termino = ?, andamento = ?, chat_id = ?
                WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param(
            "ssiii",
            $this->data_init,
            $this->data_termino,
            $this->andamento,
            $this->chat_id,
            $this->id
        );

        $atualizado = $query->execute();
        $query->close();
        $bd->close();
        return $atualizado;
    }

    // Buscar venda por ID
    public static function findVendaById($id) {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM Venda WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $res = $query->get_result();
        if ($res->num_rows > 0) {
            $v = $res->fetch_assoc();
            $venda = new Venda(
                $v["id"],
                $v["data_init"],
                $v["data_termino"],
                $v["andamento"],
                $v["chat_id"]
            );
            $query->close();
            $bd->close();
            return $venda;
        }

        $query->close();
        $bd->close();
        return null;
    }

    // Buscar vendas por chat_id
    public static function findVendasByChatId($chat_id) {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM Venda WHERE chat_id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $chat_id);
        $query->execute();

        $res = $query->get_result();
        $vendas = [];

        while ($v = $res->fetch_assoc()) {
            $vendas[] = new Venda(
                $v["id"],
                $v["data_init"],
                $v["data_termino"],
                $v["andamento"],
                $v["chat_id"]
            );
        }

        $query->close();
        $bd->close();

        return count($vendas) > 0 ? $vendas : null;
    }

    // Deletar venda por ID
    public static function deleteVendaById($id) {
        $bd = ConectarSQL();
        $sql = "DELETE FROM Venda WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);
        $sucesso = $query->execute();

        $query->close();
        $bd->close();

        return $sucesso;
    }

    // Suporte para JSON
    public function jsonSerialize() {
        return [
            "id" => $this->id,
            "data_init" => $this->data_init,
            "data_termino" => $this->data_termino,
            "andamento" => $this->andamento,
            "chat_id" => $this->chat_id
        ];
    }
}
?>
