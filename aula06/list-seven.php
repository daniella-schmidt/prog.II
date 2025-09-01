<?php
class Car{
    private $name;
    private $speed;

    public function __construct($name){
        $this->name = $name;
        $this->speed = 0;
    }

    public function getSpeed(){
        return $this->speed;
    }

    public function accelerate($amount){
        $newSpeed = $this->getSpeed() + $amount;
        if($newSpeed > 200){
            $this->speed = 200;
        } else {
            $this->speed = $newSpeed;
        }
    }

    public function brake($amount){
        $newSpeed = $this->getSpeed() - $amount;
        if($newSpeed < 0){
            $this->speed = 0;
        } else {
            $this->speed = $newSpeed;
        }
    }

    public function displaySpeed(){
        echo "Carro: " . $this->name . " - Velocidade: " . $this->getSpeed() . " km/h<br>";
    }
}
class SportsCar extends Car {
    public function accelerate($amount){
        parent::accelerate($amount * 1.5); // Acelera 50% mais rápido
    }
    public function brake($amount){
        parent::brake($amount * 0.5); // Freia 50% mais devagar
    }
}
// teste
$sportsCar = new SportsCar("Ferrari 488 gtb");
$sportsCar->accelerate(100);
$sportsCar->displaySpeed(); // Exibe a velocidade após acelerar
$sportsCar->brake(30);
$sportsCar->displaySpeed(); // Exibe a velocidade após frear
$sportsCar->accelerate(150); // Tenta acelerar além do limite
$sportsCar->displaySpeed(); // Exibe a velocidade após tentar acelerar além do limite
?>