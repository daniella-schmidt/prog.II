<?php
class Emprestimo {
    private $usuario;
    private $livro;
    private $dataEmprestimo;
    private $dataDevolucao;

    public function __construct(Usuario $usuario, Livro $livro, $dataEmprestimo, $dataDevolucao = null) {
        $this->usuario = $usuario;
        $this->livro = $livro;
        $this->dataEmprestimo = $dataEmprestimo;
        $this->dataDevolucao = $dataDevolucao;

        $usuario->adicionarEmprestimo($this);
        $livro->adicionarEmprestimo($this);

        $livro->setDisponivel(false);
    }

    // Getters
    public function getUsuario(){ return $this->usuario; }
    public function getLivro(){ return $this->livro; }
    public function getDataEmprestimo(){ return $this->dataEmprestimo; }
    public function getDataDevolucao(){ return $this->dataDevolucao; }

    // Setters
    public function setDataDevolucao($dataDevolucao){
        $this->dataDevolucao = $dataDevolucao;
        // ao devolver, o livro fica disponível novamente
        $this->livro->setDisponivel(true);
    }

    public function __toString() {
        $livro = $this->livro->getTitulo();
        $usuario = $this->usuario->getNome();
        $dataEmp = $this->dataEmprestimo;
        $dataDev = $this->dataDevolucao ?? "Ainda não devolvido";

        return "Livro: {$livro}, Usuário: {$usuario}, Empréstimo: {$dataEmp}, Devolução: {$dataDev}";
    }
}

class Relatorio {
    public function gerarRelatorioEmprestimo(Usuario $usuario, Livro $livro, $dataEmprestimo, $dataDevolucao = null) {
        $relatorio = "\n";
        $relatorio .= "Usuário: " . $usuario->getNome() . " (CPF: " . $usuario->getCpf() . ")\n";
        $relatorio .= "Livro: " . $livro->getTitulo() . " - " . $livro->getAutor() . "\n";
        $relatorio .= "Data do Empréstimo: " . $dataEmprestimo . "\n";
        $relatorio .= "Data de Devolução: " . ($dataDevolucao ?? "Pendente") . "\n";
        $relatorio .= "Status: " . ($livro->estaDisponivel() ? "Devolvido" : "Em empréstimo") . "\n";
        
        return $relatorio;
    }
}
?>
