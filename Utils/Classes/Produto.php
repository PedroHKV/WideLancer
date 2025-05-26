<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    
    class Produto implements JsonSerializable{
        
        private $id;
        private $caminho;
        private $usuario_id;
        private $data;

        //construtores
        function __construct($id, $caminho, $usuario_id){
            $this->id = $id;
            $this->caminho = $caminho;
            $this->usuario_id = $usuario_id;
        }

        public function getId(){
            return $this->id;
        }

        public function getData(){
            return $this->data;
        }

        public function getCaminho(){
            return $this->caminho;
        }

        public function getUsuarioId(){
            return $this->usuario_id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function setCaminho($caminho){
            $this->caminho = $caminho;
        }

        public function setData($data){
            $this->data = $data;
        }

        public function setUsuarioId($usuario_id){
            $this->usuario_id = $usuario_id;
        }

        public function cadastrar() {
            $bd = ConectarSQL();
            $sql = "INSERT INTO Produto (caminho, usuario_id, data ) VALUES (?, ?, ?)";
            $query = $bd->prepare($sql);
            $query->bind_param("sis", $this->caminho, $this->usuario_id, $this->data);
            $cadastrado = $query->execute();
            $query->close();
            $bd->close();

            return $cadastrado;
        }

        public static function findProdutoById($id) {
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Produto WHERE id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $resultado = $query->get_result();
            if ($resultado->num_rows > 0) {
                $linha = $resultado->fetch_assoc();
                $produto = new Produto($linha["id"], $linha["caminho"], $linha["usuario_id"]);
                $produto->setData($linha["data"]);
                $query->close();
                $bd->close();
                return $produto;
            } else {
                $query->close();
                $bd->close();
                return null;
            }
        }

        public static function findProdutosByUsuarioId($usuario_id) {
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Produto WHERE usuario_id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $usuario_id);
            $query->execute();
            $resultado = $query->get_result();
            $produtos = [];
            while ($linha = $resultado->fetch_assoc()) {
                $produto = new Produto($linha["id"], $linha["caminho"], $linha["usuario_id"]);
                $produto->setData($linha["data"]);
                $produtos[] = $produto;
            }
            $query->close();
            $bd->close();
            return $produtos;
        }

        public static function deleteProdutoById($id) {
            $bd = ConectarSQL();
            $sql = "DELETE FROM Produto WHERE id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $sucesso = $query->execute();
            $query->close();
            $bd->close();
            return $sucesso;
        }

        public function jsonSerialize() {
            return [
                "id" => $this->id,
                "caminho" => $this->caminho,
                "usuario_id" => $this->usuario_id,
                "data" => $this->data
            ];
        }
    }
?>