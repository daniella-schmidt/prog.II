<?php
class ShoppingCart{
    private $total;

    public function __construct(){
        $this->total = 0;
    }

   public function addToTotal($amount){
        $this->total += $amount;
    }


    public function getTotal(){
        return $this->total;
    }

    public function displayTotal(){
        echo "Total do carrinho: R$ " . number_format($this->getTotal(), 2, ',', '.') . "<br>";
    }
}
class ShoppingCartWithDiscount extends ShoppingCart {
    private $discountRate;

    public function __construct($discountRate){
        parent::__construct(); // chama o construtor da classe pai
        $this->discountRate = $discountRate;
    }

    public function applyDiscount(){
        $discountAmount = $this->getTotal() * ($this->discountRate / 100);
        $this->addToTotal(-$discountAmount); // aplica o desconto subtraindo do total
    }

    public function displayTotal(){
        parent::displayTotal(); // reaproveita o método da classe pai
        echo "Desconto aplicado: " . $this->discountRate . "%<br>";
    }
}
// Teste
$cart = new ShoppingCartWithDiscount(10); // 10% de desconto
$cart->addToTotal(200);
$cart->addToTotal(150);
$cart->displayTotal(); // Exibe o total antes do desconto
$cart->applyDiscount(); // Aplica o desconto
$cart->displayTotal(); // Exibe o total após o desconto

?>