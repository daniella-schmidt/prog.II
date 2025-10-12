<?php
class Livro {
    private $id;
    private $titulo;
    private $autor;
    private $disponivel;
    private $emprestimos;
    
    public function __construct($id, $titulo, $autor) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->disponivel = true;
        $this->emprestimos = array();
    }

     // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function estaDisponivel() { return $this->disponivel; }
    public function getEmprestimos() {
        return $this->emprestimos;
    }

    public function setDisponivel($disponivel){ return $this->disponivel=$disponivel;}

    public function adicionarEmprestimo(Emprestimo $emprestimo) {
        $this->emprestimos[] = $emprestimo;
    }

    public function getHistoricoEmprestimos() {
        $historico = "Histórico de empréstimos para '{$this->titulo}':\n";
        foreach ($this->emprestimos as $emprestimo) {
            $historico .= "- " . $emprestimo . "\n";
        }
        return $historico;
    }
}
?>