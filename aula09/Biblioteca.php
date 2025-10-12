<?php
class Biblioteca {
    private $usuarios = [];
    private $livros = [];
    private $emprestimos = [];

    // AGREGAÇÃO: Biblioteca gerencia objetos independentes
    public function adicionarUsuario(Usuario $usuario) {
        $this->usuarios[] = $usuario;
    }

    public function adicionarLivro(Livro $livro) {
        $this->livros[] = $livro;
    }

    public function realizarEmprestimo($cpfUsuario, $idLivro, $dataEmprestimo) {
        $usuario = $this->buscarUsuario($cpfUsuario);
        $livro = $this->buscarLivro($idLivro);

        if (!$usuario || !$livro) {
            throw new Exception("Usuário ou livro não encontrado");
        }

        if (!$livro->estaDisponivel()) {
            throw new Exception("Livro não disponível para empréstimo");
        }

        // Criando a agregação Emprestimo
        $emprestimo = new Emprestimo($usuario, $livro, $dataEmprestimo);
        $this->emprestimos[] = $emprestimo;
        
        return $emprestimo;
    }

    public function realizarDevolucao($idLivro, $dataDevolucao) {
        $livro = $this->buscarLivro($idLivro);
        
        if (!$livro) {
            throw new Exception("Livro não encontrado");
        }

        // Encontrar empréstimo ativo para este livro
        foreach ($this->emprestimos as $emprestimo) {
            if ($emprestimo->getLivro()->getId() === $idLivro && 
                $emprestimo->getDataDevolucao() === null) {
                $emprestimo->setDataDevolucao($dataDevolucao);
                return $emprestimo;
            }
        }

        throw new Exception("Nenhum empréstimo ativo encontrado para este livro");
    }

    private function buscarUsuario($cpf) {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getCpf() === $cpf) {
                return $usuario;
            }
        }
        return null;
    }

    private function buscarLivro($id) {
        foreach ($this->livros as $livro) {
            if ($livro->getId() === $id) {
                return $livro;
            }
        }
        return null;
    }

    // Getters para relatórios
    public function getLivros() { return $this->livros; }
    public function getEmprestimos() { return $this->emprestimos; }
}
?>