<?php
class Retangulo {
    public $largura;
    public $altura;
    public function __construct($largura, $altura) {
        $this->largura = $largura;
        $this->altura = $altura;
    }

    public function getArea() {
        return $this->largura * $this->altura;
    }

    public function exibirArea() {
        $area = $this->getArea();
        echo "<br>A área do retângulo é: $area<br>";
    }
}
$p1 = new Retangulo(4, 7);
$p2 = new Retangulo(5,7);
$p1->exibirArea();
$p2->exibirArea();
?>