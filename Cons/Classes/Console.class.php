<?php
require_once ("Database.class.php");
class Console{
    private $id;
    private $ano;
    private $est;
    private $pre;
    private $marc;
    private $mode;
    private $anexo;

    // construtor da classe
    public function __construct($id,$ano,$est,$pre,$marc,$mode,$anexo){
        $this->id = $id;
        $this->ano = $ano;
        $this->est = $est;
        $this->pre = $pre;
        $this->marc = $marc;
        $this->mode = $mode;
        $this->anexo = $anexo;
        
    }

    // função / interface para aterar e ler
    public function setano($ano){
        if ($ano < 0)
            throw new Exception("Erro, o ano deve ser informado!");
        else
            $this->ano = $ano;
    }
    // cada atributo tem um método set para alterar seu valor
    public function setId($id){
        if ($id < 0)
            throw new Exception("Erro, a ID deve ser maior que 0!");
        else
            $this->id = $id;
    }

    /*public function setest($est){
            if ($est == "")
                throw new Exception("Erro, o estado deve informado!");
            else
                $this->est = $est;
    }*/
    public function setpre($pre){
            if ($pre < 0)
                throw new Exception("Erro, o preço deve informado!");
            else
                $this->pre = $pre;
    }
    public function setmarc($marc){
        if ($marc == "")
            throw new Exception("Erro, a marca deve ser informada!");
        else
            $this->marc = $marc;
    }
    public function setmode($mode){
        if ($mode == "")
            throw new Exception("Erro, o modelo deve ser informada!");
        else
            $this->mode = $mode;
    }

    // pre pode ser em branco por isso o parâmetro é opcional
    public function setest($est = ''){
        $this->est = $est;
    }

    public function getId(): int{
        return $this->id;
    }
    public function getano(): int{
        return $this->ano;
    }
    public function getest(): string{
        return $this->est;
    }
    public function getpre(): float{
        return $this->pre;
    }
    public function getmarc(): String{
        return $this->marc;
    }
    public function getmode(): String{
        return $this->mode;
    }
    public function getanexo(): String{
        return $this->anexo;
    }

    // método mágico para imprimir uma Console
    public function __toString():String{  
        $str = "Console: $this->id 
                 - ano: $this->ano
                 - est: $this->est
                 - pre: $this->pre
                 - marc: $this->marc
                 - mode: $this->mode
                 - anexo: $this->anexo";        
        return $str;
    }

    // insere uma Console no banco 
    public function inserir():Bool{
        // montar o sql/ query
        $sql = "INSERT INTO Console 
                    (ano, est, pre, marc, mode, anexo)
                    VALUES(:ano, :est, :pre , :marc, :mode, :anexo)";
        
        $parametros = array(':ano'=>$this->getano(),
                            ':est'=>$this->getest(),
                            ':pre'=>$this->getpre(),
                            ':marc'=>$this->getmarc(),
                            ':mode'=>$this->getmode(),
                            ':anexo'=>$this->getanexo());
        
        return Database::executar($sql, $parametros) == true;
    }

    public static function listar($tipo=0, $info=''):Array{
        $sql = "SELECT * FROM Console";
        switch ($tipo){
            case 0: break;
            case 1: $sql .= " WHERE id = :info ORDER BY id"; break; 
            case 2: $sql .= " WHERE ano like :info ORDER BY ano"; $info = '%'.$info.'%'; break; 
            case 3: $sql .= " WHERE est like :info ORDER BY est"; $info = '%'.$info.'%'; break;
            case 4: $sql .= " WHERE pre like :info ORDER BY pre"; $info = '%'.$info.'%'; break;
            case 5: $sql .= " WHERE marc like :info ORDER BY marc"; $info = '%'.$info.'%'; break;
            case 6: $sql .= " WHERE mode like :info ORDER BY mode"; $info = '%'.$info.'%'; break;
            case 7: $sql .= " WHERE anexo like :info ORDER BY anexo"; $info = '%'.$info.'%'; break;
        }
        $parametros = array();
        if ($tipo > 0)
            $parametros = [':info'=>$info];

        $comando = Database::executar($sql, $parametros);
        //$resultado = $comando->fetchAll();
        $Consoles = [];
        while ($registro = $comando->fetch()){
            $Console = new Console($registro['id'],$registro['ano'],$registro['est'],$registro['pre'],
                                        $registro['marc'],$registro['mode'],$registro['anexo']);
            array_push($Consoles,$Console);
        }
        return $Consoles;
    }

    public function alterar():Bool{       
       $sql = "UPDATE Console
                  SET ano = :ano, 
                      est = :est,
                      pre = :pre,
                      marc = :marc,
                      mode = :mode,
                      anexo = :anexo
                WHERE id = :id";
         $parametros = array(':id'=>$this->getid(),
                        ':ano'=>$this->getano(),
                        ':est'=>$this->getest(),
                        ':pre'=>$this->getpre(),
                        ':marc'=>$this->getmarc(),
                        ':mode'=>$this->getmode(),
                        ':anexo'=>$this->getanexo());
        return Database::executar($sql, $parametros) == true;
    }

    public function excluir():Bool{
        $sql = "DELETE FROM Console
                      WHERE id = :id";
        $parametros = array(':id'=>$this->getid());
        return Database::executar($sql, $parametros) == true;
     }
}

?>