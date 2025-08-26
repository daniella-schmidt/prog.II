<?php
class Product {
    public $name;
    private $price;

    // Construtor 
    public function __construct($name = "", $price = 0) {
        $this->setName($name);
        $this->setPrice($price);
    }

    // Setter para name
    public function setName($name) {
        // Validação: nome não pode ser vazio
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Produto sem nome";
        }
    }

    // Getter para name
    public function getName() {
        return $this->name;
    }

    // Setter para price
    public function setPrice($price) {
        // Preço deve ser numérico e não negativo
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            // Caso de entrada inválida
            $this->price = 0; 
        }
    }

    // Getter para price
    public function getPrice() {
        return $this->price;
    }
}

// Instanciação 
$product = new Product("Caderno", 3.75);
echo "Nome: " . $product->getName() . "<br>";
echo "Preço: R$ " . number_format($product->getPrice(), 2, ',', '.') . "<br>";

// Justificativa:
// O atributo price foi tornado privado para garantir encapsulamento e proteger o valor de alterações externas indevidas.
// Getters e setters permitem validação dos dados e controle de acesso.
?>
