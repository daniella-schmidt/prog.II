<?php
class Carro {
    // Atributos
    public $marca;
    public $modelo;
    public $ano;
    
    // Construtor
    public function __construct($marca, $modelo, $ano) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
    } 
    
    // Método
    public function exibirDados() {
        echo "<br><strong>Detalhes:</strong>";
        echo "<br>Marca: {$this->marca}";
        echo "<br>Modelo: {$this->modelo}";
        echo "<br>Ano: {$this->ano}";
    }
}

// Instância
$p1 = new Carro("Mercedes", "Mercedes AMG One", 2022);
$p1->exibirDados();
?>
