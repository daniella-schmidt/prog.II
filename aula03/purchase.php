<?php
class Item{
    public $id;
    public $name;
    public $description;
    public $price;
    public $quantity;

    public function __construct($id, $name, $description, $price, $quantity){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}
class Carrinho{
    public $items = [];

    public function addItem(Item $item){
        $this->items[] = $item;
    }

    public function calcularTotal(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item->price * $item->quantity;
        }
        return $total;
    }

    public function exibirItens(){
        foreach($this->items as $item){
            echo "ID: {$item->id}, Nome: {$item->name}, Descrição: {$item->description}, Preço: R$ {$item->price}, Quantidade: {$item->quantity}<br>";
        }
    }
}
$carrinho = new Carrinho();
$item1 = new Item(1, "Notebook", "Notebook Dell Inspiron", 3500, 1);
$item2 = new Item(2, "Mouse", "Mouse sem fio Logitech", 150, 2);
$carrinho->addItem($item1);
$carrinho->addItem($item2);

$total = $carrinho->calcularTotal();
echo "<br>Total da Compra: R$ $total<br>";
$carrinho->exibirItens();
?>