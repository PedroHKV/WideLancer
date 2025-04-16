<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";

    class Portifolio{

        private $id;
        private $foto;
        private $titulo;
        private $descricao;
        private $usuario_id;

        //construtores
        public function __construct($foto, $titulo, $descricao, $usuario_id){
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

        //metodos publicos

    }
?>