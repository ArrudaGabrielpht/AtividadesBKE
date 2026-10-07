<?php

declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return 'Abaixo do peso';
    } elseif ($imc < 25) {
        return 'Normal';
    } elseif ($imc < 30) {
        return 'Sobrepeso';
    } else {
        return 'Obesidade';
    }
}

$nome = $_POST['nome'] ?? '';
$peso = $_POST['peso'] ?? '';
$altura = $_POST['altura'] ?? '';

$erro = '';
$imc = null;
$classificacao = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!is_numeric($peso) || (float)$peso < 20 || (float)$peso > 300) {
        $erro = 'O peso deve estar entre 20 e 300 kg.';
    } elseif (!is_numeric($altura) || (float)$altura < 0.5 || (float)$altura > 2.5) {
        $erro = 'A altura deve estar entre 0.5 e 2.5 metros.';
    } else {
        $imc = calcularIMC((float)$peso, (float)$altura);
        $classificacao = classificarIMC($imc);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>

    <style>
        .normal {
            color: green;
        }

        .sobrepeso {
            color: orange;
        }

        .obesidade {
            color: red;
        }

        .erro {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Calculadora de IMC</h1>

    <form method="POST">

        <label>Nome:</label>
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nome) ?>"
        >

        <br><br>

        <label>Peso (kg):</label>
        <input
            type="number"
            name="peso"
            step="0.1"
            value="<?= htmlspecialchars($peso) ?>"
        >

        <br><br>

        <label>Altura (m):</label>
        <input
            type="number"
            name="altura"
            step="0.01"
            value="<?= htmlspecialchars($altura) ?>"
        >

        <br><br>

        <button type="submit">Calcular IMC</button>

    </form>

    <?php if ($erro !== ''): ?>

        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>

    <?php if ($imc !== null): ?>

        <?php
        $classe = '';

        if ($classificacao === 'Normal') {
            $classe = 'normal';
        } elseif ($classificacao === 'Sobrepeso') {
            $classe = 'sobrepeso';
        } elseif ($classificacao === 'Obesidade') {
            $classe = 'obesidade';
        }
        ?>

        <h2 class="<?= $classe ?>">
            <?= htmlspecialchars($nome) ?>, seu IMC é:
            <?= number_format($imc, 2, ',', '.') ?>
        </h2>

        <p class="<?= $classe ?>">
            Classificação:
            <?= htmlspecialchars($classificacao) ?>
        </p>

    <?php endif; ?>

</body>

</html>