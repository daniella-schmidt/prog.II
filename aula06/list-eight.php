<?php
class Student {
    private $name;
    private $grade;

    public function __construct($name){
        $this->name = $name;
        $this->grade = 0;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function setGrade($grade){
        if($grade >= 0 && $grade <= 10){
            $this->grade = $grade;
        } else {
            echo "Nota inválida. Deve ser entre 0 e 10.<br>";
        }
    }

    public function displayInfo(){
        echo "Aluno: " . $this->name . " - Nota: " . $this->getGrade() . "<br>";
    }
}
class SpecialStudent extends Student {
    private $scholarship;

    public function __construct($name, $scholarship){
        parent::__construct($name); // chama o construtor da classe pai
        $this->scholarship = $scholarship;
    }

    public function getScholarship(){
        return $this->scholarship;
    }

    public function displayInfo(){
        parent::displayInfo(); // reaproveita o método da classe pai
        echo "Bolsa: " . $this->getScholarship() . "<br>";
    }
}
// Teste
$student = new SpecialStudent("Franco Colapinto", "50%");  
$student->setGrade(9);
$student->displayInfo(); // Exibe o nome, nota e bolsa do aluno especial
?>