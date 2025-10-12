<?php
class Biblioteca {
    private $usuarios = [];
    private $livros = [];
    private $emprestimos = [];

    // COMPOSIÇÃO: Biblioteca cria e gerencia objetos dependentes
    public function criarUsuario($cpf, $nome, $endereco, $telefone) {
        $usuario = new Usuario($cpf, $nome, $endereco, $telefone);
        $this->usuarios[] = $usuario;
        return $usuario;
    }

    public function criarLivro($id, $titulo, $autor) {
        $livro = new Livro($id, $titulo, $autor);
        $this->livros[] = $livro;
        return $livro;
    }

    public function realizarEmprestimo($cpfUsuario, $idLivro, $dataEmprestimo) {
        $usuario = $this->buscarUsuario($cpfUsuario);
        $livro = $this->buscarLivro($idLivro);

        if (!$usuario || !$livro) {
            throw new Exception("Usuário ou livro não encontrado. CPF: $cpfUsuario, Livro ID: $idLivro");
        }

        if (!$livro->estaDisponivel()) {
            throw new Exception("Livro não disponível para empréstimo");
        }

        // COMPOSIÇÃO: Emprestimo é criado e gerenciado pela Biblioteca
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
            if ($emprestimo->getLivro()->getId() == $idLivro && 
                $emprestimo->getDataDevolucao() === null) {
                $emprestimo->setDataDevolucao($dataDevolucao);
                return $emprestimo;
            }
        }

        throw new Exception("Nenhum empréstimo ativo encontrado para este livro");
    }

    public function buscarUsuario($cpf) {
        foreach ($this->usuarios as $usuario) {
            // Comparação mais flexível
            if (trim($usuario->getCpf()) == trim($cpf)) {
                return $usuario;
            }
        }
        return null;
    }

    public function buscarLivro($id) {
        foreach ($this->livros as $livro) {
            // Converter para int para comparação
            if ($livro->getId() == intval($id)) {
                return $livro;
            }
        }
        return null;
    }

    // COMPOSIÇÃO: Ao destruir a biblioteca, todos os objetos compostos são afetados
    public function removerUsuario($cpf) {
        foreach ($this->usuarios as $key => $usuario) {
            if ($usuario->getCpf() === $cpf) {
                unset($this->usuarios[$key]);
                return true;
            }
        }
        return false;
    }

    public function removerLivro($id) {
        foreach ($this->livros as $key => $livro) {
            if ($livro->getId() === $id) {
                unset($this->livros[$key]);
                return true;
            }
        }
        return false;
    }

    // Getters para relatórios
    public function getUsuarios() { return $this->usuarios; }
    public function getLivros() { return $this->livros; }
    public function getEmprestimos() { return $this->emprestimos; }

    // Método para debug - verificar o que está cadastrado
    public function debugInfo() {
        $info = "=== DEBUG INFO ===\n";
        $info .= "Usuários cadastrados (" . count($this->usuarios) . "):\n";
        foreach ($this->usuarios as $usuario) {
            $info .= "- CPF: '" . $usuario->getCpf() . "', Nome: " . $usuario->getNome() . "\n";
        }
        
        $info .= "Livros cadastrados (" . count($this->livros) . "):\n";
        foreach ($this->livros as $livro) {
            $info .= "- ID: " . $livro->getId() . ", Título: " . $livro->getTitulo() . "\n";
        }
        
        return $info;
    }

    public function __destruct() {
        echo "Biblioteca destruída - todos os recursos liberados<br>";
    }
}
?>