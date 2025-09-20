<?php
class Animal {
    protected $name;

    // Construtor da classe Animal
    public function __construct($name) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("O nome do animal não pode estar vazio");
        }
        $this->name = $name;
    }

    // Retorna o som genérico do animal    
    public function talk() {
        return "generic sound";
    }

    // Retorna o movimento genérico do animal
    public function move() {
        return "is moving";
    }

    // Obtém o nome do animal
    public function getName() {
        return $this->name;
    }
}

// Classe Cachorro que estende Animal
class Dog extends Animal {
    // Retorna o som específico de cachorro
    public function talk() {
        return "Woof woof!";
    }

    // Retorna o movimento específico de cachorro
    public function move() {
        return "is running";
    }
}

// Classe Gato que estende Animal
class Cat extends Animal {
    public function talk() {
        return "Meow meow";
    }
    public function move() {
        return "is scratching";
    }
}

// Classe Pássaro que estende Animal
class Bird extends Animal {
    public function talk() {
        return "Tweet tweet";
    }

    public function move() {
        return "is flying";
    }
}

// Array de animais 
$animals = [
    new Dog("George"),
    new Cat("Bella Swan"),
    new Bird("Zeca"),
    new Animal("Generic")
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

// Exibição da lista de animais
echo "<div class='animal-list'>";
echo "<h2>Lista de Animais</h2>";
foreach ($animals as $animal) {
    echo "<div class='animal-item'>";
    echo "<strong>{$animal->getName()}</strong><br>";
    echo "Som: <em>{$animal->talk()}</em><br>";
    echo "Movimento: <em>{$animal->move()}</em>";
    echo "</div>";
}
echo "</div>";
?>