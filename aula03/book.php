<?php
class Livro{
    public $titulo;
    public $autor;
    public $ano;

    public function __construct($titulo, $autor, $ano){
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ano = $ano;
    }

    public function gerar(){
        return $this->ano > 2015 ? "<br>Título: {$this->titulo} | Autor: {$this->autor} | Ano: {$this->ano}<br>" : "";
    }
}
$livros = [
    new Livro("O Conto da Aia", "Margaret Atwood", 2017),
    new Livro("O Alquimista", "Paulo Coelho", 1988)
];
echo "<br>Livros:<br>";
foreach($livros as $livro){
    echo $livro->gerar();
}
?>