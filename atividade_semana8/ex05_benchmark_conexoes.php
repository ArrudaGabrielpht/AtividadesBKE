<?php

declare(strict_types=1);

require_once 'ConexaoBanco.php';

const ARQUIVO_CONFIG = 'config/database.ini';

// Mede o tempo gasto em várias conexões novas.
function testarNovasConexoes(): array
{
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();

    for ($i = 0; $i < 50; $i++) {
        try {
            $config = parse_ini_file(ARQUIVO_CONFIG, true);
            $dados = $config['development'];

            $dsn = "pgsql:host={$dados['db_host']};";
            $dsn .= "port={$dados['db_port']};";
            $dsn .= "dbname={$dados['db_name']}";

            new PDO($dsn, $dados['db_user'], $dados['db_password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            break;
        }
    }

    return [
        microtime(true) - $inicio,
        memory_get_usage() - $memoriaInicial
    ];
}

// Mede o tempo usando a mesma conexão.
function testarSingleton(): array
{
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();

    try {
        for ($i = 0; $i < 50; $i++) {
            ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
        }
    } catch (PDOException $e) {
        echo "Erro no teste Singleton.";
    }

    return [
        microtime(true) - $inicio,
        memory_get_usage() - $memoriaInicial
    ];
}

$novas = testarNovasConexoes();
$singleton = testarSingleton();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Benchmark</title>
</head>
<body>

<h2>Comparação de conexões</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Teste</th>
        <th>Tempo</th>
        <th>Memória</th>
    </tr>

    <tr>
        <td>50 novas conexões</td>
        <td><?= number_format($novas[0], 6) ?> segundos</td>
        <td><?= $novas[1] ?> bytes</td>
    </tr>

    <tr>
        <td>50 chamadas Singleton</td>
        <td><?= number_format($singleton[0], 6) ?> segundos</td>
        <td><?= $singleton[1] ?> bytes</td>
    </tr>
</table>

</body>
</html>