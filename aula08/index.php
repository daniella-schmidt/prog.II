<?php
require_once 'Usuario.php';
require_once 'Livro.php';
require_once 'Emprestimo.php';

$usuario1 = new Usuario("12345678900", "Maria", "Rua das Flores, 123", "99999-1111");
$usuario2 = new Usuario("98765432100", "João", "Av. Central, 456", "98888-2222");

$livro1 = new Livro(1, "O Nome da Rosa", "Umberto Eco");
$livro2 = new Livro(2, "Hamlet", "William Shakespeare");

$emprestimo1 = new Emprestimo($usuario1, $livro1, date("Y-m-d"));
$emprestimo2 = new Emprestimo($usuario2, $livro2, date("Y-m-d"));

$emprestimo1->setDataDevolucao(date("Y-m-d", strtotime("+7 days")));

// DEPENDÊNCIA (USO TEMPORÁRIO) - Relatorio usando classes temporariamente
$relatorio = new Relatorio();

// Uso temporário de Usuario e Livro - dependência real
$relatorioEmprestimo = $relatorio->gerarRelatorioEmprestimo($usuario1, $livro1, date("Y-m-d"), date("Y-m-d", strtotime("+7 days")));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
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
        .destaque {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1> Sistema da Biblioteca</h1>

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
            <tr>
                <td><?= $usuario1->getNome() ?></td>
                <td><?= $livro1->getTitulo() ?></td>
                <td><?= $emprestimo1->getDataEmprestimo() ?></td>
                <td><?= $emprestimo1->getDataDevolucao() ?? " Pendente" ?></td>
            </tr>
            <tr>
                <td><?= $usuario2->getNome() ?></td>
                <td><?= $livro2->getTitulo() ?></td>
                <td><?= $emprestimo2->getDataEmprestimo() ?></td>
                <td><?= $emprestimo2->getDataDevolucao() ?? " Pendente" ?></td>
            </tr>
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
            <tr>
                <td><?= $livro1->getTitulo() ?></td>
                <td><?= $livro1->getAutor() ?></td>
                <td><span class="status <?= $livro1->estaDisponivel() ? 'disponivel' : 'indisponivel' ?>">
                    <?= $livro1->estaDisponivel() ? " Disponível" : " Indisponível" ?>
                </span></td>
            </tr>
            <tr>
                <td><?= $livro2->getTitulo() ?></td>
                <td><?= $livro2->getAutor() ?></td>
                <td><span class="status <?= $livro2->estaDisponivel() ? 'disponivel' : 'indisponivel' ?>">
                    <?= $livro2->estaDisponivel() ? " Disponível" : " Indisponível" ?>
                </span></td>
            </tr>
        </table>
    </div>

    <div class="card">
        <h2> Histórico de Empréstimos - <?= $livro1->getTitulo() ?></h2>
        <div class="history"><?= $livro1->getHistoricoEmprestimos() ?></div>
    </div>

    <div class="card">
        <h2> Empréstimos de <?= $usuario1->getNome() ?></h2>
        <ul>
            <?php foreach ($usuario1->getEmprestimos() as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>