<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";

    class Denuncia implements JsonSerializable{

        private $id;
        private $motivo;
        private $pendente;
        private $decisao;
        private $delator;
        private $anuncio_id;

        // Construtor não padrão
        public function __construct($motivo, $pendente, $delator, $anuncio_id, $decisao = null, $id = null){
            $this->motivo = $motivo;
            $this->pendente = $pendente;
            $this->delator = $delator;
            $this->anuncio_id = $anuncio_id;
            $this->decisao = $decisao;
            $this->id = $id;
        }

        // Getters e setters
        public function getId() {
            return $this->id;
        }

        public function getMotivo() {
            return $this->motivo;
        }

        public function getPendente() {
            return $this->pendente;
        }

        public function getDecisao() {
            return $this->decisao;
        }

        public function getDelator() {
            return $this->delator;
        }

        public function getAnuncioId() {
            return $this->anuncio_id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setMotivo($motivo) {
            $this->motivo = $motivo;
        }

        public function setPendente($pendente) {
            $this->pendente = $pendente;
        }

        public function setDecisao($decisao) {
            $this->decisao = $decisao;
        }

        public function setDelator($delator) {
            $this->delator = $delator;
        }

        public function setAnuncioId($anuncio_id) {
            $this->anuncio_id = $anuncio_id;
        }

        //metodos públicos
        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Denuncia(motivo, pendente, delator, anuncio_id) VALUES (?, ?, ?, ?)";

            $query = $bd->prepare($sql);
            $query->bind_param("siii", $this->motivo, $this->pendente, $this->delator, $this->anuncio_id);
            $cadastrado = $query->execute();

            return $cadastrado;
        }

        public function salvarUpdates(){
            $bd = ConectarSQL();
            $sql = "UPDATE Denuncia SET motivo = ?, pendente = ?, decisao = ?, delator = ?, anuncio_id = ? WHERE id = ?";

            $query = $bd->prepare($sql);
            $query->bind_param(
                "sisiii",
                $this->motivo,
                $this->pendente,
                $this->decisao,
                $this->delator,
                $this->anuncio_id,
                $this->id
            );

            $atualizado = $query->execute();
            $query->close();
            $bd->close();

            return $atualizado;
        }

        public function jsonSerialize() {
            $delator = Usuario::findUsuarioById($this->delator);
            $anuncio = Anuncio::findAnuncioById($this->anuncio_id);
            $acusado = Usuario::findUsuarioById($anuncio->getUsuarioId());
            return [
                'id' => $this->id,
                'motivo' => $this->motivo,
                'pendente' => $this->pendente,
                'decisao' => $this->decisao,
                'delator' => $delator->getNome()." ".$delator->getSobrenome(),
                'anuncio_id' => $this->anuncio_id,
                'acusado' => $acusado->getNome()." ".$acusado->getSobrenome()
            ];
    }

        //metodos estáticos
        public static function carregarDenuncias(){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Denuncia";

            $query = $bd->prepare($sql);
            $query->execute();
            $resultado = $query->get_result();

            $denuncias = [];
            while( $linha = $resultado->fetch_assoc()){

                $denuncia = new Denuncia(
                    $linha["motivo"],
                    $linha["pendente"],
                    $linha["delator"],
                    $linha["anuncio_id"],
                    $linha["decisao"] ,
                    $linha["id"]);

                $denuncias[] = $denuncia;    

            }

            return $denuncias;
        }

        public static function findDenunciaById($id){
            $BD = ConectarSQL();
            $sql = "SELECT * FROM Denuncia WHERE id = ?";

            $query = $BD->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $resultado = $query->get_result();

            if ( $resultado->num_rows > 0){
                $linha = $resultado->fetch_assoc();
                
                $denuncia = new Denuncia(
                    $linha["motivo"],
                    $linha["pendente"],
                    $linha["delator"],
                    $linha["anuncio_id"],
                    $linha["decisao"] ,
                    $linha["id"]);
                 
                 $query->close();
                 $BD->close();
                return $denuncia;
            } else {
                $query->close();
                $BD->close();
                return null;
            }
        }

        public static function findDenunciasByVendedorId($id){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM ViewDenunciasComUsuarios WHERE acusado_id = ?";

            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $resultado = $query->get_result();

            $denuncias = [];
            while( $linha = $resultado->fetch_assoc()){

                $denuncia = new Denuncia(
                    $linha["motivo"],
                    $linha["pendente"],
                    $linha["delator_id"],
                    $linha["anuncio_id"],
                    $linha["decisao"] ,
                    $linha["denuncia_id"]);

                $denuncias[] = $denuncia;    
            }

            return $denuncias;
        }
    }
?>