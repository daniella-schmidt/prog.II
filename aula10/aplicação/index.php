<?php
require_once 'Usuario.php';
require_once 'Livro.php';
require_once 'Emprestimo.php';
require_once 'Biblioteca.php';

// Criando biblioteca (composição: ela cria e gerencia todos os objetos)
$biblioteca = new Biblioteca();

// COMPOSIÇÃO: Biblioteca cria usuários e livros (eles não existem independentemente)
$usuario1 = $biblioteca->criarUsuario("12345678900", "Maria", "Rua das Flores, 123", "99999-1111");
$usuario2 = $biblioteca->criarUsuario("98765432100", "João", "Av. Central, 456", "98888-2222");
$usuario3 = $biblioteca->criarUsuario("98765432100", "Fabio", "Av. Central, 456", "96562-2222");

$livro1 = $biblioteca->criarLivro(1, "O Nome da Rosa", "Umberto Eco");
$livro2 = $biblioteca->criarLivro(2, "Hamlet", "William Shakespeare");
$livro3 = $biblioteca->criarLivro(3, "Odissea", "Homero");

// Realizando empréstimos através da biblioteca (composição)
try {
    $emprestimo1 = $biblioteca->realizarEmprestimo("12345678900", 1, date("Y-m-d"));
    $emprestimo2 = $biblioteca->realizarEmprestimo("98765432100", 2, date("Y-m-d"));
    $emprestimo2 = $biblioteca->realizarEmprestimo("98765432100", 3, date("Y-m-d"));
    
    // Realizando devolução
    $biblioteca->realizarDevolucao(1, date("Y-m-d", strtotime("+7 days")));
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// DEPENDÊNCIA (USO TEMPORÁRIO) - Relatorio usando classes temporariamente
$relatorio = new Relatorio();
$relatorioEmprestimo = $relatorio->gerarRelatorioEmprestimo($usuario1, $livro1, date("Y-m-d"), date("Y-m-d", strtotime("+7 days")));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Sistema com Composição</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background: #f0f2f5;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        h2 {
            color: #34495e;
            margin-bottom: 10px;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 900px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #3498db;
            color: #fff;
        }
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .status {
            font-weight: bold;
            padding: 5px 8px;
            border-radius: 5px;
        }
        .disponivel {
            color: #155724;
            background: #d4edda;
        }
        .indisponivel {
            color: #721c24;
            background: #f8d7da;
        }
        .history {
            background: #f4f6f9;
            padding: 10px;
            border-radius: 6px;
            font-family: monospace;
            white-space: pre-line;
        }
        .relatorio {
            background: #e8f4f8;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            white-space: pre-line;
            line-height: 1.4;
        }
        .info-composicao {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1> Sistema da Biblioteca - Composição</h1>
    <!-- SEÇÃO DE RELATÓRIOS - DEMONSTRANDO DEPENDÊNCIA -->
    <div class="card">
        <h2> Relatórios (Dependência/Uso Temporário)</h2>
        <h3>Relatório de Empréstimo Individual</h3>
        <div class="relatorio"><?= htmlspecialchars($relatorioEmprestimo) ?></div>
    </div>

    <div class="card">
        <h2> Empréstimos Atuais</h2>
        <table>
            <tr>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data Empréstimo</th>
                <th>Data Devolução</th>
            </tr>
            <?php foreach ($biblioteca->getEmprestimos() as $emprestimo): ?>
            <tr>
                <td><?= $emprestimo->getUsuario()->getNome() ?></td>
                <td><?= $emprestimo->getLivro()->getTitulo() ?></td>
                <td><?= $emprestimo->getDataEmprestimo() ?></td>
                <td><?= $emprestimo->getDataDevolucao() ?? " Pendente" ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2> Status dos Livros</h2>
        <table>
            <tr>
                <th>Livro</th>
                <th>Autor</th>
                <th>Status</th>
            </tr>
            <?php foreach ($biblioteca->getLivros() as $livro): ?>
            <tr>
                <td><?= $livro->getTitulo() ?></td>
                <td><?= $livro->getAutor() ?></td>
                <td><span class="status <?= $livro->estaDisponivel() ? 'disponivel' : 'indisponivel' ?>">
                    <?= $livro->estaDisponivel() ? " Disponível" : " Indisponível" ?>
                </span></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2> Histórico de Empréstimos </h2>
        <div class="history"><?= $livro1->getHistoricoEmprestimos() ?></div>
        <div class="history"><?= $livro2->getHistoricoEmprestimos() ?></div>
        <div class="history"><?= $livro3->getHistoricoEmprestimos() ?></div>
    </div>

    <div class="card">
        <h2> Demonstração de Composição</h2>
        <p><strong>Usuários no sistema:</strong> <?= count($biblioteca->getUsuarios()) ?></p>
        <p><strong>Livros no acervo:</strong> <?= count($biblioteca->getLivros()) ?></p>
        <p><strong>Empréstimos registrados:</strong> <?= count($biblioteca->getEmprestimos()) ?></p>
        
        <button onclick="demonstrarComposicao()">Demonstrar Remoção (Composição)</button>
        <div id="demo-composicao" style="margin-top: 10px; padding: 10px; background: #f8f9fa; display: none;"></div>
    </div>

    <script>
        function demonstrarComposicao() {
            const demo = document.getElementById('demo-composicao');
            demo.innerHTML = `
                <strong>Simulação de destruição:</strong><br>
                - Se a Biblioteca for destruída, todos os Usuários, Livros e Empréstimos também serão afetados<br>
                - Em composição, o objeto todo (Biblioteca) gerencia o ciclo de vida das partes<br>
                - As partes (Usuários, Livros) não existem independentemente do todo
            `;
            demo.style.display = 'block';
        }
    </script>
</body>
</html>