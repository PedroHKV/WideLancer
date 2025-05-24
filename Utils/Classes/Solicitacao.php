<?php

    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

class Solicitacao implements JsonSerializable {
    private $id;
    private $cpf;
    private $pix;
    private $foto;
    private $decisao;
    private $usuario_id;

    public function __construct($id, $cpf, $pix, $foto, $decisao, $usuario_id) {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->pix = $pix;
        $this->foto = $foto;
        $this->decisao = $decisao;
        $this->usuario_id = $usuario_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getPix() {
        return $this->pix;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getDecisao() {
        return $this->decisao;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setPix($pix) {
        $this->pix = $pix;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setDecisao($decisao) {
        $this->decisao = $decisao;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function cadastrar() {
        $bd = ConectarSQL();
        $sql = "INSERT INTO Solicitacao(cpf, pix, foto, decisao, usuario_id)
                VALUES (?, ?, ?, ?, ?)";

        $query = $bd->prepare($sql);
        $query->bind_param("ssssi", $this->cpf, $this->pix, $this->foto, $this->decisao, $this->usuario_id);

        $cadastrado = $query->execute();

        $query->close();
        $bd->close();

        return $cadastrado;
    }

    public function salvarUpdates() {
        $bd = ConectarSQL();
        $sql = "UPDATE Solicitacao SET cpf = ?, pix = ?, foto = ?, decisao = ?, usuario_id = ? WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("ssssii", $this->cpf, $this->pix, $this->foto, $this->decisao, $this->usuario_id, $this->id);

        $atualizado = $query->execute();

        $query->close();
        $bd->close();

        return $atualizado;
    }

    public function jsonSerialize() {
        $usuario = Usuario::findUsuarioById($this->usuario_id);
        $nome = $usuario->getNome()." ".$usuario->getSobrenome();
        return [
            "id" => $this->id,
            "cpf" => $this->cpf,
            "pix" => $this->pix,
            "foto" => $this->foto,
            "decisao" => $this->decisao,
            "usuario_id" => $this->usuario_id,
            "usuario" => $nome
        ];
    }

    public static function findBySolicitacaoById($id) {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM Solicitacao WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $resultado = $query->get_result();

        if ($resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();

            $solicitacao = new Solicitacao(
                $linha["id"],
                $linha["cpf"],
                $linha["pix"],
                $linha["foto"],
                $linha["decisao"],
                $linha["usuario_id"]
            );

            $query->close();
            $bd->close();

            return $solicitacao;
        } else {
            $query->close();
            $bd->close();
            return null;
        }
    }

    public static function findSolicitacaoByUsuarioId($usuario_id) {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM Solicitacao WHERE usuario_id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $usuario_id);
        $query->execute();

        $resultado = $query->get_result();

        if ($resultado->num_rows === 0) {
            $query->close();
            $bd->close();
            return null;
        }

        $solicitacoes = [];

        while ($linha = $resultado->fetch_assoc()) {
            $solicitacao = new Solicitacao(
                $linha["id"],
                $linha["cpf"],
                $linha["pix"],
                $linha["foto"],
                $linha["decisao"],
                $linha["usuario_id"]
            );
            $solicitacoes[] = $solicitacao;
        }

        $query->close();
        $bd->close();

        return $solicitacoes;
    }



    public static function findAll() {
        $bd = ConectarSQL();
        $sql = "SELECT * FROM Solicitacao";

        $query = $bd->prepare($sql);
        $query->execute();

        $resultado = $query->get_result();

        $solicitacoes = [];

        while ($linha = $resultado->fetch_assoc()) {
            $solicitacao = new Solicitacao(
                $linha["id"],
                $linha["cpf"],
                $linha["pix"],
                $linha["foto"],
                $linha["decisao"],
                $linha["usuario_id"]
            );

            $solicitacoes[] = $solicitacao;
        }

        $query->close();
        $bd->close();

        return $solicitacoes;
    }

    public static function deleteSolicitacaoById($id) {
        $bd = ConectarSQL();
        $sql = "DELETE FROM Solicitacao WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);

        $sucesso = $query->execute();

        $query->close();
        $bd->close();

        return $sucesso;
    }
}
?>
