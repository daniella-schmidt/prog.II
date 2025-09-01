<?php
class Config{
    protected $parameters;

    public function __construct(){
        $this->parameters = [];
    }

    public function setParameter($key, $value){
        $this->parameters[$key] = $value;
    }

    public function getParameter($key){
        return $this->parameters[$key] ?? null;
    }

    public function displayParameters(){
        foreach($this->parameters as $key => $value){
            echo "$key: $value<br>";
        }
    }
}
class AdvancedConfig extends Config{
    public function __construct(){
        parent::__construct();
    }

    // Polimorfismo: sobrescreve displayParameters()
    public function displayParameters(){
        echo "<b>Configurações Avançadas:</b><br>";
        parent::displayParameters(); // reaproveita o método da classe pai
    }

    public function removeParameter($key){
        unset($this->parameters[$key]);
    }
}
// Teste
$config = new AdvancedConfig();
$config->setParameter("host", "localhost");
$config->setParameter("port", 3306);
$config->setParameter("user", "root");
$config->displayParameters(); // Exibe os parâmetros configurados   
$config->removeParameter("port");
echo "<br>Após remover a porta:<br>";
$config->displayParameters(); // Exibe os parâmetros após remoção
?>