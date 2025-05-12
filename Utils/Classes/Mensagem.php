<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    
    class Mensagem{
        
        protected $id;
        protected $horario;
        protected $chat_id;
        protected $usuario_id;
        protected $tipo;

        //construtores
        function __construct($id, $horario, $chat_id, $usuario_id, $tipo){
            $this->id = $id;
            $this->horario = $horario;
            $this->chat_id = $chat_id;
            $this->usuario_id = $usuario_id;
            $this->tipo = $tipo;
        }


        //getters e setters

        public function getId(){
            return $this->id;
        }

        public function getHorario(){
            return $this->horario;
        }

        public function getChatId(){
            return $this->chat_id;
        }

        public function getUsuarioId(){
            return $this->usuario_id;
        }

        public function getTipo(){
            return $this->tipo;
        }

        public function setTipo( $tipo){
            $this->tipo = $tipo;
        }


        //metodos protegidos

        protected function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Mensagem(tipo, horario, chat_id, usuario_id) VALUES (?, ?, ?, ?);";
            $query = $bd->prepare($sql);
            $proposta = false;
            $query->bind_param("ssii", $this->tipo, $this->horario, $this->chat_id, $this->usuario_id);
            $cadastrado =  $query->execute();
            $bd->close();
            return $cadastrado ;
        }
        
        //metodos estaticos

    }

?>