<?php
class Product{
    private $price;

    public function __construct(){
        $this->price = 0.0;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        if (is_numeric($price) && $price >= 0){
            $this->price = $price;
        } else {
            echo "Preço inválido. O preço não pode ser negativo.<br>";
        }
    }

    public function displayPrice(){
        echo "Preço do produto: R$" . number_format($this->getPrice(), 2) . "<br>";
    }
}
// Teste
$product = new Product();
$product->displayPrice(); // Preço inicial
$product->setPrice(150.75); // Definindo preço válido
$product->displayPrice(); // Preço após definição
$product->setPrice(-20); // Tentativa de definir preço negativo
$product->displayPrice(); // Preço após tentativa inválida
?>