<?php
class Order {
    private $items;

    public function __construct(){
        $this->items = [];
    }

    public function addItem($item){
        $this->items[] = $item;
    }

    public function listItems(){
        foreach($this->items as $item){
            echo "Item: " . $item . "<br>";
        }
    }

    public function getItems(){
        return $this->items;
    }
}

class OrderWithCustomer extends Order {
    private $customer;

    public function __construct($customer){
        parent::__construct(); // chama o construtor da classe pai
        $this->customer = $customer;
    }

    public function getCustomer(){
        return $this->customer;
    }

    // Polimorfismo: sobrescreve listItems()
    public function listItems(){
        echo "<b>Cliente: " . $this->customer . "</b><br>";
        parent::listItems(); // reaproveita o método da classe pai
    }
}

// Teste
$order = new OrderWithCustomer("George Russel");
$order->addItem("Mercedes W14");
$order->addItem("Mercedes AMG One");
$order->addItem("Mercedes EQE");
$order->listItems();
?>
