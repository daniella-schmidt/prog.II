<?php
class Contato{
    public $nome;
    public $telefone;
    public $email;

    public function __construct($nome, $telefone, $email){
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
    }
    public static function create($nome, $telefone, $email){
        return new Contato($nome, $telefone, $email);
    }
    public function exibirContato(){
        echo "Nome: {$this->nome} | Telefone: {$this->telefone} | Email: {$this->email}<br>";
    }
}
$contatos = [
    new Contato("Lando Norris", "11987654321", "lando.norris@email.com"),
    new Contato("Sebastian Vettel", "11912345678", "sebastian.vettel@email.com"),
    new Contato("Fernando Alonso", "11911223344", "fernando.alonso@email.com")
];
echo "<br>Lista de Contatos:<br>";
foreach($contatos as $contato){
    $contato->exibirContato();
}
?>