<?php
class Vehicle {
    protected $name;
    public function __construct($name) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("O nome do veículo não pode estar vazio");
        }
        $this->name = $name;
    }
    public function move() {
        return "está se movendo";
    }

    public function getName() {
        return $this->name;
    }
    public function getInfo() {
        return $this->getName() . " " . $this->move();
    }
}

// Classe para carros
class Car extends Vehicle {
    // Retorna o movimento específico de carro
    public function move() {
        return "fazendo drift";
    }
    
    // Método específico para carros
    public function honk() {
        return "Bibi!";
    }
}

// Classe para bicicleta
class Bike extends Vehicle {
    public function move() {
        return "dando grau";
    }
    public function pedal() {
        return "pedalando rapidamente";
    }
}

// Classe para aviões
class Airplane extends Vehicle {
    public function move() {
        return "está voando";
    }
    public function takeOff() {
        return "decolando para o céu";
    }
    public function land() {
        return "aterrissando suavemente";
    }
}

// Array de veículos para demonstração
$vehicles = [
    new Car("Mercedes AMG One"),
    new Bike("Caloi Explorer"),
    new Airplane("Boeing 747"),
    new Vehicle("Veículo Genérico")
];

echo "<style>
        .animal-list { 
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 10px; 
            width: 400px; 
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        .animal-item { 
            margin: 10px 0; 
            padding: 10px; 
            background: white; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
      </style>";

// Exibição da lista de veiculos
echo "<div class='animal-list'>";
echo "<h2>Lista de Veiculos</h2>";
foreach ($vehicles as $vehicle) {
    echo "<div class='animal-item'>";
    echo "<strong>{$vehicle->getName()}</strong><br>";
    echo "Movimento: <em>{$vehicle->move()}</em>";
    echo "</div>";
}
echo "</div>";
?>
