<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    class Chat{

        private $id;
        private $solicitante;
        private $anunciante;
        private $mensagens;

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

        public function getMensagens(){
            return $this->mensagens;
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

        public function carregarMensagens(){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM MensagensView WHERE chat_id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $this->id);
            $query->execute();
            $result = $query->get_result();

            $mensagens = [];
            while($linha = $result->fetch_assoc()){
                $tipo = $linha["tipo"];
                if ( $tipo === "mensagem_comum" ){
                    $mensagem = new MensagemComum(
                        $linha["id"],
                        $linha["texto"],
                        $linha["imagem"],
                        $linha["horario"],
                        $linha["chat_id"],
                        $linha["usuario_id"],
                    );
                    $mensagens[] = $mensagem;

                } else if ( $tipo === "proposta"){
                    $mensagem = new Proposta(
                        $linha["id"],
                        $linha["orcamento"],
                        $linha["prazo"],
                        $linha["aceita"],
                        $linha["usuario_id"],
                        $linha["chat_id"],
                        $linha["horario"],
                    );
                    $mensagens[] = $mensagem;
                } else if ( $tipo === "produto"){
                    $mensagem = new MensagemProduto(
                        $linha["id"],
                        $linha["adquirido"],
                        $linha["caminho"],
                        $linha["usuario_id"],
                        $linha["chat_id"],
                        $linha["horario"]
                    );
                    $mensagens[] = $mensagem;
                } else {
                    echo "erro ap carregar mensagens";
                }
            }
            return $mensagens;

        }

        public function getVendaPendente(){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Venda WHERE chat_id = ? AND andamento = TRUE;";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $this->id);
            $query->execute();
            $result = $query->get_result();
            $linha = $result->fetch_assoc();

            $bd->close();

            if ($linha) {
                $venda = new Venda(
                    $linha["id"],
                    $linha["data_init"],
                    $linha["data_termino"],
                    $linha["andamento"],
                    $linha["chat_id"]
                );
                $venda->setPreco($linha["preco"]);
                return $venda;
            }

            return null;
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