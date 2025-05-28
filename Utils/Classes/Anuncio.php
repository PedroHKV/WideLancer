<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    class Anuncio{
        private $id;
        private $foto;
        private $titulo;
        private $descricao;
        private $portifolio;
        private $usuario_id; 
        private $ativo;

        
        public function __construct($id, $foto, $titulo, $descricao, $usuario_id, $portfolio_id = null){
            $this->id = $id;
            $this->foto = $foto;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->usuario_id = $usuario_id;
            $this->portfolio = $portfolio_id;

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
        public function getAtivo(){
            return $this->ativo;
        }

        public function setPortifolio($id_port){
            $this->portifolio = $id_port;
        }

        public function setAtivo($ativo){
            $this->ativo = $ativo;
        }

        //metodos publicos
        public function cadastrar(){
            $cadastrado = false;
            $bd = ConectarSQL();
            $sql = "INSERT INTO Anuncio(titulo, foto, descricao, usuario_id, ativo) VALUES (?, ?, ?, ?, ?);";

            $query = $bd->prepare($sql);
            $query->bind_param("sssii", $this->titulo, $this->foto, $this->descricao, $this->usuario_id, $this->ativo);

            $cadastrado = $query->execute();
            return $cadastrado;
        } 

        public function salvarUpdates(){
            $bd = ConectarSQL();

            $sql = 
            "UPDATE Anuncio SET foto = ?, titulo = ?, descricao = ?, ativo = ? WHERE id = ?";

            $query = $bd->prepare($sql);
            $query->bind_param("sssii", 
            $this->foto, $this->titulo, $this->descricao, $this->ativo, $this->id);
            $atualizado = $query->execute();
            $bd->close();
            return $atualizado;
        }

        //metodos estaticos
        public static function findAnunciosByQuery($pesquisaRaw) {
            $bd = ConectarSQL();
            $anuncios = [];
        
            $pesquisa = urldecode($pesquisaRaw);
            $termos = array_filter(explode(' ', $pesquisa));
        
            if (empty($termos)) return $anuncios;
        
            $condicoes = implode(' OR ', array_fill(0, count($termos), 'titulo LIKE ?'));
            $sql = "SELECT * FROM Anuncio WHERE $condicoes";
        
            $stmt = $bd->prepare($sql);
        
            $tipos = str_repeat('s', count($termos));
            $params = array_map(fn($t) => '%' . $t . '%', $termos);
        
            $stmt->bind_param($tipos, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $idsAdicionados = [];
        
            while ($row = $result->fetch_assoc()) {
                if (!in_array($row['id'], $idsAdicionados)) {
                    $anunc = new Anuncio(
                        $row["id"],
                        $row["foto"],
                        $row["titulo"],
                        $row["descricao"],
                        $row["usuario_id"],
                        $row["portifolio_id"]
                    );
                    $anunc->setAtivo( $row['ativo']);
                    $anuncios[] = $anunc;
                    $idsAdicionados[] = $row['id'];
                }
            }
        
            $bd->close();
            return $anuncios;
        }

        public static function findAnunciosByUserId($id) {
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Anuncio WHERE usuario_id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $result = $query->get_result();
            $anuncios = [];
            while ($linha = $result->fetch_assoc()){
                $anuncio = new Anuncio(
                    $linha["id"],
                    $linha["foto"],
                    $linha["titulo"],
                    $linha["descricao"],
                    $linha["usuario_id"],
                    $linha["portifolio_id"]
                );
                $anuncio->setAtivo( $linha['ativo']);
                $anuncios[] = $anuncio;
            }
            $bd->close();
            return $anuncios;
        }

        public static function findAnuncioById($id){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Anuncio WHERE id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $result = $query->get_result();
            $linha = $result->fetch_assoc();
            
            $anuncio = new Anuncio(
                $linha["id"],
                $linha["foto"],
                $linha["titulo"],
                $linha["descricao"],
                $linha["usuario_id"],
                $linha["portifolio_id"]);
                
            $bd->close();
            return $anuncio;
        }

        public static function deleteAnuncioById($id){
            $anuncio = Anuncio::findAnuncioById($id);
            $anuncio->setAtivo(0);
            $anuncio->salvarUpdates();
        }
    }
?>