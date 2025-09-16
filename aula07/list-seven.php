<?php
class Vehicle {
  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function move() {
    return "está movendo";
  }

  public function getName() {
    return $this->name;
  }
}

class Car extends Vehicle {
  public function move() {
    return "fazendo drift";
  }
}

class Bike extends Vehicle {

  public function move() {
    return "dando grau";
  }
}

class Airplane extends Vehicle {
  public function move() {
    return "está voando";
  }
}

$Vehicles = [
  new Car("Mercedes AMG One"),
  new Bike("Caloi Explorer"),
  new Airplane("Boing 747"),
  new Vehicle("Generic")
];

echo "<h2>Lista de Animais</h2>";
echo "<ul>";
foreach ($Vehicles as $Vehicle) {
  echo "<li><strong>{$Vehicle->getName()}</strong><br>";
  echo "Movimento: <em>{$Vehicle->move()}</em>";
  echo "</li><br>";
}
echo "</ul>";
?>
