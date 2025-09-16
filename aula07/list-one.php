<?php
class Animal {
  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function talk() {
    return "generic sound";
  }

  public function move() {
    return "is moving";
  }

  public function getName() {
    return $this->name;
  }
}

class Dog extends Animal {
  public function talk() {
    return "Woof woof!";
  }

  public function move() {
    return "is running";
  }
}

class Cat extends Animal {
  public function talk() {
    return "Meow meow";
  }

  public function move() {
    return "is scratching";
  }
}

class Bird extends Animal {
  public function talk() {
    return "Tweet tweet";
  }

  public function move() {
    return "is flying";
  }
}

$animals = [
  new Dog("George"),
  new Cat("Bella Swan"),
  new Bird("Zeca"),
  new Animal("Generic")
];

echo "<h2>Lista de Animais</h2>";
echo "<ul>";
foreach ($animals as $animal) {
  echo "<li><strong>{$animal->getName()}</strong><br>";
  echo "Som: <em>{$animal->talk()}</em><br>";
  echo "Movimento: <em>{$animal->move()}</em>";
  echo "</li><br>";
}
echo "</ul>";

function AnimalSpeaking(Animal $animal) {
  echo "<p><strong>{$animal->getName()}</strong> diz: <em>{$animal->talk()}</em></p>";
}

echo "<h2>Animais falando:</h2>";
AnimalSpeaking(new Dog("Buddy"));
AnimalSpeaking(new Cat("Whiskers"));
AnimalSpeaking(new Bird("Frajola"));

class TalkingDog extends Dog {
  public function talk() {
    return parent::talk() . " Hi, I'm a talking dog!";
  }
}

$TalkingDog = new TalkingDog("Lassie");
echo "<h2>Exemplo de Sobrescrita</h2>";
echo "<p><strong>{$TalkingDog->getName()}</strong>: {$TalkingDog->talk()}</p>";
?>
