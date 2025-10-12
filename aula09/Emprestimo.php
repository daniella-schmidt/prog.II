<?php
class Emprestimo {
    private $usuario;
    private $livro;
    private $dataEmprestimo;
    private $dataDevolucao;

    // AGREGAÇÃO: Emprestimo recebe objetos Usuario e Livro que existem independentemente
    public function __construct(Usuario $usuario, Livro $livro, $dataEmprestimo, $dataDevolucao = null) {
        $this->usuario = $usuario;
        $this->livro = $livro;
        $this->dataEmprestimo = $dataEmprestimo;
        $this->dataDevolucao = $dataDevolucao;

        // Agregação bidirecional
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
        $this->livro->setDisponivel(true);
    }
}

class Relatorio {
    // DEPENDÊNCIA: uso temporário de Usuario e Livro
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