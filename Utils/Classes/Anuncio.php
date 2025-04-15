<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";

    class Anuncio{
        private $id;
        private $foto;
        private $titulo;
        private $descricao;
        private $portifolio;
        private $usuario_id;

        
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

        public function getUsuarioId(){
            return $this->usuario_id;
        }

        public function setPortifolio($id_port){
            $this->portifolio = $id_port;
        }

        //metodos publicos
        public function cadastrar(){
            $cadastrado = false;
            $bd = ConectarSQL();
            $sql = "INSERT INTO Anuncio(titulo, foto, descricao, usuario_id) VALUES (?, ?, ?, ?);";

            $query = $bd->prepare($sql);
            $query->bind_param("sssi", $this->titulo, $this->foto, $this->descricao, $this->usuario_id);

            $cadastrado = $query->execute();
            return $cadastrado;
        }
    }
?>