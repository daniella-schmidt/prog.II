<?php
class Compra{
    private $preco;
    private $desconto;

    public function __construct($preco, $desconto) {
        $this->preco = $preco;
        $this->desconto = $desconto;
    }

    public function calcularPrecoFinal() {
        return $this->preco - ($this->preco * $this->desconto);
    }
}

$compra = new Compra(100, 0.1);
echo $compra->calcularPrecoFinal(); 
?>
}

?>