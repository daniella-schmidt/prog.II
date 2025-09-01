<?php
class Worker{
    private $salary;
    public function __construct(){
        $this->salary = 0;
    }

    public function getSalary(){
        return $this->salary;
    }
    public function setSalary($salary){
        $this->salary = $salary;
    }
    public function displaySalary(){
        echo "Salário: " . $this->getSalary() . "<br>";
    }
}
class Manager extends Worker{
    private $bonus;
    public function __construct(){
        parent::__construct();
        $this->bonus = 0;
    }
    public function getBonus(){
        return $this->bonus;
    }
    public function setBonus($bonus){
        $this->bonus = $bonus;
        $this->setSalary($this->getSalary() + $bonus);
    }
    public function displaySalary(){
        echo "Salário com bônus: " . $this->getSalary() . "<br>";
    }
}
//teste
$manager = new Manager();
$manager->setSalary(5000);
$manager->setBonus(1500);
$manager->displaySalary(); // Exibe o salário com o bônus incluído
?>