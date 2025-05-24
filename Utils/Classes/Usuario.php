<?php
include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Portifolio.php";

class Usuario implements JsonSerializable {
    private $id;
    private $email;
    private $senha;
    private $nome;
    private $sobrenome;
    private $foto;
    private $cpf;
    private $vendedor;
    private $curador;
    private $pix;
    private $ativo;

    public function __construct($id, $email, $senha, $nome, $sobrenome, $foto, $cpf, $vendedor, $curador) {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->foto = $foto;
        $this->cpf = $cpf;
        $this->vendedor = $vendedor;
        $this->curador = $curador;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSobrenome() {
        return $this->sobrenome;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getPix() {
        return $this->pix;
    }

    public function isVendedor() {
        return $this->vendedor;
    }

    public function isCurador() {
        return $this->curador;
    }

    public function isAtivo() {
        return $this->ativo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setPix($pix) {
        $this->pix = $pix;
    }

    public function setVendedor($bool) {
        $this->vendedor = $bool;
    }

    public function setCurador($bool) {
        $this->curador = $bool;
    }

    public function setAtivo($bool) {
        $this->ativo = $bool;
    }

    public function cadastrar() {
        $this->setAtivo(true);

        $bd = ConectarSQL();
        $sql = "INSERT INTO Usuario(email, senha, nome, sobrenome, vendedor, curador, foto, ativo)
                VALUES (?, ?, ?, ?, false, false, ?, true)";

        $query = $bd->prepare($sql);
        $query->bind_param("sssss", $this->email, $this->senha, $this->nome, $this->sobrenome, $this->foto);

        $cadastrado = $query->execute();

        $query->close();
        $bd->close();

        return $cadastrado;
    }

    public function salvarUpdates() {
        $bd = ConectarSQL();

        $sql = "UPDATE Usuario SET nome = ?, sobrenome = ?, email = ?, senha = ?, foto = ?, vendedor = ?, curador = ?, pix = ?, cpf = ?, ativo = ?
                WHERE id = ?";

        $query = $bd->prepare($sql);
        $query->bind_param(
            "sssssiissi",
            $this->nome,
            $this->sobrenome,
            $this->email,
            $this->senha,
            $this->foto,
            $this->vendedor,
            $this->curador,
            $this->pix,
            $this->cpf,
            $this->ativo,
            $this->id
        );

        $atualizado = $query->execute();

        $query->close();
        $bd->close();

        return $atualizado;
    }

    public function criarPortifolio($foto, $titulo, $descricao) {
        $bd = ConectarSQL();
        $sql = "INSERT INTO Portifolio(foto, titulo, descricao, usuario_id) VALUES (?, ?, ?, ?)";

        $query = $bd->prepare($sql);
        $query->bind_param("sssi", $foto, $titulo, $descricao, $this->id);
        $cadastrado = $query->execute();

        $query->close();
        $bd->close();

        return $cadastrado;
    }

    public function jsonSerialize() {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "nome" => $this->nome,
            "sobrenome" => $this->sobrenome,
            "foto" => $this->foto,
            "cpf" => $this->cpf,
            "vendedor" => $this->vendedor,
            "curador" => $this->curador,
            "pix" => $this->pix ?? null,
            "ativo" => $this->ativo
        ];
    }

    public static function findUsuarioById($id) {
        $BD = ConectarSQL();
        $sql = "SELECT * FROM Usuario WHERE id = ?";

        $query = $BD->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $resultado = $query->get_result();

        if ($resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();

            $usuario = new Usuario(
                $id,
                $linha["email"],
                $linha["senha"],
                $linha["nome"],
                $linha["sobrenome"],
                $linha["foto"],
                $linha["cpf"],
                $linha["vendedor"],
                $linha["curador"]
            );

            if (isset($linha["pix"])) {
                $usuario->setPix($linha["pix"]);
            }

            if (isset($linha["ativo"])) {
                $usuario->setAtivo($linha["ativo"]);
            }

            $query->close();
            $BD->close();

            return $usuario;
        } else {
            $query->close();
            $BD->close();
            return null;
        }
    }

    public static function findUsuarioByEmail($email) {
        $BD = ConectarSQL();
        $sql = "SELECT * FROM Usuario WHERE email = ?";

        $query = $BD->prepare($sql);
        $query->bind_param("s", $email);
        $query->execute();
        $resultado = $query->get_result();

        if ($resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();

            $usuario = new Usuario(
                $linha["id"],
                $linha["email"],
                $linha["senha"],
                $linha["nome"],
                $linha["sobrenome"],
                $linha["foto"],
                $linha["cpf"],
                $linha["vendedor"],
                $linha["curador"]
            );

            if (isset($linha["pix"])) {
                $usuario->setPix($linha["pix"]);
            }

            if (isset($linha["ativo"])) {
                $usuario->setAtivo($linha["ativo"]);
            }

            $query->close();
            $BD->close();
            return $usuario;
        } else {
            $query->close();
            $BD->close();
            return null;
        }
    }

    public static function findUsuariosByFuncao($funcao) {
        $BD = ConectarSQL();

        if ($funcao === "curador") {
            $sql = "SELECT * FROM Usuario WHERE curador = 1";
        } else if ($funcao === "vendedor") {
            $sql = "SELECT * FROM Usuario WHERE vendedor = 1";
        } else if ($funcao === "cliente") {
            $sql = "SELECT * FROM Usuario WHERE cpf IS NOT NULL";
        } else {
            $sql = "SELECT * FROM Usuario";
        }

        $query = $BD->prepare($sql);
        $query->execute();

        $resultado = $query->get_result();
        $usuarios = [];

        while ($linha = $resultado->fetch_assoc()) {
            $usuario = new Usuario(
                $linha["id"],
                $linha["email"],
                $linha["senha"],
                $linha["nome"],
                $linha["sobrenome"],
                $linha["foto"],
                $linha["cpf"],
                $linha["vendedor"],
                $linha["curador"]
            );

            if (isset($linha["pix"])) {
                $usuario->setPix($linha["pix"]);
            }

            if (isset($linha["ativo"])) {
                $usuario->setAtivo($linha["ativo"]);
            }

            $usuarios[] = $usuario;
        }

        $query->close();
        $BD->close();
        return $usuarios;
    }

    public static function deleteUsuarioById($id) {
        $bd = ConectarSQL();
        $sql = "DELETE FROM Usuario WHERE id = ?";
        $query = $bd->prepare($sql);
        $query->bind_param("i", $id);

        $sucesso = $query->execute();

        $query->close();
        $bd->close();

        return $sucesso;
    }
}
?>
