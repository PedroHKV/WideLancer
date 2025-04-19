<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    class Anuncio{
        private $id;
        private $foto;
        private $titulo;
        private $descricao;
        private $portifolio;
        private $usuario_id; 

        
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
                $anuncios[] = $anuncio;
            }
            $bd->close();
            return $anuncios;
        }

        public static function deleteAnuncioById($id){
            $bd = ConectarSQL();
            $sql = "DELETE FROM Anuncio WHERE id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $excluido = $query->execute();
            $bd->close();
            return $excluido;
        }
    }
?>