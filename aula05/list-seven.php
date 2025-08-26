<?php
class Order {
    // items é privado para garantir encapsulamento e integridade dos dados
    private $items = [];
    // price é privado, calculado automaticamente
    private $price = 0;
    // name é protegido para possível herança
    protected $name;

    // Construtor
    public function __construct($name) {
        $this->setName($name);
    }

    // Getter cliente
    public function getName() {
        return $this->name;
    }

    // Setter para cliente com validação
    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Sem cliente";
        }
    }

    // Adiciona um item ao pedido 
    public function addItem($item) {
        if ($item instanceof Product) {
            $this->items[] = $item;
            $this->updatePrice();
        }
    }

    public function getItems() {
        return $this->items;
    }

    // Lista os itens do pedido
    public function listItems() {
        if (empty($this->items)) {
            echo "Nenhum item no pedido.<br>";
        } else {
            foreach ($this->items as $item) {
                echo "Item: " . $item->getName() . " - Preço: R$ " . number_format($item->getPrice(), 2, ',', '.') . "<br>";
            }
        }
    }

    // Atualiza o preço total do pedido
    private function updatePrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPrice();
        }
        $this->price = $total;
    }

    // Getter para preço total
    public function getPrice() {
        return $this->price;
    }
}

// Classe Product 
class Product {
    private $name;
    private $price;

    public function __construct($name, $price) {
        $this->setName($name);
        $this->setPrice($price);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Sem nome";
        }
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            $this->price = 0;
        }
    }
}

// Instanciação
$order = new Order("Ollie Bearman");
$item1 = new Product("Margaridas", 2.5);
$item2 = new Product("Rosa Vermelha", 15.0);
$item3 = new Product("Tulipa Rosa", 8.2);
$item4 = new Product("Hortencias",12);

$order->addItem($item1);
$order->addItem($item2);
$order->addItem($item3);
$order->addItem($item4);
$order->addItem($item1);
$order->addItem($item3);


$order->listItems();
echo "Cliente: " . $order->getName() . " | Total do pedido: R$ " . number_format($order->getPrice(), 2, ',', '.') . "<br>";

// Justificativa:
// O atributo items é privado para garantir que apenas métodos controlados possam modificar os itens do pedido.
// O preço total é calculado automaticamente para evitar inconsistências.
// A classe Product foi criada para separar a lógica de produto da lógica de pedido, promovendo organização e reuso.
// Getters e setters validam os dados e facilitam manutenção.
?>
