<?php
class Product {
    public $name;
    public $price;

    // Construtor
    public function __construct($name = "", $price = 0) {
        $this->setName($name);
        $this->setPrice($price);
    }

    // Getter para name
    public function getName() {
        return $this->name;
    }

    // Setter para name
    public function setName($name) {
        // Nome não pode ser vazio
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            // Caso inválido
            $this->name = "Produto sem nome";
        }
    }

    // Getter para price
    public function getPrice() {
        return $this->price;
    }

    // Setter para price
    public function setPrice($price) {
        // Preço deve ser numérico e não negativo
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            // Caso inválido
            $this->price = 0;
        }
    }
}

// Instanciação do objeto Product
$product = new Product("Caneta", 2.5);

// Exibição dos valores usando os getters
echo "Nome: " . $product->getName() . "<br>";
echo "Preço: R$ " . number_format($product->getPrice(), 2, ',', '.') . "<br>";

// Justificativa:
// Os atributos foram definidos como públicos para atender ao enunciado, mas os métodos getters e setters foram implementados para garantir a validação dos dados.
// O uso de validação nos setters evita valores inválidos, mesmo com atributos públicos.
?>