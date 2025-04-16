<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";

    class Portifolio{

        private $id;
        private $foto;
        private $titulo;
        private $descricao;
        private $usuario_id;

        //construtores
        public function __construct($id, $foto, $titulo, $descricao, $usuario_id){
            $this->id = $id;
            $this->foto = $foto;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->usuario_id = $usuario_id;
        }

        //getters e setters
        public function getId(){
            return $this->id;
        }

        public function getFoto(){
            return $this->foto;
        }

        public function getTitulo(){
            return $this->titulo;
        }

        public function getDescricao(){
            return $this->descricao;
        }

        public function getUsuario_id(){
            return $this->usuario_id;
        }

        public function setFoto($foto){
            $this->foto = $foto;
        }

        public function setTitulo($titulo){
            $this->titulo = $titulo;
        }

        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        //metodos publicos
        
        public function salvarUpdates(){
            $bd = ConectarSQL();

            $sql = 
            "UPDATE Portifolio SET foto = ?, titulo = ?, descricao = ? ".
            "WHERE id = ".$this->getId();

            $query = $bd->prepare($sql);
            $query->bind_param("sss", 
            $this->foto, $this->titulo, $this->descricao
            );
            $atualizado = $query->execute();
            $bd->close();
            return $atualizado;
        }
        



        //metodos estaticos
        public static function findPortifolioByUsuario_id($usuario_id){
            $bd = ConectarSQL();
            $sql = 
            "SELECT * FROM Portifolio WHERE usuario_id = ? ;";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $usuario_id);
            $query->execute();

            $resultado = $query->get_result();
            //como so tem um registro pra esse id
            $dados = $resultado->fetch_assoc();
            $bd->close();
            if (isset($dados["id"])){
                $portifolio = new Portifolio($dados["id"], $dados["foto"], $dados["titulo"], $dados["descricao"], $usuario_id);
                return $portifolio;
            } else {
                return new Portifolio(Null, Null, Null, Null, Null);
            }

        }

    }
?>