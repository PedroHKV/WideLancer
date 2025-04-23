<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    class Chat{

        private $id;
        private $solicitante;
        private $anunciante;

        //getters e setters
        
        public function getId(){
            return $this->id;
        }

        public function getSolicitante(){
            return $this->solicitante;
        }

        public function getAnunciante(){
            return $this->anunciante;
        }

        //construtores
        public function __construct($id, $solicitante, $anunciante){
            $this->id = $id;
            $this->solicitante = $solicitante;
            $this->anunciante = $anunciante;
        }

        //metodos publicos

        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Chat(anunciante_id, solicitante_id) VALUES (?, ?);";
            $query = $bd->prepare($sql);
            $query->bind_param("ii", $this->anunciante, $this->solicitante);
            $cadastrado = $query->execute(); 
            $bd->close();
            return $cadastrado;
        }

        //metodos estaticos
        public static function findChatById($id){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Chat WHERE id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $result = $query->get_result();

            $linha = $result->fetch_assoc();

            $chat = new Chat(
                $linha["id"], $linha["solicitante_id"], $linha["anunciante_id"]
            );


            $bd->close();
            return $chat;
        }

        public static function findChatByParticipantes($solicitante, $anunciante){
            //os parametros sao ID's
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Chat WHERE solicitante_id = ? AND anunciante_id = ?;";
            $query = $bd->prepare($sql);
            $query->bind_param("ii", $solicitante, $anunciante);
            $query->execute();
            $result = $query->get_result();
            $linha = $result->fetch_assoc();

            if ( $linha ){
    
                $chat = new Chat(
                    $linha["id"], $linha["solicitante_id"], $linha["anunciante_id"]
                );
    
                $bd->close();
                return $chat;

            } else { return NULL ; }
        }

        public static function findChatsByUsuarioId($id){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM CHAT WHERE anunciante_id = ? OR solicitante_id = ?;";
            $query = $bd->prepare($sql);
            $query->bind_param("ii", $id, $id);
            $query->execute(); 
            $result = $query->get_result();
            $chats = [];
            while ($linha = $result->fetch_assoc()) {
                $chat = new Chat($linha["id"], $linha["solicitante_id"], $linha["anunciante_id"]);
                $chats[] = $chat;
        }   
        return $chats;
    }
}


?>