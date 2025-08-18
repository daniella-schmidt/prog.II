<?php
class Student{
    public $name;
    private $registration;
    private $notes;
    private $media;

    public function __construct($name, $registration, $notes){
        $this->name = $name;
        $this->registration = $registration;
        $this->notes = $notes;
        $this->calculateMedia();
    }

    public function getRegistration(){
        return $this->registration;
    }

    public function AddNotes($newNotes){
        $this->notes = array_merge($this->notes, $newNotes);
        $this->calculateMedia();
        return $this;
    }

    private function calculateMedia(){
        $this->media = array_sum($this->notes) / count($this->notes);
    }

    public function situation(){
        if($this->media >= 7){
            return "Aprovado";
        } elseif($this->media >= 5){
            return "Recuperação";
        } else {
            return "Reprovado";
        }
    }

    public function displayInfo(){
        return "\n 
        Nome: {$this->name} | 
        Matrícula: {$this->registration} | 
        Notas: " . implode(", ", $this->notes) . " | 
        Média: {$this->media} | 
        Situação: {$this->situation()}\n";
    }
}

$student1 = new Student("Jeno Lee", "230400", [8.5, 6, 9.2]);
echo $student1->AddNotes([7.5, 8])->displayInfo();

$student2 = new Student("Sung Hanbin", "230401", [5.5, 6.5, 7]);
echo $student2->AddNotes([4.5, 5])->displayInfo();   
?>