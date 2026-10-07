<?php

declare(strict_types=1);

$produtos = [
    [
        'nome' => 'Teclado',
        'categoria' => 'Periféricos',
        'preco' => 120.00
    ],
    [
        'nome' => 'Mouse',
        'categoria' => 'Periféricos',
        'preco' => 80.00
    ],
    [
        'nome' => 'Monitor',
        'categoria' => 'Monitores',
        'preco' => 900.00
    ],
    [
        'nome' => 'Headset',
        'categoria' => 'Áudio',
        'preco' => 180.00
    ],
    [
        'nome' => 'Notebook',
        'categoria' => 'Computadores',
        'preco' => 2500.00
    ],
    [
        'nome' => 'Webcam',
        'categoria' => 'Acessórios',
        'preco' => 150.00
    ]
];

$nome = $_GET['nome'] ?? '';
$precoMaximo = $_GET['preco_maximo'] ?? '';

$resultados = array_filter($produtos, function ($produto) use ($nome, $precoMaximo) {

    $nomeOk = $nome === '' ||
        stripos($produto['nome'], $nome) !== false;

    $precoOk = $precoMaximo === '' ||
        $produto['preco'] <= (float)$precoMaximo;

    return $nomeOk && $precoOk;
});

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>

<body>

    <h1>Busca de Produtos</h1>

    <form method="GET">

        <label>Nome do produto:</label>
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nome) ?>"
        >

        <br><br>

        <label>Preço máximo:</label>
        <input
            type="number"
            name="preco_maximo"
            step="0.01"
            value="<?= htmlspecialchars($precoMaximo) ?>"
        >

        <br><br>

        <button type="submit">Buscar</button>

    </form>

    <h2>Produtos encontrados:</h2>

    <?php if (count($resultados) > 0): ?>

        <?php foreach ($resultados as $produto): ?>

            <p>
                <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                Categoria: <?= htmlspecialchars($produto['categoria']) ?><br>
                Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </p>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum produto encontrado.</p>

    <?php endif; ?>

</body>
</html>